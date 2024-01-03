<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Notification;
use Validator;

class OrderController extends Controller
{
    //Todo: Paginate endpoints responses

    public function create(Request $request)
    {
        // ToDO: Comeback to the error message validation
        $errorMessage = ['payment_ref.unique' => 'payment reference already exists'];

        Validator::make($request->all(), [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'cart_id' => ['required', 'string', 'exists:carts,id'],
            'subtotal' => ['required'],
            'delivery_fee' => ['required'],
            'total' => ['required'],
            'shipping_address' => ['required', 'string'],
            'payment_ref' => ['required'],
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
        $order = Order::where('id', $idOrRef)->orWhere('order_reference', $idOrRef)->get();

        return response()->json($order);
    }

    public function getUserOrders($userId)
    {
        // Todo: sort orders based on statuses

        $orders = Order::latest()->with(['user', 'cart'])->where('user_id', $userId)->get();

        return response()->json($orders);
    }

    // Todo: sort based on query parameters
    public function getAllOrders()
    {
        $orders = Order::latest()->with(['cart'])->get();

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

    public function markAsSuccessful($paymentReference)
    {
        $order = Order::where('payment_ref', $paymentReference)->firstOrFail();

        $order->update([
            'payment_status' => 'success',
            'order_status' => 'confirmed'
        ]);

        // mark cart as purchased
        $cart = Cart::where('id', $order->cart_id)->update(['purchased' => true]);

        // ToDo: send mail to admins upon successful payment/order
        $admins = User::where('is_admin', true);
        Notification::send($admins, new NewOrder($order));

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
