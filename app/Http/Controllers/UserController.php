<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getTotalVerifiedUsers()
    {
        $totalUsers = User::where('is_admin', false)
            ->whereNotNull('email_verified_at')
            ->count();
        return response()->json($totalUsers);
    }
}
