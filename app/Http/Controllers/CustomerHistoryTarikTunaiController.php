<?php

namespace App\Http\Controllers;

use App\Models\TarikTunai;
use Illuminate\Support\Facades\Auth;

class CustomerHistoryTarikTunaiController extends Controller
{
    /**
     * Menampilkan semua riwayat tarik tunai milik customer yang sedang login
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi yang dimiliki customer
        $history = TarikTunai::where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('layout.customer.tariktunai.history', compact('history', 'user'));
    }

    /**
     * Menampilkan detail satu transaksi tarik tunai
     */
    public function show($id)
    {
        $user = Auth::user();

        // Cek apakah transaksi benar milik customer
        $transaksi = TarikTunai::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('layout.customer.tariktunai.detail', compact('transaksi', 'user'));
    }
}
