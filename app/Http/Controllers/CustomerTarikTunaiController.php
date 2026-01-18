<?php

namespace App\Http\Controllers;

use App\Models\TarikTunai;
use App\Models\PaymentMethod;
use App\Models\LokasiCod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomerTarikTunaiController extends Controller
{
    public function index()
    {
        $tarikTunais = TarikTunai::with(['petugas', 'paymentMethod', 'lokasiCod'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $activeCount = TarikTunai::where('user_id', Auth::id())
            ->whereNotIn('status', ['selesai','dibatalkan_customer','dibatalkan_admin'])
            ->count();

        $completedTransactions = TarikTunai::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->get();

        $totalTransaksi = $completedTransactions->sum('jumlah');
        $totalBiayaAdmin = $completedTransactions->sum('biaya_admin');
        $totalDibayar = $completedTransactions->sum('total_dibayar');

        return view('layout.customer.tariktunai.index', compact(
            'tarikTunais', 
            'activeCount',
            'totalTransaksi',
            'totalBiayaAdmin',
            'totalDibayar'
        ));
    }

    public function create()
    {
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $lokasiCod = LokasiCod::where('status', true)->get();

        $paymentMethodsByCategory = [
            'bank_qris' => $paymentMethods->where('kategori', 'bank_qris')->values(),
            'qris_cod' => $paymentMethods->where('kategori', 'qris_cod')->values(),
            'e_wallet' => $paymentMethods->where('kategori', 'e_wallet')->values(),
        ];

        $activeCount = TarikTunai::where('user_id', Auth::id())
            ->whereNotIn('status', ['selesai','dibatalkan_customer','dibatalkan_admin'])
            ->count();

        $completedCount = TarikTunai::where('user_id', Auth::id())
            ->where('status', 'selesai')
            ->count();

        return view('layout.customer.tariktunai.create', compact(
            'paymentMethodsByCategory', 
            'paymentMethods',
            'lokasiCod',
            'activeCount',
            'completedCount'
        ));
    }

    public function getQrisImage($id)
    {
        try {
            $paymentMethod = PaymentMethod::find($id);
            
            if (!$paymentMethod) {
                return response()->json([
                    'error' => 'Metode pembayaran tidak ditemukan'
                ], 404);
            }
            
            if (!$paymentMethod->qris_image) {
                return response()->json([
                    'error' => 'QRIS tidak tersedia untuk metode pembayaran ini'
                ], 404);
            }
            
            // Generate URL yang benar
            $qrisPath = $paymentMethod->qris_image;
            if (!Storage::disk('public')->exists($qrisPath)) {
                return response()->json([
                    'error' => 'File QRIS tidak ditemukan di server'
                ], 404);
            }
            
            $qrisUrl = Storage::url($qrisPath);
            
            return response()->json([
                'success' => true,
                'qris_image' => $qrisUrl,
                'nama' => $paymentMethod->nama,
                'account_name' => $paymentMethod->account_name,
                'account_number' => $paymentMethod->account_number,
                'deskripsi' => $paymentMethod->deskripsi,
                'kategori' => $paymentMethod->kategori
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getLocationImage($id)
    {
        try {
            $lokasi = LokasiCod::find($id);
            
            if (!$lokasi) {
                return response()->json(['error' => 'Lokasi tidak ditemukan'], 404);
            }
            
            if (!$lokasi->gambar) {
                return response()->json([
                    'error' => 'Gambar lokasi tidak tersedia',
                    'lokasi' => $lokasi->nama_lokasi
                ], 404);
            }
            
            $gambarPath = $lokasi->gambar;
            if (!Storage::disk('public')->exists($gambarPath)) {
                return response()->json([
                    'error' => 'File gambar lokasi tidak ditemukan di server'
                ], 404);
            }
            
            $gambarUrl = Storage::url($gambarPath);
            
            return response()->json([
                'success' => true,
                'gambar' => $gambarUrl,
                'nama_lokasi' => $lokasi->nama_lokasi,
                'alamat' => $lokasi->alamat,
                'area_detail' => $lokasi->area_detail,
                'latitude' => $lokasi->latitude,
                'longitude' => $lokasi->longitude,
                'jam_operasional' => $lokasi->jam_operasional,
                'telepon' => $lokasi->telepon
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan server',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $activeCount = TarikTunai::where('user_id', Auth::id())
            ->whereNotIn('status', ['selesai','dibatalkan_customer','dibatalkan_admin'])
            ->count();

        if ($activeCount >= 3) {
            return back()->with('error', 'Maaf, Anda masih memiliki ' . $activeCount . ' transaksi aktif. Maksimal 3 transaksi aktif dalam waktu bersamaan.');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'lokasi_cod_id' => 'required|exists:lokasi_cod,id',
        ]);

        $kodeTransaksi = 'TT-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

        TarikTunai::create([
            'kode_transaksi' => $kodeTransaksi,
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'biaya_admin' => 0,
            'total_dibayar' => $request->jumlah,
            'payment_method_id' => $request->payment_method_id,
            'lokasi_cod_id' => $request->lokasi_cod_id,
            'status' => 'menunggu_admin',
        ]);

        return redirect()->route('customer.tariktunai.index')
            ->with('success', 'Permintaan tarik tunai berhasil diajukan. Kode transaksi: ' . $kodeTransaksi);
    }

public function show(TarikTunai $tarikTunai)
{
    if ($tarikTunai->user_id != Auth::id()) abort(403);
    
    $tarikTunai->load(['paymentMethod', 'lokasiCod', 'petugas']);
    
    return view('layout.customer.tariktunai.show', compact('tarikTunai'));
}

   public function uploadBukti(Request $request, TarikTunai $tarikTunai)
{
    if ($tarikTunai->user_id != Auth::id()) abort(403);

    if ($tarikTunai->biaya_admin <= 0) {
        return back()->with('error', 'Transaksi belum dapat dibayar. Biaya admin belum ditentukan oleh Admin.');
    }

    if ($tarikTunai->status != 'menunggu_pembayaran') {
        return back()->with('error', 'Tidak bisa upload bukti pada status ini.');
    }

    $request->validate([
        'bukti_bayar_customer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Hapus bukti lama jika ada
    if ($tarikTunai->bukti_bayar_customer) {
        Storage::disk('public')->delete($tarikTunai->bukti_bayar_customer);
    }

    // Simpan file baru
    $file = $request->file('bukti_bayar_customer');
    $filename = 'bukti_' . $tarikTunai->kode_transaksi . '_' . time() . '.' . $file->getClientOriginalExtension();
    $path = $file->storeAs('bukti_customer', $filename, 'public');

    $tarikTunai->update([
        'bukti_bayar_customer' => $path,
        'waktu_upload_bukti_customer' => now(), // TAMBAH INI
        'status' => 'menunggu_verifikasi_admin', // Ganti status ke verifikasi admin
    ]);

    return back()->with('success', 'Bukti pembayaran berhasil diupload. Admin akan memverifikasi pembayaran Anda.');
}

    public function cancel(TarikTunai $tarikTunai)
    {
        if ($tarikTunai->user_id != Auth::id()) abort(403);

        if (!in_array($tarikTunai->status, ['menunggu_admin','menunggu_pembayaran'])) {
            return back()->with('error','Transaksi tidak bisa dibatalkan pada status ini.');
        }

        $tarikTunai->update([
            'status' => 'dibatalkan_customer',
            'catatan_cancel' => 'Dibatalkan oleh customer',
            'waktu_dibatalkan' => now()
        ]);

        return back()->with('success','Transaksi berhasil dibatalkan.');
    }

    public function getDetail(TarikTunai $tarikTunai)
    {
        if ($tarikTunai->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json([
            'jumlah' => $tarikTunai->jumlah,
            'biaya_admin' => $tarikTunai->biaya_admin,
            'total_dibayar' => $tarikTunai->total_dibayar,
            'status' => $tarikTunai->status,
            'kode_transaksi' => $tarikTunai->kode_transaksi
        ]);
    }
}