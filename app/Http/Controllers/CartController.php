<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        Validator::make($request->all(), [
            'product_id' => ['required', 'integer', 'exists:products,id']
        ])->validate();
        $user = Auth::user();

        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id
        ]);

        return response()->json($cart);
    }

    public function getUserCart()
    {
        $cart = Cart::where('user_id', Auth::id())->get();

        $cart->load('products');

        return response()->json($cart);
    }
}
