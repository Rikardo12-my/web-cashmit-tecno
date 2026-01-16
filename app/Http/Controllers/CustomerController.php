<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index()
    {
        // Ambil semua customer (role = 'customer')
        $customers = User::where('role', 'customer')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        // Hitung jumlah total customer
        $totalCustomers = $customers->count();
        
        // Hitung jumlah customer berdasarkan status
        $activeCustomers = User::where('role', 'customer')->where('status', 'active')->count();
        $bannedCustomers = User::where('role', 'customer')->where('status', 'banned')->count();
        $verifyCustomers = User::where('role', 'customer')->where('status', 'verify')->count();
        
        return view('layout.admin.customer.index', compact(
            'customers', 
            'totalCustomers',
            'activeCustomers',
            'bannedCustomers',
            'verifyCustomers'
        ));
    }

    /**
     * Display the specified customer.
     */
    public function show($id)
{
    $customer = User::where('role', 'customer')->findOrFail($id);
    
    // Jika request AJAX (untuk modal)
    if (request()->ajax()) {
        return view('layout.admin.customer.show', compact('customer'));
    }
    
    // Jika request biasa (untuk halaman terpisah)
    return view('layout.admin.customer.show', compact('customer'));
}

    /**
     * Activate a customer account.
     */
    public function activate($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        
        $customer->update([
            'status' => 'active'
        ]);
        
        return redirect()->route('admin.customer.index')
            ->with('success', 'Customer berhasil diaktifkan.');
    }

    /**
     * Ban a customer account.
     */
    public function ban($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        
        $customer->update([
            'status' => 'banned'
        ]);
        
        return redirect()->route('admin.customer.index')
            ->with('success', 'Customer berhasil dibanned.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);
        
        // Soft delete customer
        $customer->delete();
        
        return redirect()->route('admin.customer.index')
            ->with('success', 'Customer berhasil dihapus.');
    }

    /**
     * Get customer statistics (API endpoint if needed)
     */
    public function statistics()
    {
        $stats = [
            'total' => User::where('role', 'customer')->count(),
            'active' => User::where('role', 'customer')->where('status', 'active')->count(),
            'banned' => User::where('role', 'customer')->where('status', 'banned')->count(),
            'verify' => User::where('role', 'customer')->where('status', 'verify')->count(),
            'deleted' => User::where('role', 'customer')->onlyTrashed()->count(),
        ];
        
        return response()->json($stats);
    }

    /**
     * Show deleted customers
     */
    public function deleted()
    {
        $deletedCustomers = User::where('role', 'customer')
                                ->onlyTrashed()
                                ->orderBy('deleted_at', 'desc')
                                ->get();
        
        $totalDeleted = $deletedCustomers->count();
        
        return view('layout.admin.customer.deleted', compact('deletedCustomers', 'totalDeleted'));
    }

    /**
     * Restore deleted customer
     */
    public function restore($id)
    {
        $customer = User::where('role', 'customer')
                        ->onlyTrashed()
                        ->findOrFail($id);
        
        $customer->restore();
        
        return redirect()->route('admin.customer.deleted')
            ->with('success', 'Customer berhasil dipulihkan.');
    }

    /**
     * Force delete customer permanently
     */
    public function forceDelete($id)
    {
        $customer = User::where('role', 'customer')
                        ->onlyTrashed()
                        ->findOrFail($id);
        
        $customer->forceDelete();
        
        return redirect()->route('admin.customer.deleted')
            ->with('success', 'Customer berhasil dihapus permanen.');
    }
}