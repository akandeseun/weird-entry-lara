<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Validator;

class OrderController extends Controller
{
    //

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
            'cart_id' => ['required', 'integer'],
            'subtotal' => ['required'],
            'delivery_fee' => ['required'],
            'total' => ['required'],
            'shipping_address' => ['required'],
            'payment_status' => ['sometimes', 'string'],
            'order_status' => ['sometimes', 'string'],
        ])->validate();

        $order = Order::create($request->all());

        return response()->json($order);
    }

    public function getUserOrders($userId)
    {

        $orders = Order::latest()->with(['user', 'cart'])->where('user_id', $userId)->get();
    }
}
