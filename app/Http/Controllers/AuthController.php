<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:6',
        ]);
        if(Auth::attempt($request->only('email', 'password'),$request->remember)){
            if(Auth::user()->role == 'customer'){
                return redirect('customer');
            }
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->onlyInput('email');
    }
    public function showRegisterForm()
    {
        return view('auth.register'); // Ganti dengan nama view register Anda
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim_nip' => 'required|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profile-photos', 'public');
        }

        // Create user with automatic role 'customer'
        $user = User::create([
            'nama' => $validated['nama'],
            'nim_nip' => $validated['nim_nip'],
            'email' => $validated['email'],
            'telepon' => $validated['telepon'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'role' => 'customer', // Otomatis customer
            'status' => 'verify', // Default status untuk user baru
            'password' => Hash::make($validated['password']),
            'foto' => $fotoPath,
        ]);

        return redirect('/login')->with('success', 'Registration successful! Your account is pending verification.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
