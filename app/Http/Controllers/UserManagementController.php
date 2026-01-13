<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserManagementController extends Controller
{
    /**
     * Daftar semua customer.
     */
    public function listCustomer()
    {
        $customers = User::where('role', 'customer')->get();
        $todayCount = User::where('role', 'customer')
                         ->whereDate('created_at', Carbon::today())
                         ->count();
        $activeCount = User::where('role', 'customer')
                          ->where('status', 'active')
                          ->count();
        $bannedCount = User::where('role', 'customer')
                          ->where('status', 'banned')
                          ->count();
        
        return view('layout.admin.users.customer', compact(
            'customers', 
            'todayCount',
            'activeCount',
            'bannedCount'
        ));
    }

    /**
     * Daftar semua petugas.
     */
    public function listPetugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        $todayCount = User::where('role', 'petugas')
                         ->whereDate('created_at', Carbon::today())
                         ->count();
        $activeCount = User::where('role', 'petugas')
                          ->where('status', 'active')
                          ->count();
        $bannedCount = User::where('role', 'petugas')
                          ->where('status', 'banned')
                          ->count();
        
        return view('layout.admin.users.petugas', compact(
            'petugas',
            'todayCount',
            'activeCount',
            'bannedCount'
        ));
    }

    /**
     * Form tambah user.
     */
    public function create()
    {
        return view('layout.admin.users.create');
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nim_nip' => 'required|unique:users,nim_nip',
            'password' => 'required|min:6',
            'role' => 'required|in:customer,petugas,admin',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nim_nip' => $request->nim_nip,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 'active',
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Suspend user.
     */
    public function suspend($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'banned';
        $user->save();

        return redirect()->back()->with('success', 'User telah disuspend');
    }

    /**
     * Mengaktifkan kembali user.
     */
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active';
        $user->save();

        return redirect()->back()->with('success', 'User telah diaktifkan kembali');
    }

    /**
     * Ubah role user.
     */
    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:customer,petugas,admin'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->back()->with('success', 'Role user berhasil diupdate');
    }

}