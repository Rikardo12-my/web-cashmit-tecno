<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TarikTunai;
use App\Models\LokasiCod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PetugasTarikTunaiController extends Controller
{
    /**
     * Dashboard Petugas - Daftar Tugas Tarik Tunai
     */
    public function index()
    {
        // Ambil tugas yang ditugaskan ke petugas ini
        $tarikTunais = TarikTunai::with(['user', 'paymentMethod', 'lokasiCod'])
            ->where('petugas_id', Auth::id())
            ->whereIn('status', ['diproses', 'dalam_perjalanan', 'menunggu_serah_terima', 'selesai'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Urutkan secara manual di PHP berdasarkan prioritas status
        $statusOrder = [
            'diproses' => 1,
            'dalam_perjalanan' => 2,
            'menunggu_serah_terima' => 3,
            'selesai' => 4,
        ];

        $tarikTunais = $tarikTunais->sortBy(function($item) use ($statusOrder) {
            return $statusOrder[$item->status] ?? 99;
        })->values();

        // Hitung statistik untuk dashboard
        $stats = [
            'total' => $tarikTunais->count(),
            'diproses' => $tarikTunais->where('status', 'diproses')->count(),
            'dalam_perjalanan' => $tarikTunais->where('status', 'dalam_perjalanan')->count(),
            'menunggu_serah_terima' => $tarikTunais->where('status', 'menunggu_serah_terima')->count(),
            'selesai' => $tarikTunais->where('status', 'selesai')->count(),
            'belum_bukti' => $tarikTunais->whereNotNull('bukti_serah_terima_petugas')->count(),
            'sudah_bukti' => $tarikTunais->whereNull('bukti_serah_terima_petugas')->whereIn('status', ['menunggu_serah_terima', 'selesai'])->count(),
        ];

        return view('layout.petugas.tariktunai.index', compact('tarikTunais', 'stats'));
    }

    /**
     * Detail Transaksi
     */
    public function show(TarikTunai $tarikTunai)
    {
        // Validasi akses
        if ($tarikTunai->petugas_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $tarikTunai->load(['user', 'paymentMethod', 'lokasiCod', 'admin']);

        // Ambil gambar lokasi jika ada
        $lokasiImage = null;
        if ($tarikTunai->lokasiCod && $tarikTunai->lokasiCod->gambar) {
            if (Storage::disk('public')->exists($tarikTunai->lokasiCod->gambar)) {
                $lokasiImage = Storage::url($tarikTunai->lokasiCod->gambar);
            }
        }

        return view('layout.petugas.tariktunai.show', compact('tarikTunai', 'lokasiImage'));
    }

    /**
     * Update Status Transaksi
     */
    public function updateStatus(Request $request, TarikTunai $tarikTunai)
    {
        // Validasi akses
        if ($tarikTunai->petugas_id != Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $request->validate([
            'status' => 'required|in:diproses,dalam_perjalanan,menunggu_serah_terima,selesai',
            'catatan_petugas' => 'nullable|string|max:500',
        ]);

        // Validasi alur status
        $allowedTransitions = [
            'diproses' => ['dalam_perjalanan'],
            'dalam_perjalanan' => ['menunggu_serah_terima'],
            'menunggu_serah_terima' => ['selesai'],
            'selesai' => []
        ];

        $currentStatus = $tarikTunai->status;
        $newStatus = $request->status;

        if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return redirect()->back()->with('error', 'Perubahan status tidak valid. Dari ' . $this->getStatusText($currentStatus) . ' ke ' . $this->getStatusText($newStatus) . ' tidak diperbolehkan.');
        }

        // Update status
        $tarikTunai->status = $newStatus;
        
        // Simpan catatan jika ada
        if ($request->filled('catatan_petugas')) {
            $existingCatatan = $tarikTunai->catatan_petugas ?? '';
            $newCatatan = "[" . now()->format('d/m/Y H:i') . "] Status diubah: " . $this->getStatusText($currentStatus) . " → " . $this->getStatusText($newStatus);
            
            if (!empty($request->catatan_petugas)) {
                $newCatatan .= "\nCatatan: " . $request->catatan_petugas;
            }
            
            $tarikTunai->catatan_petugas = $existingCatatan ? $existingCatatan . "\n\n" . $newCatatan : $newCatatan;
        }

        // Set timestamp sesuai status
        $timeFieldMap = [
            'diproses' => 'waktu_diproses',
            'dalam_perjalanan' => 'waktu_dalam_perjalanan',
            'menunggu_serah_terima' => 'waktu_diserahkan',
            'selesai' => 'waktu_selesai',
        ];

        if (isset($timeFieldMap[$newStatus]) && !$tarikTunai->{$timeFieldMap[$newStatus]}) {
            $field = $timeFieldMap[$newStatus];
            $tarikTunai->$field = now();
        }

        $tarikTunai->save();

        Log::info('Petugas update status', [
            'petugas_id' => Auth::id(),
            'tarik_tunai_id' => $tarikTunai->id,
            'status_lama' => $currentStatus,
            'status_baru' => $newStatus,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diperbarui dari ' . $this->getStatusText($currentStatus) . ' ke ' . $this->getStatusText($newStatus) . '.');
    }

    /**
     * Upload Bukti Serah Terima (AJAX)
     */
    public function uploadBukti(Request $request, TarikTunai $tarikTunai)
    {
        // Validasi akses
        if ($tarikTunai->petugas_id != Auth::id()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke transaksi ini.'
                ], 403);
            }
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        // Validasi status yang diperbolehkan upload bukti
        $allowedStatuses = ['menunggu_serah_terima', 'dalam_perjalanan', 'diproses'];
        
        if (!in_array($tarikTunai->status, $allowedStatuses)) {
            $errorMessage = "Upload bukti hanya dapat dilakukan pada status:<br>" .
                           "• <strong>Diproses</strong><br>" .
                           "• <strong>Dalam Perjalanan</strong><br>" .
                           "• <strong>Menunggu Serah Terima</strong><br><br>" .
                           "Status saat ini: <strong>" . $this->getStatusText($tarikTunai->status) . "</strong>";
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
            return redirect()->back()->with('error', $errorMessage);
        }

        // Validasi file
        $request->validate([
            'bukti_serah_terima_petugas' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'catatan_serah_terima' => 'nullable|string|max:500',
        ]);

        try {
            // Hapus file lama jika ada
            if ($tarikTunai->bukti_serah_terima_petugas) {
                try {
                    Storage::disk('public')->delete($tarikTunai->bukti_serah_terima_petugas);
                } catch (\Exception $e) {
                    Log::warning('Gagal menghapus file lama', ['error' => $e->getMessage()]);
                }
            }

            // Upload file baru
            $file = $request->file('bukti_serah_terima_petugas');
            $extension = $file->getClientOriginalExtension();
            
            // Buat nama file unik
            $filename = 'bukti_serah_terima_' . $tarikTunai->kode_transaksi . '_' . time() . '.' . $extension;
            $path = $file->storeAs('bukti_petugas', $filename, 'public');
            
            Log::info('File berhasil diupload', [
                'filename' => $filename,
                'path' => $path
            ]);

            // Update database
            $updateData = [
                'bukti_serah_terima_petugas' => $path,
                'waktu_upload_bukti_petugas' => now(),
                'status' => 'selesai',
                'waktu_selesai' => now(),
            ];

            // Jika belum ada waktu_diserahkan, set sekarang
            if (!$tarikTunai->waktu_diserahkan) {
                $updateData['waktu_diserahkan'] = now();
            }

            // Tambahkan catatan serah terima jika ada
            if ($request->filled('catatan_serah_terima')) {
                $updateData['catatan_serah_terima'] = $request->catatan_serah_terima;
            }

            // Update catatan petugas dengan log upload
            $existingCatatan = $tarikTunai->catatan_petugas ?? '';
            $uploadCatatan = "[" . now()->format('d/m/Y H:i') . "] Bukti serah terima diupload.";
            
            if ($request->filled('catatan_serah_terima')) {
                $uploadCatatan .= "\nCatatan: " . $request->catatan_serah_terima;
            }
            
            $updateData['catatan_petugas'] = $existingCatatan ? $existingCatatan . "\n\n" . $uploadCatatan : $uploadCatatan;

            $tarikTunai->update($updateData);

            Log::info('Bukti serah terima berhasil disimpan', [
                'petugas_id' => Auth::id(),
                'tarik_tunai_id' => $tarikTunai->id,
                'status_baru' => $tarikTunai->status,
                'path' => $path
            ]);

            // Response berdasarkan request type
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Bukti serah terima berhasil diupload. Transaksi telah selesai.',
                    'redirect_url' => route('layout.petugas.tariktunai.index')
                ]);
            }

            return redirect()->route('layout.petugas.tariktunai.index')->with('success', 'Bukti serah terima berhasil diupload. Transaksi telah selesai.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal', ['errors' => $e->errors()]);
            
            $errorMessages = collect($e->errors())->flatten()->implode(', ');
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal: ' . $errorMessages
                ], 422);
            }
            
            return redirect()->back()->with('error', 'Validasi gagal: ' . $errorMessages);
            
        } catch (\Exception $e) {
            Log::error('Gagal upload bukti serah terima', [
                'error' => $e->getMessage(),
                'tarik_tunai_id' => $tarikTunai->id,
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Lihat Detail Lokasi (API untuk modal)
     */
    public function getLocationDetail($id)
    {
        try {
            $tarikTunai = TarikTunai::findOrFail($id);
            
            if ($tarikTunai->petugas_id != Auth::id()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $tarikTunai->load(['lokasiCod', 'user']);
            
            $data = [
                'lokasi' => $tarikTunai->lokasiCod,
                'customer' => $tarikTunai->user,
                'transaksi' => [
                    'kode' => $tarikTunai->kode_transaksi,
                    'jumlah' => number_format($tarikTunai->jumlah, 0, ',', '.'),
                    'biaya_admin' => number_format($tarikTunai->biaya_admin, 0, ',', '.'),
                    'total_dibayar' => number_format($tarikTunai->total_dibayar, 0, ',', '.'),
                ]
            ];

            // Tambahkan URL gambar lokasi jika ada
            if ($tarikTunai->lokasiCod && $tarikTunai->lokasiCod->gambar) {
                if (Storage::disk('public')->exists($tarikTunai->lokasiCod->gambar)) {
                    $data['lokasi']->gambar_url = Storage::url($tarikTunai->lokasiCod->gambar);
                }
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting location detail', [
                'error' => $e->getMessage(),
                'tarik_tunai_id' => $id,
            ]);

            return response()->json([
                'error' => 'Gagal memuat data lokasi',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Catatan Tambahan
     */
    public function updateCatatan(Request $request, TarikTunai $tarikTunai)
    {
        // Validasi akses
        if ($tarikTunai->petugas_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $request->validate([
            'catatan_tambahan' => 'required|string|max:1000',
        ]);

        $existingCatatan = $tarikTunai->catatan_petugas ?? '';
        $newCatatan = "[" . now()->format('d/m/Y H:i') . "] " . $request->catatan_tambahan;
        
        $tarikTunai->catatan_petugas = $existingCatatan ? $existingCatatan . "\n\n" . $newCatatan : $newCatatan;
        $tarikTunai->save();

        Log::info('Petugas update catatan', [
            'petugas_id' => Auth::id(),
            'tarik_tunai_id' => $tarikTunai->id,
        ]);

        return redirect()->back()->with('success', 'Catatan berhasil diperbarui.');
    }

    /**
     * Mark as Selesai tanpa upload bukti (opsional)
     */
    public function markAsSelesai(Request $request, TarikTunai $tarikTunai)
    {
        // Validasi akses
        if ($tarikTunai->petugas_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $request->validate([
            'konfirmasi' => 'required|boolean',
        ]);

        if (!$request->konfirmasi) {
            return redirect()->back()->with('error', 'Harap konfirmasi penyelesaian transaksi.');
        }

        // Hanya boleh mark as selesai jika status menunggu_serah_terima
        if ($tarikTunai->status !== 'menunggu_serah_terima') {
            return redirect()->back()->with('error', 'Hanya bisa menandai selesai dari status "Menunggu Serah Terima".');
        }

        // Update status
        $tarikTunai->status = 'selesai';
        $tarikTunai->waktu_selesai = now();
        
        // Update catatan
        $existingCatatan = $tarikTunai->catatan_petugas ?? '';
        $newCatatan = "[" . now()->format('d/m/Y H:i') . "] Transaksi ditandai selesai tanpa upload bukti (konfirmasi petugas).";
        $tarikTunai->catatan_petugas = $existingCatatan ? $existingCatatan . "\n\n" . $newCatatan : $newCatatan;
        
        $tarikTunai->save();

        Log::info('Petugas mark as selesai', [
            'petugas_id' => Auth::id(),
            'tarik_tunai_id' => $tarikTunai->id,
        ]);

        return redirect()->back()->with('success', 'Transaksi telah ditandai sebagai selesai.');
    }

    /**
     * Download QRIS untuk referensi pembayaran
     */
    public function downloadQris(TarikTunai $tarikTunai)
    {
        // Validasi akses
        if ($tarikTunai->petugas_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        if (!$tarikTunai->paymentMethod || !$tarikTunai->paymentMethod->qris_image) {
            return redirect()->back()->with('error', 'QRIS tidak tersedia untuk transaksi ini.');
        }

        $qrisPath = $tarikTunai->paymentMethod->qris_image;
        
        if (!Storage::disk('public')->exists($qrisPath)) {
            return redirect()->back()->with('error', 'File QRIS tidak ditemukan.');
        }

        // Return file untuk download
        return response()->download(storage_path('app/public/' . $qrisPath));
    }

    /**
     * Helper function untuk mendapatkan teks status
     */
    private function getStatusText($status)
    {
        $statusTexts = [
            'pending' => 'Pending',
            'menunggu_admin' => 'Menunggu Admin',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi_admin' => 'Menunggu Verifikasi Admin',
            'diproses' => 'Diproses',
            'dalam_perjalanan' => 'Dalam Perjalanan',
            'menunggu_serah_terima' => 'Menunggu Serah Terima',
            'selesai' => 'Selesai',
            'dibatalkan_customer' => 'Dibatalkan Customer',
            'dibatalkan_admin' => 'Dibatalkan Admin'
        ];

        return $statusTexts[$status] ?? $status;
    }
}