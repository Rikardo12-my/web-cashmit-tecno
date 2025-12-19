<?php

namespace App\Exports;

use App\Models\TarikTunai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarikTunaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = TarikTunai::with(['user', 'petugas', 'paymentMethod', 'lokasiCod'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->request->has('status') && $this->request->status != 'all') {
            $query->where('status', $this->request->status);
        }

        if ($this->request->has('start_date') && $this->request->has('end_date')) {
            $query->whereBetween('created_at', [
                $this->request->start_date . ' 00:00:00',
                $this->request->end_date . ' 23:59:59'
            ]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Customer',
            'Jumlah',
            'Metode',
            'Status',
            'Petugas',
            'Lokasi',
            'Tanggal',
            'Waktu Serah',
            'Catatan'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->user->name ?? '-',
            'Rp ' . number_format($transaction->jumlah, 0, ',', '.'),
            $transaction->paymentMethod->nama ?? '-',
            $this->getStatusLabel($transaction->status),
            $transaction->petugas->name ?? '-',
            $transaction->lokasiCod->nama_lokasi ?? '-',
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->waktu_diserahkan ? $transaction->waktu_diserahkan->format('d/m/Y H:i') : '-',
            $transaction->catatan_admin ?? '-'
        ];
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Pending',
            'diproses' => 'Diproses',
            'menunggu_petugas' => 'Menunggu Petugas',
            'dalam_perjalanan' => 'Dalam Perjalanan',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];

        return $labels[$status] ?? $status;
    }
}