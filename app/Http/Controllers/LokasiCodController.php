<?php

namespace App\Http\Controllers;

use App\Models\LokasiCod;
use Illuminate\Http\Request;

class LokasiCodController extends Controller
{
    /**
     * Menampilkan semua lokasi COD + statistik lokasi terpopuler.
     */
    public function index()
    {
        $lokasi = LokasiCod::orderBy('status', 'desc')->get();

        // Statistik berdasarkan banyaknya transaksi tarik tunai
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
        ]);

        LokasiCod::create([
            'nama_lokasi' => $request->nama_lokasi,
            'area_detail' => $request->area_detail,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'status'      => true,
        ]);

        return redirect()->back()->with('success', 'Lokasi COD berhasil ditambahkan!');
    }

    /**
     * Edit lokasi COD.
     */
    public function update(Request $request, $id)
    {
        $lokasi = LokasiCod::findOrFail($id);

        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'area_detail' => 'nullable|string|max:255',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ]);

        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi,
            'area_detail' => $request->area_detail,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
        ]);

        return redirect()->back()->with('success', 'Lokasi COD berhasil diperbarui!');
    }

    /**
     * Mengaktifkan atau menonaktifkan lokasi COD.
     */
    public function toggleStatus($id)
    {
        $lokasi = LokasiCod::findOrFail($id);

        $lokasi->status = !$lokasi->status;
        $lokasi->save();

        return redirect()->back()->with('success', 'Status lokasi COD berhasil diperbarui!');
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
