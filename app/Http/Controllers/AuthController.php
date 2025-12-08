<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:6',
        ]);
        if(Auth::attempt($request->only('email', 'password'),$request->remember)){
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }
}
