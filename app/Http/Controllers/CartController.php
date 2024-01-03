<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function updateCart(Request $request)
    {
        Validator::make($request->all(), [
            'items' => ['array'],
            'user_email' => ['required', 'email', 'exists:users,email']
        ])->validate();

        $itemsAmount = collect(Arr::pluck($request->items, 'price'))->sum();

        $cart = Cart::updateOrCreate([
            'user_email' => $request->user_email,
            'purchased' => false
        ], [
            'items' => $request->items,
            'items_amount' => $itemsAmount
        ]);

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

    public function currentUserCart()
    {
        $user = Auth::user()->email;

        $cart = Cart::where('user_email', $user)->where('purchased', 'false')->first();

        if (!$cart) {
            return response()->json(["message" => "User has no cart"], 400);
        }
        return response()->json($cart);
    }
}
