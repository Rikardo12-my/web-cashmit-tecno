<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    /**
     * Tampilkan daftar metode pembayaran
     */
    public function index()
    {
        $payments = PaymentMethod::orderBy('kategori')->get();
        return view('layout.admin.payment.index', compact('payments'));
    }

    /**
     * Simpan metode pembayaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:255',
            'kategori'       => 'required|in:bank_qris,qris_cod,e_wallet',
            'deskripsi'      => 'nullable|string',
            'account_name'   => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'provider'       => 'nullable|string|max:255',
            'qris_image'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'nama'           => $request->nama,
            'kategori'       => $request->kategori,
            'deskripsi'      => $request->deskripsi,
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'provider'       => $request->provider,
            'is_active'      => true,
        ];

        // Upload QRIS jika ada
        if ($request->hasFile('qris_image')) {
            $data['qris_image'] = $request->file('qris_image')->store('qris', 'public');
        }

        PaymentMethod::create($data);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    /**
     * Update metode pembayaran
     */
    public function update(Request $request, $id)
    {
        $method = PaymentMethod::findOrFail($id);

        $request->validate([
            'nama'           => 'required|string|max:255',
            'kategori'       => 'required|in:bank_qris,qris_cod,e_wallet',
            'deskripsi'      => 'nullable|string',
            'account_name'   => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'provider'       => 'nullable|string|max:255',
            'qris_image'     => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $data = [
            'nama'           => $request->nama,
            'kategori'       => $request->kategori,
            'deskripsi'      => $request->deskripsi,
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'provider'       => $request->provider,
        ];

        // Update QRIS jika ada file baru
        if ($request->hasFile('qris_image')) {
            $data['qris_image'] = $request->file('qris_image')->store('qris', 'public');
        }

        $method->update($data);

        return back()->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    /**
     * Aktif / Nonaktif metode pembayaran
     */
    public function toggleStatus($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->update([
            'is_active' => !$method->is_active
        ]);

        return back()->with('success', 'Status metode pembayaran berhasil diperbarui!');
    }

    /**
     * Hapus metode pembayaran
     */
    public function destroy(Request $request, $id)
    {
        try {
            $method = PaymentMethod::findOrFail($id);
            
            // Hapus file QRIS jika ada
            if ($method->qris_image && Storage::disk('public')->exists($method->qris_image)) {
                Storage::disk('public')->delete($method->qris_image);
            }
            
            $method->delete();
            
            // Check if request is AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Metode pembayaran berhasil dihapus!'
                ]);
            }
            
            return redirect()->route('admin.payment.index')
                ->with('success', 'Metode pembayaran berhasil dihapus!');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus metode pembayaran: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menghapus metode pembayaran: ' . $e->getMessage());
        }
    }
}