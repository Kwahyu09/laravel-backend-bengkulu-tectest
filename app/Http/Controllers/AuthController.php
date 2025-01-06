<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function createToken(Request $request)
    {
        $user = Auth::user(); // Mengambil user yang sedang login

        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Membuat token
        $token = $user->createToken('test-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }
}
