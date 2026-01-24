<?php

namespace App\Http\Controllers;

use App\Models\TarikTunai;
use Illuminate\Support\Facades\Auth;

class PetugasHistoryTarikTunaiController extends Controller
{
    /**
     * Menampilkan semua riwayat tugas tarik tunai milik petugas yang sedang login
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi yang ditugaskan ke petugas
        $history = TarikTunai::where('petugas_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('layout.petugas.history.index', compact('history', 'user'));
    }

    /**
     * Menampilkan detail satu tugas tarik tunai
     */
    public function show($id)
    {
        $user = Auth::user();

        // Pastikan transaksi memang milik petugas ini
        $transaksi = TarikTunai::where('id', $id)
            ->where('petugas_id', $user->id)
            ->firstOrFail();

        return view('layout.petugas.history.detail', compact('transaksi', 'user'));
    }
}
