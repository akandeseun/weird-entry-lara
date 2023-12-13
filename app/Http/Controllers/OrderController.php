<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    //Todo: Paginate endpoints responses

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'cart_id' => ['required', 'integer', 'exists:carts,id'],
            'subtotal' => ['required'],
            'delivery_fee' => ['required'],
            'total' => ['required'],
            'shipping_address' => ['required'],
            'payment_ref' => ['required'],
            'payment_status' => ['sometimes', 'string'],
            'order_status' => ['sometimes', 'string']
        ])->validate();

        $order = Order::create($request->all());

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
        $orders = Order::latest()->with(['cart', 'with'])->get();

        return response()->json($orders);
    }

    public function updateOrderStatus(Request $request)
    {
        $validStatuses = ['processing', 'shipped', 'delivered', 'cancelled', 'unconfirmed'];

        $status = implode(',', $validStatuses,);

        $errorMessage = ['order_status.in' => "Valid statuses:{$status}"];

        Validator::make($request->all(), [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'order_status' => ['required', "in:{$status}"]
        ])->validate();

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
    }
}
