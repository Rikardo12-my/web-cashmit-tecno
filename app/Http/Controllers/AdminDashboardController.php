<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TarikTunai;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\LokasiCod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function index()
    {
        // ====================
        // STATISTIK UTAMA
        // ====================
        $totalTransaksi = TarikTunai::count();
        $transaksiHariIni = TarikTunai::whereDate('created_at', Carbon::today())->count();
        
        $totalCustomer = User::where('role', 'customer')->count();
        $totalPetugas = User::where('role', 'petugas')->count();
        
        $totalPendapatan = TarikTunai::where('status', 'selesai')->sum('biaya_admin');
        $pendapatanHariIni = TarikTunai::where('status', 'selesai')
            ->whereDate('created_at', Carbon::today())
            ->sum('biaya_admin');
            
        // ====================
        // STATISTIK TRANSAKSI PER STATUS
        // ====================
        $statusCounts = TarikTunai::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
            
        // Hitung persentase per status
        $statusPercentages = [];
        foreach ($statusCounts as $status => $count) {
            $statusPercentages[$status] = $totalTransaksi > 0 
                ? round(($count / $totalTransaksi) * 100, 2) 
                : 0;
        }
        
        // ====================
        // TRANSAKSI TERBARU
        // ====================
        $recentTransactions = TarikTunai::with(['user', 'petugas', 'paymentMethod', 'lokasiCod'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        // ====================
        // GRAFIK TRANSAKSI (7 HARI TERAKHIR)
        // ====================
        $chartData = $this->getTransactionChartData();
        
        // ====================
        // STATISTIK METODE PEMBAYARAN
        // ====================
        $paymentMethodStats = TarikTunai::select('payment_method_id', DB::raw('count(*) as total'))
            ->whereNotNull('payment_method_id')
            ->groupBy('payment_method_id')
            ->with('paymentMethod')
            ->get()
            ->map(function($item) use ($totalTransaksi) {
                $item->percentage = $totalTransaksi > 0 
                    ? round(($item->total / $totalTransaksi) * 100, 2) 
                    : 0;
                return $item;
            });
            
        // ====================
        // STATISTIK LOKASI COD POPULER
        // ====================
        $topLocations = LokasiCod::select('lokasi_cod.*', DB::raw('COUNT(tarik_tunais.id) as transaction_count'))
            ->leftJoin('tarik_tunais', 'lokasi_cod.id', '=', 'tarik_tunais.lokasi_cod_id')
            ->groupBy('lokasi_cod.id')
            ->orderBy('transaction_count', 'desc')
            ->limit(5)
            ->get();
            
        // ====================
        // PETUGAS TERAKTIF
        // ====================
        $topPetugas = User::where('role', 'petugas')
            ->select('users.*', DB::raw('COUNT(tarik_tunais.id) as completed_transactions'))
            ->leftJoin('tarik_tunais', function($join) {
                $join->on('users.id', '=', 'tarik_tunais.petugas_id')
                    ->where('tarik_tunais.status', 'selesai');
            })
            ->groupBy('users.id')
            ->orderBy('completed_transactions', 'desc')
            ->limit(5)
            ->get();
            
        // ====================
        // TRANSAKSI MENUNGGU TINDAKAN
        // ====================
        $pendingActions = [
            'menunggu_admin' => TarikTunai::where('status', 'menunggu_admin')->count(),
            'menunggu_verifikasi_admin' => TarikTunai::where('status', 'menunggu_verifikasi_admin')->count(),
            'menunggu_verifikasi_qris' => TarikTunai::where('status', 'menunggu_verifikasi_qris')->count(),
            'diproses' => TarikTunai::where('status', 'diproses')->count(),
        ];
        
        // ====================
        // STATISTIK TIPE TRANSAKSI (QRIS COD vs REGULAR)
        // ====================
        $transactionTypeStats = [
            'qris_cod' => TarikTunai::where('is_qris_cod', true)->count(),
            'regular' => TarikTunai::where('is_qris_cod', false)->count(),
        ];
        
        // ====================
        // WARNA UNTUK STATUS (default color)
        // ====================
        $statusColors = [
            'pending' => 'secondary',
            'menunggu_admin' => 'warning',
            'menunggu_pembayaran' => 'info',
            'menunggu_verifikasi_admin' => 'purple',
            'menunggu_verifikasi_qris' => 'orange',
            'diproses' => 'primary',
            'dalam_perjalanan' => 'blue',
            'menunggu_serah_terima' => 'teal',
            'selesai' => 'success',
            'dibatalkan_customer' => 'danger',
            'dibatalkan_admin' => 'dark',
        ];

        return view('layout.admin.dashboard', compact(
            'totalTransaksi',
            'transaksiHariIni',
            'totalCustomer',
            'totalPetugas',
            'totalPendapatan',
            'pendapatanHariIni',
            'statusCounts',
            'statusPercentages',
            'recentTransactions',
            'chartData',
            'paymentMethodStats',
            'topLocations',
            'topPetugas',
            'pendingActions',
            'transactionTypeStats',
            'statusColors'
        ));
    }
    
    /**
     * Mendapatkan data untuk chart transaksi
     */
    private function getTransactionChartData()
    {
        $days = 7;
        $data = [];
        $labels = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $formattedDate = $date->format('Y-m-d');
            
            $transactions = TarikTunai::whereDate('created_at', $formattedDate)
                ->count();
                
            $completed = TarikTunai::whereDate('created_at', $formattedDate)
                ->where('status', 'selesai')
                ->count();
                
            $revenue = TarikTunai::whereDate('created_at', $formattedDate)
                ->where('status', 'selesai')
                ->sum('biaya_admin');
                
            $labels[] = $date->format('d M');
            $data['transactions'][] = $transactions;
            $data['completed'][] = $completed;
            $data['revenue'][] = (int) $revenue;
        }
        
        return [
            'labels' => $labels,
            'datasets' => $data
        ];
    }
    
    /**
     * Mendapatkan statistik ringkas untuk widget
     */
    public function getStatsSummary()
    {
        $stats = [
            'today' => [
                'transactions' => TarikTunai::whereDate('created_at', Carbon::today())->count(),
                'revenue' => TarikTunai::where('status', 'selesai')
                    ->whereDate('created_at', Carbon::today())
                    ->sum('biaya_admin'),
                'new_customers' => User::where('role', 'customer')
                    ->whereDate('created_at', Carbon::today())
                    ->count(),
            ],
            'week' => [
                'transactions' => TarikTunai::whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'revenue' => TarikTunai::where('status', 'selesai')
                    ->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ])->sum('biaya_admin'),
            ],
            'month' => [
                'transactions' => TarikTunai::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count(),
                'revenue' => TarikTunai::where('status', 'selesai')
                    ->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->sum('biaya_admin'),
            ]
        ];
        
        return response()->json($stats);
    }
}