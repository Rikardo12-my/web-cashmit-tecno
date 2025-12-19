<?php

namespace App\Http\Controllers;

use App\Models\TarikTunai;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\LokasiCod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarikTunaiExport;

class TarikTunaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TarikTunai::with(['user', 'petugas', 'paymentMethod', 'lokasiCod'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter by payment method
        if ($request->has('payment_method_id') && $request->payment_method_id != 'all') {
            $query->where('payment_method_id', $request->payment_method_id);
        }

        // Filter by petugas
        if ($request->has('petugas_id') && $request->petugas_id != 'all') {
            $query->where('petugas_id', $request->petugas_id);
        }

        $transactions = $query->paginate(20);
        
        // Statistics
        $statistics = [
            'total' => TarikTunai::count(),
            'pending' => TarikTunai::where('status', 'pending')->count(),
            'diproses' => TarikTunai::where('status', 'diproses')->count(),
            'menunggu_petugas' => TarikTunai::where('status', 'menunggu_petugas')->count(),
            'dalam_perjalanan' => TarikTunai::where('status', 'dalam_perjalanan')->count(),
            'selesai' => TarikTunai::where('status', 'selesai')->count(),
            'dibatalkan' => TarikTunai::where('status', 'dibatalkan')->count(),
            'total_amount' => TarikTunai::where('status', 'selesai')->sum('jumlah'),
        ];

        $petugasList = User::where('role', 'petugas')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('layout.admin.tariktunai.index', compact(
            'transactions', 
            'statistics', 
            'petugasList',
            'paymentMethods'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'customer')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $lokasiCodList = LokasiCod::where('is_active', true)->get();
        $petugasList = User::where('role', 'petugas')->get();

        return view('layout.admin.tariktunai.create', compact(
            'users',
            'paymentMethods',
            'lokasiCodList',
            'petugasList'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:10000|max:10000000',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'lokasi_cod_id' => 'nullable|exists:lokasi_cod,id',
            'petugas_id' => 'nullable|exists:users,id',
            'catatan_admin' => 'nullable|string|max:500',
            'bukti_bayar_customer' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Get payment method to determine if it's COD
        $paymentMethod = PaymentMethod::find($validated['payment_method_id']);
        
        // Set status based on payment method category
        if ($paymentMethod->kategori == 'qris_cod') {
            $validated['status'] = 'menunggu_petugas';
        } else {
            $validated['status'] = 'diproses';
        }

        // Handle file upload
        if ($request->hasFile('bukti_bayar_customer')) {
            $validated['bukti_bayar_customer'] = $request->file('bukti_bayar_customer')
                ->store('bukti-bayar', 'public');
        }

        // Create transaction
        TarikTunai::create($validated);

        return redirect()->route('admin.tariktunai.index')
            ->with('success', 'Transaksi penarikan tunai berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = TarikTunai::with(['user', 'petugas', 'paymentMethod', 'lokasiCod'])
            ->findOrFail($id);

        return view('layout.admin.tariktunai.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = TarikTunai::findOrFail($id);
        $petugasList = User::where('role', 'petugas')->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        $lokasiCodList = LokasiCod::where('is_active', true)->get();

        return view('layout.admin.tariktunai.edit', compact(
            'transaction',
            'petugasList',
            'paymentMethods',
            'lokasiCodList'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction = TarikTunai::findOrFail($id);

        $validated = $request->validate([
            'petugas_id' => 'nullable|exists:users,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'lokasi_cod_id' => 'nullable|exists:lokasi_cod,id',
            'status' => 'required|in:pending,diproses,menunggu_petugas,dalam_perjalanan,selesai,dibatalkan',
            'catatan_admin' => 'nullable|string|max:500',
            'waktu_diserahkan' => 'nullable|date',
            'bukti_serah_terima_petugas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload for petugas evidence
        if ($request->hasFile('bukti_serah_terima_petugas')) {
            // Delete old file if exists
            if ($transaction->bukti_serah_terima_petugas && Storage::disk('public')->exists($transaction->bukti_serah_terima_petugas)) {
                Storage::disk('public')->delete($transaction->bukti_serah_terima_petugas);
            }
            
            $validated['bukti_serah_terima_petugas'] = $request->file('bukti_serah_terima_petugas')
                ->store('bukti-serah-terima', 'public');
        }

        // Update transaction
        $transaction->update($validated);

        return redirect()->route('admin.tariktunai.show', $transaction->id)
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = TarikTunai::findOrFail($id);

        // Delete files if exist
        if ($transaction->bukti_bayar_customer && Storage::disk('public')->exists($transaction->bukti_bayar_customer)) {
            Storage::disk('public')->delete($transaction->bukti_bayar_customer);
        }

        if ($transaction->bukti_serah_terima_petugas && Storage::disk('public')->exists($transaction->bukti_serah_terima_petugas)) {
            Storage::disk('public')->delete($transaction->bukti_serah_terima_petugas);
        }

        $transaction->delete();

        return redirect()->route('admin.tariktunai.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Assign petugas to transaction
     */
    public function assignPetugas(Request $request, $id)
    {
        $transaction = TarikTunai::findOrFail($id);

        $request->validate([
            'petugas_id' => 'required|exists:users,id',
        ]);

        $transaction->update([
            'petugas_id' => $request->petugas_id,
            'status' => 'dalam_perjalanan',
        ]);

        return back()->with('success', 'Petugas berhasil ditugaskan.');
    }

    /**
     * Update transaction status
     */
    public function updateStatus(Request $request, $id)
    {
        $transaction = TarikTunai::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,diproses,menunggu_petugas,dalam_perjalanan,selesai,dibatalkan',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $updateData = [
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ];

        // If status is selesai and no delivery time set, set it now
        if ($request->status == 'selesai' && !$transaction->waktu_diserahkan) {
            $updateData['waktu_diserahkan'] = now();
        }

        $transaction->update($updateData);

        return back()->with('success', 'Status transaksi berhasil diperbarui.');
    }

    /**
     * Upload bukti serah terima
     */
    public function uploadBuktiSerahTerima(Request $request, $id)
    {
        $transaction = TarikTunai::findOrFail($id);

        $request->validate([
            'bukti_serah_terima_petugas' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Delete old file if exists
        if ($transaction->bukti_serah_terima_petugas && Storage::disk('public')->exists($transaction->bukti_serah_terima_petugas)) {
            Storage::disk('public')->delete($transaction->bukti_serah_terima_petugas);
        }

        $transaction->update([
            'bukti_serah_terima_petugas' => $request->file('bukti_serah_terima_petugas')
                ->store('bukti-serah-terima', 'public'),
            'waktu_diserahkan' => now(),
            'status' => 'selesai',
        ]);

        return back()->with('success', 'Bukti serah terima berhasil diupload.');
    }

    /**
     * Export to PDF
     */
    public function exportPDF(Request $request)
    {
        $query = TarikTunai::with(['user', 'petugas', 'paymentMethod'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $transactions = $query->get();
        
        $pdf = Pdf::loadView('layout.admin.tariktunai.export.pdf', [
            'transactions' => $transactions,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return $pdf->download('laporan-tariktunai-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export to Excel
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new TarikTunaiExport($request), 'laporan-tariktunai-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Get payment methods based on category
     */
    public function getPaymentMethodsByCategory(Request $request)
    {
        $category = $request->get('category');
        
        $paymentMethods = PaymentMethod::where('is_active', true);
        
        if ($category) {
            $paymentMethods->where('kategori', $category);
        }
        
        return response()->json([
            'paymentMethods' => $paymentMethods->get()
        ]);
    }

    /**
     * Get COD locations for specific payment method
     */
    public function getCodLocations($paymentMethodId)
    {
        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);
        
        if ($paymentMethod->kategori == 'qris_cod') {
            $locations = LokasiCod::where('is_active', true)->get();
            return response()->json(['locations' => $locations]);
        }
        
        return response()->json(['locations' => []]);
    }
}