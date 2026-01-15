<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:50',
            'password' => 'required|string|min:6',
        ]);
        if(Auth::attempt($request->only('email', 'password'),$request->remember)){
            if(Auth::user()->role == 'petugas')return redirect('/petugas');
            if(Auth::user()->role =='customer')return redirect('/customer');
                return redirect('/dashboard');
            }
            return back()->with('failed','Login gagal, silahkan periksa kembali email dan password anda!');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim_nip' => 'nullable|string|max:20|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('profile-photos', 'public');
        }

        $data = $validated;
        $data['password'] = bcrypt($validated['password']);
        $data['status'] = 'verify';
        $data['foto'] = $fotoPath;

        $user = User::create($data);

        Auth::login($user);

        return redirect('/verify');
    }
    
    public function google_redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function google_callback()
    {
       $googleUser = Socialite::driver('google')->user();
       $user = User::where('email', $googleUser->email)->first();
       if(!$user){
        $user = User::create([
            'nama' => $googleUser->name,
            'email' => $googleUser->email,
            'status' => 'active',
        ]);
       }
       if($user && $user->status =='banned'){
        return redirect('/login')->with('failed','Akun Anda diblokir. Silakan hubungi admin.');
       }
       Auth::login($user);
       if($user->role =='customer') return redirect('/customer');
    }

    public function logout()
    {
        Auth::logout(Auth::user());
        return redirect('/login');
    }
}
