<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Mail\NewOrder;
use App\Mail\OrderConfirmation;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Notifications\CustomerOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Validator;


class OrderController extends Controller
{
    //Todo: Paginate endpoints responses
    //Todo: Feature: Admin cancel order, give reasons to customer


    public function create(Request $request)
    {
        // ToDo: Comeback to the error message validation
        $errorMessage = ['payment_ref.unique' => 'payment reference already exists'];

        Validator::make($request->all(), [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'cart_id' => ['required', 'string', 'exists:carts,id'],
            'subtotal' => ['required'],
            'delivery_fee' => ['required'],
            'total' => ['required'],
            'shipping_address' => ['required', 'string'],
            'payment_ref' => ['required', 'unique:orders,payment_ref'],
            'payment_status' => ['sometimes', 'string'],
            'order_status' => ['sometimes', 'string']
        ], $errorMessage)->validate();

        $cartTotal = Cart::where('id', $request->cart_id)->value('items_amount');
        $orderItemsTotal = $cartTotal + $request->delivery_fee;

        // ToDo: Remove cause in response after frontend has tested/implemented
        if ($orderItemsTotal !== $request->total) {
            return response()->json([
                "message" => "Order not created",
                "cause" => "Discrepancies in Order Details"
            ]);
        }

        $order = Order::create($request->all());

        return response()->json([$order]);
    }

    public function getOrder(string $idOrRef)
    {
        $order = Order::with(['cart', 'user'])->where('id', $idOrRef)->orWhere('order_reference', $idOrRef)->firstOrFail();

        return response()->json($order);
    }

    public function getCurrentUserOrders(Request $request)
    {
        $userId = Auth::id();

        $validStatuses = 'processing,shipped,delivered,cancelled,unconfirmed,confirmed';
        $errorMessage = ['order_status.in' => "Valid statuses: ($validStatuses)"];

        Validator::make($request->all(), [
            'order_status' => ['sometimes', "in:$validStatuses"]
        ], $errorMessage)->validate();

        $orders = Order::latest()->with(['user', 'cart'])->where('user_id', $userId);

        // sort orders based on status
        if ($request->order_status) {
            return $orders->where('order_status', $request->order_status)->get();
        }
        $orders->get();

        return response()->json($orders);
    }

    public function getUserOrders($userId)
    {
        $orders = Order::latest()->with(['user', 'cart'])->where('user_id', $userId)->get();

        return response()->json($orders);
    }

    // Todo: sort based on query parameters
    public function getAllOrders()
    {
        $orders = Order::with(['cart'])->latest()->paginate(15);

        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request)
    {
        $validStatuses = ['processing', 'shipped', 'delivered', 'cancelled', 'unconfirmed', 'confirmed'];

        $status = implode(',', $validStatuses,);

        $errorMessage = ['order_status.in' => "Valid statuses:{$status}"];

        Validator::make($request->all(), [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'order_status' => ['required', "in:{$status}"]
        ], $errorMessage)->validate();

        $order = Order::where('id', $request->order_id);

        $order->update([
            'order_status' => $request->order_status
        ]);

        // Todo: add features for when order is cancelled/ confirmed or shipped

        return response()->json([
            "message" => "Order status updated",
            $order
        ]);
    }

    public function notifyAdmins(Order $order)
    {
        $admins = User::where('is_admin', true);
    }

    public function markAsSuccessful($paymentReference)
    {
        $order = Order::with(['user', 'cart'])->where('payment_ref', $paymentReference)->first();

        $admins = collect(User::where('is_admin', true)->get());

        $order->update([
            'payment_status' => 'success',
            'order_status' => 'confirmed'
        ]);

        // mark cart as purchased
        $cart = Cart::where('id', $order->cart_id);
        $cart->update(['purchased' => true]);

        // Dispatch Event
        // OrderPlaced::dispatch($order, $cart);
        // event(new OrderPlaced($order, $cart));

        // check if it works
        Mail::to($order->user)->queue(new OrderConfirmation($order));
        Mail::to(env("ADMIN_MAIL"))->queue(new NewOrder($order));

        // // send email to admins about new order

        // Notification::send($admins, new NewOrder($order));

        // // $order->user->notify();
        // Notification::sendNow($order->user, new CustomerOrderNotification($order, $cart));


        // ToDo: include column for tracking the number of orders a certain product has recieved

    }

    // Handle Payments
    public function paystackWebhook(Request $request)
    {
        $requestBody = @file_get_contents("php://input");
        $secret = env('PAYSTACK_SECRET');

        $hash = hash_hmac('sha512', $requestBody, $secret);
        $paystackHash = $request->header('x-paystack-signature');

        if ($hash === $paystackHash) {
            $reference = $request->input('data.reference');
            $status = $request->input('data.status');

            if ($status == "success") {
                $this->markAsSuccessful($reference);
            }
        }
    }
}
