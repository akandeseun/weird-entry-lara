<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function getAllTransactions()
    {
        $response = Http::withToken(env('PAYSTACK_SECRET'))->get('https://api.paystack.co/transaction');

        return response()->json(json_decode($response->body()));
    }

    public function getTotalTransactions()
    {
        $response = Http::withToken(env('PAYSTACK_SECRET'))->get('https://api.paystack.co/transaction/totals');

        return response()->json(json_decode($response->body()));
    }
}
