<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerProfileController extends Controller
{
    public function index()
{
    if (Auth::user()->role !== 'customer') {
        abort(403);
    }

    $user = Auth::user();
    return view('layout.customer.profile.index', compact('user'));
}


    /**
     * Menampilkan halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('layout.customer.profile.edit', compact('user'));
    }

    /**
     * Update nama user
     */
    public function updateNama(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
        ]);

        try {
            // Update nama
            User::where('id', $user->id)->update([
                'nama' => $request->nama
            ]);
            
            return redirect()->route('profile.edit')
                ->with('success', 'Nama berhasil diperbarui')
                ->with('tab', 'nama');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui nama: ' . $e->getMessage())
                ->with('tab', 'nama')
                ->withInput();
        }
    }

    /**
     * Upload foto profil
     */
    public function uploadFoto(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'foto.required' => 'Pilih foto terlebih dahulu',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('tab', 'foto')
                ->withInput();
        }

        try {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/profile-photos/' . $user->foto)) {
                Storage::delete('public/profile-photos/' . $user->foto);
            }
            
            // Upload foto baru
            $foto = $request->file('foto');
            $filename = 'customer_' . $user->id . '_' . time() . '.' . $foto->getClientOriginalExtension();
            
            // Simpan foto
            $path = $foto->storeAs('public/storage/profile-photos', $filename);
            
            if ($path) {
                // Update database
                User::where('id', $user->id)->update([
                    'foto' => $filename
                ]);
                
                return redirect()->route('profile.edit')
                    ->with('success', 'Foto profil berhasil diupload')
                    ->with('tab', 'foto');
            } else {
                throw new \Exception('Gagal menyimpan file');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengupload foto: ' . $e->getMessage())
                ->with('tab', 'foto')
                ->withInput();
        }
    }

    /**
     * Hapus foto profil
     */
    public function hapusFoto()
    {
        $user = Auth::user();
        
        if (!$user->foto) {
            return redirect()->route('profile.edit')
                ->with('error', 'Tidak ada foto profil')
                ->with('tab', 'foto');
        }
        
        try {
            // Hapus file dari storage
            if (Storage::exists('public/profile-photos/' . $user->foto)) {
                Storage::delete('public/profile-photos/' . $user->foto);
            }
            
            // Update database
            User::where('id', $user->id)->update([
                'foto' => null
            ]);
            
            return redirect()->route('profile.edit')
                ->with('success', 'Foto profil berhasil dihapus')
                ->with('tab', 'foto');
                
        } catch (\Exception $e) {
            return redirect()->route('profile.edit')
                ->with('error', 'Gagal menghapus foto: ' . $e->getMessage())
                ->with('tab', 'foto');
        }
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        // Validasi input
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
                ->with('tab', 'password')
                ->withInput();
        }

        try {
            // Cek password saat ini
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->with('error', 'Password saat ini salah')
                    ->with('tab', 'password')
                    ->withInput();
            }

            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return redirect()->route('profile.edit')
                ->with('success', 'Password berhasil diubah')
                ->with('tab', 'password');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah password: ' . $e->getMessage())
                ->with('tab', 'password')
                ->withInput();
        }
    }
}