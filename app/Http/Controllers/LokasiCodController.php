<?php

namespace App\Http\Controllers;

use App\Models\LokasiCod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LokasiCodController extends Controller
{
    /**
     * Menampilkan semua lokasi COD + statistik lokasi terpopuler.
     */
    public function index()
    {
        $lokasi = LokasiCod::orderBy('status', 'desc')->get();
        $statistik = LokasiCod::withCount('tarikTunai')
            ->orderBy('tarik_tunai_count', 'desc')
            ->take(5)
            ->get();

        return view('layout.admin.lokasi.index', compact('lokasi', 'statistik'));
    }

    /**
     * Menambah lokasi COD baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'area_detail' => 'nullable|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_lokasi' => $request->nama_lokasi,
            'area_detail' => $request->area_detail,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => true,
        ];

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('lokasi-cod', 'public');
        }

        LokasiCod::create($data);

        return back()->with('success', 'Lokasi COD berhasil ditambahkan!');
    }

    /**
     * Update lokasi COD.
     */
    public function update(Request $request, $id)
    {
        $lokasi = LokasiCod::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'area_detail' => 'nullable|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nama_lokasi' => $request->nama_lokasi,
            'area_detail' => $request->area_detail,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
        ];

        // Update gambar jika ada file baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lokasi->gambar && Storage::disk('public')->exists($lokasi->gambar)) {
                Storage::disk('public')->delete($lokasi->gambar);
            }
            
            $data['gambar'] = $request->file('gambar')->store('lokasi-cod', 'public');
        }

        $lokasi->update($data);

        return back()->with('success', 'Lokasi COD berhasil diperbarui!');
    }

    /**
     * Hapus gambar lokasi COD.
     */
    public function hapusGambar($id)
    {
        $lokasi = LokasiCod::findOrFail($id);

        if ($lokasi->gambar && Storage::disk('public')->exists($lokasi->gambar)) {
            Storage::disk('public')->delete($lokasi->gambar);
            
            $lokasi->update(['gambar' => null]);
            
            return back()->with('success', 'Gambar berhasil dihapus!');
        }

        return back()->with('error', 'Tidak ada gambar untuk dihapus!');
    }

    /**
     * Aktif / Nonaktif lokasi COD.
     */
    public function toggleStatus($id)
    {
        $lokasi = LokasiCod::findOrFail($id);
        $lokasi->update([
            'status' => !$lokasi->status
        ]);

        return back()->with('success', 'Status lokasi COD berhasil diperbarui!');
    }

    /**
     * Hapus lokasi COD.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $lokasi = LokasiCod::findOrFail($id);
            
            // Hapus file gambar jika ada
            if ($lokasi->gambar && Storage::disk('public')->exists($lokasi->gambar)) {
                Storage::disk('public')->delete($lokasi->gambar);
            }
            
            $lokasi->delete();
            
            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lokasi COD berhasil dihapus!'
                ]);
            }
            
            return redirect()->route('admin.lokasi.index')
                ->with('success', 'Lokasi COD berhasil dihapus!');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus lokasi COD: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menghapus lokasi COD: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan statistik lokasi terpopuler (lebih detail).
     */
    public function statistik()
    {
        $statistik = LokasiCod::withCount('tarikTunai')
            ->orderBy('tarik_tunai_count', 'desc')
            ->get();

        return view('layout.admin.lokasi.statistik', compact('statistik'));
    }
}