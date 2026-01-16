<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PetugasController extends Controller
{
    /**
     * Display a listing of petugas.
     */
    public function index()
    {
        $petugas = User::where('role', 'petugas')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPetugas = $petugas->count();
        $activePetugas = User::where('role', 'petugas')->where('status', 'active')->count();
        $bannedPetugas = User::where('role', 'petugas')->where('status', 'banned')->count();
        $verifyPetugas = User::where('role', 'petugas')->where('status', 'verify')->count();

        return view('layout.admin.petugas.index', compact(
            'petugas',
            'totalPetugas',
            'activePetugas',
            'bannedPetugas',
            'verifyPetugas' // Tambahkan ini
        ));
    }

    /**
     * Show the form for creating a new petugas.
     */
    public function create()
    {
        return view('layout.admin.petugas.create');
    }

    /**
     * Store a newly created petugas in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'nim_nip' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Handle foto upload
        // Di method store() dan update()
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');

            // Bersihkan nama file: hapus spasi dan karakter khusus
            $originalName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $foto->getClientOriginalExtension();

            // Hapus karakter tidak aman untuk URL
            $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName); // Ganti spasi & karakter khusus dengan underscore
            $cleanName = strtolower($cleanName); // Ubah ke lowercase

            $fotoName = time() . '_' . $cleanName . '.' . $extension;
            $fotoPath = $foto->storeAs('petugas', $fotoName, 'public');
            $validated['foto'] = $fotoPath;
        }

        // Set default values untuk petugas
        $validated['role'] = 'petugas';
        $validated['status'] = 'active'; // Langsung aktif ketika dibuat oleh admin
        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now(); // Langsung verifikasi email

        // Create petugas
        User::create($validated);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan dan langsung aktif.');
    }

    /**
     * Display the specified petugas.
     */
    public function show($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        return view('layout.admin.petugas.show', compact('petugas'));
    }

    /**
     * Show the form for editing the specified petugas.
     */
    public function edit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        return view('layout.admin.petugas.edit', compact('petugas'));
    }

    /**
     * Update the specified petugas in storage.
     */
    public function update(Request $request, $id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($petugas->id),
            ],
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'nim_nip' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Di method store() dan update()
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');

            // Bersihkan nama file: hapus spasi dan karakter khusus
            $originalName = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $foto->getClientOriginalExtension();

            // Hapus karakter tidak aman untuk URL
            $cleanName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName); // Ganti spasi & karakter khusus dengan underscore
            $cleanName = strtolower($cleanName); // Ubah ke lowercase

            $fotoName = time() . '_' . $cleanName . '.' . $extension;
            $fotoPath = $foto->storeAs('petugas', $fotoName, 'public');
            $validated['foto'] = $fotoPath;
        }

        // Handle foto removal
        if ($request->has('remove_foto') && $request->remove_foto == '1') {
            if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
                Storage::disk('public')->delete($petugas->foto);
            }
            $validated['foto'] = null;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update petugas
        $petugas->update($validated);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Data petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified petugas from storage.
     */
    public function destroy($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        // JANGAN hapus foto saat soft delete
        // Foto akan tetap tersimpan di storage

        // Soft delete petugas saja
        $petugas->delete();

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil dihapus.');
    }

    /**
     * Ban a petugas account.
     */
    public function ban($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $petugas->update([
            'status' => 'banned'
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil dibanned.');
    }

    /**
     * Activate a petugas account.
     */
    public function activate($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $petugas->update([
            'status' => 'active'
        ]);

        return redirect()->route('admin.petugas.index')
            ->with('success', 'Petugas berhasil diaktifkan.');
    }

    /**
     * Get petugas statistics (API endpoint if needed)
     */
    public function statistics()
    {
        $stats = [
            'total' => User::where('role', 'petugas')->count(),
            'active' => User::where('role', 'petugas')->where('status', 'active')->count(),
            'banned' => User::where('role', 'petugas')->where('status', 'banned')->count(),
            'verify' => User::where('role', 'petugas')->where('status', 'verify')->count(),
            'deleted' => User::where('role', 'petugas')->onlyTrashed()->count(),
        ];

        return response()->json($stats);
    }

    public function deleted()
    {
        $deletedPetugas = User::where('role', 'petugas')
            ->onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        // Debug setiap petugas
        foreach ($deletedPetugas as $petugas) {
            if ($petugas->foto) {
                Log::info("Deleted Petugas ID {$petugas->id}:");
                Log::info("  - Foto path: {$petugas->foto}");
                Log::info("  - Storage exists: " . (Storage::disk('public')->exists($petugas->foto) ? 'YES' : 'NO'));
                Log::info("  - Storage URL: " . Storage::url($petugas->foto));
                Log::info("  - Full path: " . storage_path('app/public/' . $petugas->foto));

                // Cek file fisik
                $fullPath = storage_path('app/public/' . $petugas->foto);
                Log::info("  - File exists: " . (file_exists($fullPath) ? 'YES' : 'NO'));
            }
        }

        $totalDeleted = $deletedPetugas->count();

        return view('layout.admin.petugas.delete', compact('deletedPetugas', 'totalDeleted'));
    }


    public function restore($id)
    {
        $petugas = User::where('role', 'petugas')
            ->onlyTrashed()
            ->findOrFail($id);

        // Cek apakah foto masih ada sebelum restore
        if ($petugas->foto) {
            $imageExists = Storage::disk('public')->exists($petugas->foto);

            if (!$imageExists) {
                // Jika foto tidak ada, set null
                $petugas->foto = null;
                $petugas->save();

                Log::warning("Foto petugas ID {$id} tidak ditemukan saat restore: {$petugas->foto}");
            }
        }

        $petugas->restore();

        // Jika request AJAX, return JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Petugas berhasil dipulihkan.'
            ]);
        }

        return redirect()->route('admin.petugas.deleted')
            ->with('success', 'Petugas berhasil dipulihkan.');
    }


    public function forceDelete($id)
    {
        $petugas = User::where('role', 'petugas')
            ->onlyTrashed()
            ->findOrFail($id);

        // Hapus foto hanya saat force delete
        if ($petugas->foto && Storage::disk('public')->exists($petugas->foto)) {
            Storage::disk('public')->delete($petugas->foto);
        }

        $petugas->forceDelete();

        // Jika request AJAX, return JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Petugas berhasil dihapus permanen.'
            ]);
        }

        return redirect()->route('admin.petugas.deleted')
            ->with('success', 'Petugas berhasil dihapus permanen.');
    }
}
