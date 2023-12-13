<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function updateCart(Request $request)
    {
        Validator::make($request->all(), [
            'items' => ['required', 'array'],
            'items_amount' => ['required', 'integer'],
            'user_email' => ['required', 'email']
        ])->validate();

        $cart = Cart::updateOrCreate([
            'user_email' => $request->user_email,
            'purchased' => false
        ], $request->all());

        return response()->json($cart);
    }

    public function getUserCart(Request $request)
    {

        Validator::make($request->all(), [
            'user_email' => ['required', 'email']
        ])->validate();

        $cart = Cart::with(['user'])->where('user_email', $request->user_email)->where('purchased', 'false')->get();

        return response()->json($cart);
    }

    public function getAllCarts()
    {
        $carts = Cart::with(['user'])->get();

        return response()->json($carts);
    }
}
