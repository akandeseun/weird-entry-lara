<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function overviewStats()
    {
        $pendingOrders = Order::where('order_status', 'pending')->count();
        $completedOrders = Order::where('order_status', 'completed')->count();
        $totalUsers = User::where('is_admin', false)
            ->whereNotNull('email_verified_at')
            ->count();
        $response = Http::withToken(env('PAYSTACK_SECRET'))->get('https://api.paystack.co/transaction/totals');
        $totalTransactions = json_decode($response->body());

        return response()->json([
            "pendingOrders" => $pendingOrders,
            "completedOrders" => $completedOrders,
            "totalUsers" => $totalUsers,
            "totalTransactions" => $totalTransactions->data->total_volume
        ]);
    }
}
