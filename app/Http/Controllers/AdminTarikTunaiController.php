<?php

namespace App\Http\Controllers;

use App\Models\TarikTunai;
use App\Models\User;
use App\Models\LokasiCod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminTarikTunaiController extends Controller
{
    /**
     * Lihat semua tarik tunai
     */
    public function index(Request $request)
    {
        $query = TarikTunai::with(['user', 'petugas', 'admin', 'paymentMethod', 'lokasiCod']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_transaksi', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function ($q2) use ($request) {
                      $q2->where('nama', 'like', "%{$request->search}%");
                  });
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_cod_id', $request->lokasi_id);
        }

        if ($request->filled('payment_method')) {
            if ($request->payment_method === 'qris_cod') {
                $query->where('is_qris_cod', true);
            } elseif ($request->payment_method === 'non_qris') {
                $query->where('is_qris_cod', false);
            }
        }

        $tarikTunais = $query->orderBy('created_at', 'desc')->get();
        
        // Ambil daftar petugas untuk form assign
        $petugasList = User::where('role', 'petugas')
                          ->where('status', 'active')
                          ->get();
        
        // Ambil daftar lokasi untuk filter
        $lokasiList = LokasiCod::where('status', 'active')->get();

        return view('layout.admin.tariktunai.index', compact('tarikTunais', 'petugasList', 'lokasiList'));
    }

    /**
     * Detail tarik tunai
     */
    public function show(TarikTunai $tarikTunai)
    {
        $petugasList = User::where('role', 'petugas')->where('status', 'active')->get();
        return view('layout.admin.tariktunai.show', compact('tarikTunai', 'petugasList'));
    }

    /**
     * Assign petugas tunggal
     */
    public function assignPetugas(Request $request, TarikTunai $tarikTunai)
    {
        $request->validate(['petugas_id' => 'required|exists:users,id']);

        // Logika berbeda untuk QRIS COD dan non-QRIS COD
        if ($tarikTunai->isQRISCOD()) {
            // Untuk QRIS COD, langsung assign tanpa cek bukti pembayaran
            if ($tarikTunai->status !== 'menunggu_admin') {
                return redirect()->back()->with('error', 'Transaksi QRIS COD harus dalam status menunggu admin.');
            }
            
            $tarikTunai->update([
                'petugas_id' => $request->petugas_id,
                'assigned_by' => Auth::id(),
                'status' => 'diproses',
                'waktu_diproses' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Petugas berhasil ditugaskan untuk QRIS COD.');
        } else {
            // Untuk non-QRIS, cek bukti pembayaran dulu
            if (!$tarikTunai->bukti_bayar_customer) {
                return redirect()->back()->with('error', 'Transaksi belum memiliki bukti pembayaran.');
            }

            if ($tarikTunai->status !== 'menunggu_verifikasi_admin') {
                return redirect()->back()->with('error', 'Transaksi belum diverifikasi pembayarannya.');
            }

            $tarikTunai->update([
                'petugas_id' => $request->petugas_id,
                'assigned_by' => Auth::id(),
                'status' => 'diproses',
                'waktu_diproses' => now(),
            ]);

            return redirect()->back()->with('success', 'Petugas berhasil ditugaskan.');
        }
    }

    /**
     * Bulk assign banyak tarik tunai sekaligus
     */
    public function bulkAssign(Request $request)
    {
        $request->validate([
            'tarik_tunai_ids' => 'required|array',
            'petugas_id' => 'required|exists:users,id',
        ]);

        if (is_string($request->tarik_tunai_ids)) {
            $tarikTunaiIds = explode(',', $request->tarik_tunai_ids);
        } else {
            $tarikTunaiIds = $request->tarik_tunai_ids;
        }

        $count = 0;
        $errors = [];
        foreach ($tarikTunaiIds as $id) {
            $tarik = TarikTunai::find($id);
            if ($tarik) {
                if ($tarik->isQRISCOD()) {
                    // Logika untuk QRIS COD
                    if ($tarik->status === 'menunggu_admin' && $tarik->biaya_admin > 0) {
                        $tarik->update([
                            'petugas_id' => $request->petugas_id,
                            'assigned_by' => Auth::id(),
                            'status' => 'diproses',
                            'waktu_diproses' => now(),
                        ]);
                        $count++;
                    } else {
                        $errors[] = "QRIS COD {$tarik->kode_transaksi} belum siap diassign";
                    }
                } else {
                    // Logika untuk non-QRIS
                    if ($tarik->status === 'menunggu_verifikasi_admin' && 
                        $tarik->bukti_bayar_customer && 
                        $tarik->biaya_admin > 0) {
                        
                        $tarik->update([
                            'petugas_id' => $request->petugas_id,
                            'assigned_by' => Auth::id(),
                            'status' => 'diproses',
                            'waktu_diproses' => now(),
                        ]);
                        $count++;
                    } else {
                        $errors[] = "Transaksi {$tarik->kode_transaksi} tidak memenuhi syarat";
                    }
                }
            }
        }

        $message = "Berhasil meng-assign $count transaksi ke petugas.";
        if (!empty($errors)) {
            $message .= " " . implode(', ', array_slice($errors, 0, 3));
            if (count($errors) > 3) {
                $message .= " dan " . (count($errors) - 3) . " lainnya";
            }
        }

        return redirect()->back()->with($count > 0 ? 'success' : 'warning', $message);
    }

    /**
     * Update status tarik tunai
     */
    public function updateStatus(Request $request, TarikTunai $tarikTunai)
    {
        // Daftar status yang valid dengan penyesuaian untuk QRIS COD
        $validStatuses = [
            'pending',              
            'menunggu_admin',       
            'menunggu_pembayaran',
            'menunggu_verifikasi_admin',
            'menunggu_verifikasi_qris', // Status baru untuk QRIS COD
            'diproses',             
            'dalam_perjalanan',    
            'menunggu_serah_terima',
            'selesai',
            'dibatalkan_customer',
            'dibatalkan_admin'
        ];

        $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses),
            'catatan_admin' => 'nullable|string',
            'bukti_qris' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $oldStatus = $tarikTunai->status;
        $newStatus = $request->status;

        // Validasi transisi status khusus QRIS COD
        if ($tarikTunai->isQRISCOD()) {
            if ($newStatus === 'selesai' && $oldStatus !== 'menunggu_verifikasi_qris') {
                return redirect()->back()->with('error', 'QRIS COD harus melalui verifikasi QRIS terlebih dahulu.');
            }
            
            if ($newStatus === 'menunggu_verifikasi_qris' && $oldStatus !== 'menunggu_serah_terima') {
                return redirect()->back()->with('error', 'Harus melalui proses serah terima terlebih dahulu.');
            }
        } else {
            // Validasi untuk non-QRIS
            if ($oldStatus === 'menunggu_admin' && $newStatus === 'menunggu_pembayaran') {
                if ($tarikTunai->biaya_admin <= 0) {
                    return redirect()->back()->with('error', 'Set biaya admin terlebih dahulu sebelum mengubah status.');
                }
            }
        }

        // Validasi umum
        if ($newStatus === 'diproses') {
            if (!$tarikTunai->petugas_id) {
                return redirect()->back()->with('error', 'Assign petugas terlebih dahulu sebelum mengubah ke status diproses.');
            }
        }

        // Handle upload bukti QRIS
        if ($request->hasFile('bukti_qris') && $newStatus === 'menunggu_verifikasi_qris') {
            $buktiPath = $request->file('bukti_qris')->store('bukti_qris', 'public');
            $tarikTunai->bukti_bayar_customer = $buktiPath;
            $tarikTunai->waktu_upload_bukti_customer = now();
        }

        // Update status dan catatan
        $tarikTunai->status = $newStatus;
        if ($request->catatan_admin) {
            $tarikTunai->catatan_admin = $request->catatan_admin;
        }

        // Mapping waktu update
        $timeFieldMap = [
            'menunggu_pembayaran' => 'waktu_diproses',
            'menunggu_verifikasi_admin' => 'waktu_diproses',
            'menunggu_verifikasi_qris' => 'waktu_verifikasi_qris', // Field baru
            'diproses' => 'waktu_diproses',
            'dalam_perjalanan' => 'waktu_dalam_perjalanan',
            'menunggu_serah_terima' => 'waktu_diserahkan',
            'selesai' => 'waktu_selesai',
            'dibatalkan_customer' => 'waktu_dibatalkan',
            'dibatalkan_admin' => 'waktu_dibatalkan',
        ];

        if (isset($timeFieldMap[$newStatus])) {
            $tarikTunai->{$timeFieldMap[$newStatus]} = now();
        }

        $tarikTunai->save();

        // Handle action khusus (verifikasi/tolak QRIS)
        if ($request->has('action')) {
            if ($request->action === 'verifikasi_qris' && $newStatus === 'selesai') {
                $tarikTunai->update([
                    'status' => 'selesai',
                    'waktu_selesai' => now(),
                    'waktu_verifikasi_qris' => now(),
                    'catatan_admin' => $request->catatan_admin ?? 'QRIS berhasil diverifikasi',
                ]);
            } elseif ($request->action === 'tolak_qris' && $tarikTunai->isQRISCOD()) {
                $tarikTunai->update([
                    'status' => 'menunggu_serah_terima',
                    'catatan_admin' => $request->catatan_admin ?? 'QRIS ditolak, customer diminta untuk bayar ulang',
                ]);
                return redirect()->back()->with('warning', 'QRIS ditolak. Transaksi kembali ke status menunggu serah terima.');
            }
        }

        return redirect()->back()->with('success', 'Status tarik tunai berhasil diperbarui.');
    }

    /**
     * Verifikasi bukti pembayaran customer
     */
    public function verifikasiBuktiBayar(Request $request, TarikTunai $tarikTunai)
    {
        // Validasi khusus untuk non-QRIS COD
        if ($tarikTunai->isQRISCOD()) {
            return redirect()->back()->with('error', 'Metode verifikasi ini hanya untuk non-QRIS COD.');
        }

        $request->validate([
            'status_verifikasi' => 'required|in:diterima,ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,ditolak|string|max:500',
        ]);

        if (!$tarikTunai->bukti_bayar_customer) {
            return redirect()->back()->with('error', 'Tidak ada bukti pembayaran untuk diverifikasi.');
        }

        if ($tarikTunai->status !== 'menunggu_verifikasi_admin') {
            return redirect()->back()->with('error', 'Transaksi tidak dalam status menunggu verifikasi.');
        }

        if ($request->status_verifikasi === 'diterima') {
            $tarikTunai->update([
                'status' => 'menunggu_verifikasi_admin',
                'catatan_admin' => $request->catatan_verifikasi ?? 'Bukti pembayaran telah diverifikasi',
            ]);
            
            $message = 'Bukti pembayaran berhasil diverifikasi. Transaksi siap untuk assign petugas.';
        } else {
            $tarikTunai->update([
                'status' => 'menunggu_pembayaran',
                'catatan_admin' => $request->catatan_verifikasi ?? 'Bukti pembayaran ditolak',
                'bukti_bayar_customer' => null,
                'waktu_upload_bukti_customer' => null,
            ]);
            
            $message = 'Bukti pembayaran ditolak. Customer dapat mengupload bukti baru.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Hapus tarik tunai
     */
    public function destroy(TarikTunai $tarikTunai)
    {
        // Hapus file bukti jika ada
        if ($tarikTunai->bukti_bayar_customer) {
            Storage::disk('public')->delete($tarikTunai->bukti_bayar_customer);
        }
        
        if ($tarikTunai->bukti_serah_terima_petugas) {
            Storage::disk('public')->delete($tarikTunai->bukti_serah_terima_petugas);
        }

        $tarikTunai->delete();
        return redirect()->route('admin.tariktunai.index')->with('success', 'Tarik tunai berhasil dihapus.');
    }

    /**
     * Export CSV tarik tunai
     */
    public function exportCsv()
    {
        $tarikTunais = TarikTunai::with(['user', 'petugas', 'admin', 'paymentMethod', 'lokasiCod'])->get();

        $csvHeader = [
            'Kode Transaksi', 'Customer', 'Petugas', 'Admin Assign', 'Jumlah', 
            'Biaya Admin', 'Total Dibayar', 'Status', 'Payment Method', 'QRIS COD',
            'Lokasi COD', 'Bukti Pembayaran', 'Waktu Upload Bukti', 'Waktu Dibuat', 'Waktu Selesai'
        ];

        $csvData = [];
        foreach ($tarikTunais as $t) {
            $csvData[] = [
                $t->kode_transaksi,
                $t->user->nama ?? '-',
                $t->petugas->nama ?? '-',
                $t->admin->nama ?? '-',
                $t->jumlah,
                $t->biaya_admin,
                $t->total_dibayar ?? ($t->jumlah + $t->biaya_admin),
                $t->statusLabel,
                $t->paymentMethod->nama ?? '-',
                $t->is_qris_cod ? 'Ya' : 'Tidak',
                $t->lokasiCod->nama_lokasi ?? '-',
                $t->bukti_bayar_customer ? 'Ada' : 'Tidak',
                $t->waktu_upload_bukti_customer ? $t->waktu_upload_bukti_customer->format('d/m/Y H:i') : '-',
                $t->created_at->format('d/m/Y H:i'),
                $t->waktu_selesai ? $t->waktu_selesai->format('d/m/Y H:i') : '-',
            ];
        }

        $filename = "tarik_tunai_" . date('Ymd_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($csvHeader, $csvData) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $csvHeader);
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show form untuk set biaya admin
     */
    public function setBiayaForm(TarikTunai $tarikTunai)
    {
        if (!in_array($tarikTunai->status, ['pending', 'menunggu_admin'])) {
            return redirect()->route('admin.tariktunai.index')
                ->with('error', 'Transaksi ini tidak dapat diatur biaya admin.');
        }

        return view('layout.admin.tariktunai.set-biaya', compact('tarikTunai'));
    }

    /**
     * Process set biaya admin
     */
    public function setBiayaAdmin(Request $request, TarikTunai $tarikTunai)
    {
        $request->validate([
            'biaya_admin' => 'required|numeric|min:0',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        if (!in_array($tarikTunai->status, ['pending', 'menunggu_admin'])) {
            return redirect()->back()
                ->with('error', 'Transaksi ini tidak dapat diatur biaya admin.');
        }

        $totalDibayar = $tarikTunai->jumlah + $request->biaya_admin;

        // Tentukan status selanjutnya berdasarkan metode pembayaran
        $nextStatus = $tarikTunai->isQRISCOD() ? 'diproses' : 'menunggu_pembayaran';

        $tarikTunai->update([
            'biaya_admin' => $request->biaya_admin,
            'total_dibayar' => $totalDibayar,
            'catatan_admin' => $request->catatan_admin,
            'status' => $nextStatus,
            'waktu_diproses' => now(),
        ]);

        $message = $tarikTunai->isQRISCOD() 
            ? 'Biaya admin berhasil ditetapkan. Transaksi siap untuk assign petugas.' 
            : 'Biaya admin berhasil ditetapkan. Transaksi menunggu pembayaran customer.';

        return redirect()->route('admin.tariktunai.show', $tarikTunai)
            ->with('success', $message);
    }

    /**
     * View bukti pembayaran
     */
    public function viewBukti(TarikTunai $tarikTunai)
    {
        if (!$tarikTunai->bukti_bayar_customer) {
            return redirect()->back()->with('error', 'Tidak ada bukti pembayaran.');
        }

        $filePath = Storage::disk('public')->path($tarikTunai->bukti_bayar_customer);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File bukti pembayaran tidak ditemukan.');
        }

        return response()->file($filePath);
    }

    /**
     * Get status timeline untuk transaksi
     */
    public function getTimeline(TarikTunai $tarikTunai)
    {
        return response()->json([
            'timeline' => $tarikTunai->timelineSteps,
            'current_step' => $tarikTunai->currentStep,
            'is_qris_cod' => $tarikTunai->isQRISCOD(),
        ]);
    }

    /**
     * Get transaksi yang ready untuk assign petugas
     */
    public function getReadyForAssign()
    {
        // Non-QRIS yang sudah diverifikasi
        $nonQris = TarikTunai::nonQrisCod()
            ->where('status', 'menunggu_verifikasi_admin')
            ->whereNotNull('bukti_bayar_customer')
            ->where('biaya_admin', '>', 0)
            ->with(['user', 'paymentMethod', 'lokasiCod'])
            ->get();

        // QRIS COD yang sudah set biaya admin
        $qrisCod = TarikTunai::qrisCod()
            ->where('status', 'menunggu_admin')
            ->where('biaya_admin', '>', 0)
            ->with(['user', 'paymentMethod', 'lokasiCod'])
            ->get();

        return response()->json([
            'non_qris' => $nonQris,
            'qris_cod' => $qrisCod,
            'total' => $nonQris->count() + $qrisCod->count(),
        ]);
    }
}