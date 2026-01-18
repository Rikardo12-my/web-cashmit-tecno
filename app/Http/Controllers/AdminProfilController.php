<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminProfileController extends Controller
{
    /**
     * Menampilkan halaman profil admin
     */
    public function index()
    {
        $user = Auth::user();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        
        return view('admin.profile.index', compact('user', 'totalCustomers', 'totalPetugas', 'totalAdmins'));
    }

    /**
     * Menampilkan form edit profil admin
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update profil admin
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telepon' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:500',
            'tanggal_lahir' => 'nullable|date',
            'nim_nip' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'telepon.required' => 'Nomor telepon wajib diisi',
            'nim_nip.required' => 'NIP/NIK wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
            'current_password.required_with' => 'Password saat ini wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validasi password saat ini jika ingin mengubah password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->with('error', 'Password saat ini salah')
                    ->withInput();
            }
        }

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nim_nip' => $request->nim_nip,
        ];

        // Update password jika diisi
        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->new_password);
        }

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/foto-profil/' . $user->foto)) {
                Storage::delete('public/foto-profil/' . $user->foto);
            }
            
            $foto = $request->file('foto');
            $filename = 'admin_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto-profil', $filename);
            $data['foto'] = $filename;
        }

        $user->update($data);

        // Log aktivitas (jika ada fitur logging)
        // activity()->log('Admin ' . $user->nama . ' memperbarui profil');

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil admin berhasil diperbarui');
    }

    /**
     * Hapus foto profil admin
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->foto && Storage::exists('public/foto-profil/' . $user->foto)) {
            Storage::delete('public/foto-profil/' . $user->foto);
            $user->update(['foto' => null]);
            
            // Log aktivitas
            // activity()->log('Admin ' . $user->nama . ' menghapus foto profil');
            
            return redirect()->route('admin.profile.edit')
                ->with('success', 'Foto profil berhasil dihapus');
        }
        
        return redirect()->route('admin.profile.edit')
            ->with('error', 'Foto profil tidak ditemukan');
    }

    /**
     * Menampilkan form ubah password
     */
    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update password admin
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Cek password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'Password saat ini salah')
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Log aktivitas
        // activity()->log('Admin ' . $user->nama . ' mengubah password');

        return redirect()->route('admin.profile.index')
            ->with('success', 'Password admin berhasil diubah');
    }

    /**
     * Menampilkan halaman pengaturan sistem (hanya untuk admin)
     */
    public function systemSettings()
    {
        // Hanya admin super yang bisa akses
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
        
        $settings = [
            'site_name' => config('app.name'),
            'maintenance_mode' => config('app.maintenance', false),
            'registration_open' => true,
            'max_file_size' => 2048, // 2MB
        ];
        
        return view('admin.profile.system-settings', compact('settings'));
    }

    /**
     * Update pengaturan sistem
     */
    public function updateSystemSettings(Request $request)
    {
        // Validasi permission
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
        
        // Implementasi update settings
        // Bisa menggunakan database atau config file
        
        return redirect()->route('admin.profile.system-settings')
            ->with('success', 'Pengaturan sistem berhasil diperbarui');
    }

    /**
     * Menampilkan daftar log aktivitas sistem
     */
    public function systemLogs()
    {
        // Hanya admin yang bisa akses
        if ($user->role !== 'admin') {
            abort(403, 'Akses ditolak');
        }
        
        // Ambil data logs dari database atau file
        $logs = []; // Implementasi sesuai kebutuhan
        
        return view('admin.profile.system-logs', compact('logs'));
    }
}