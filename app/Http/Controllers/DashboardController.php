<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard umum/admin
        return view('layout/admin/dashboard');
    }
    
    public function customerDashboard() 
    {
        // Pastikan hanya customer yang bisa akses
        if (Auth::user()->role !== 'customer') {
            abort(403, 'Unauthorized access.');
        }
        
        return view('layout/customer/dashboard');
    }

    public function petugasDashboard() 
    {
        // Pastikan hanya petugas yang bisa akses
        if (Auth::user()->role !== 'petugas') {
            abort(403, 'Unauthorized access.');
        }
        
        return view('layout/petugas/dashboard');
    }
}