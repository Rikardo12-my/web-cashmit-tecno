@extends('layout.petugas.petugas') 

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome, {{ Auth::user()->nama }}! 👋</h1>
        <p class="text-gray-600">Selamat datang di dashboard CashMit Petugas</p>
    </div>

    <!-- Konten dashboard petugas di sini -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl p-6 text-white">
            <h3 class="text-xl font-semibold mb-2">Saldo Anda</h3>
            <p class="text-3xl font-bold">Rp 250.000</p>
        </div>
        
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold mb-2">Transaksi Terakhir</h3>
            <!-- List transaksi -->
        </div>
        
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-xl font-semibold mb-2">Quick Actions</h3>
            <!-- Tombol aksi cepat -->
        </div>
    </div>
</div>
@endsection