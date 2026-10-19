<?php

namespace App\Http\Controllers;

use App\Models\TbTransaksi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OwnerController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'tanggal_awal' => ['nullable', 'date'],
            'tanggal_akhir' => ['nullable', 'date', 'after_or_equal:tanggal_awal'],
        ]);

        $query = TbTransaksi::with(['kendaraan', 'area', 'petugas', 'tarif'])
            ->whereNotNull('waktu_keluar');

        if (! empty($filters['tanggal_awal'])) {
            $query->whereDate('waktu_keluar', '>=', $filters['tanggal_awal']);
        }
        if (! empty($filters['tanggal_akhir'])) {
            $query->whereDate('waktu_keluar', '<=', $filters['tanggal_akhir']);
        }

        $report = (clone $query)->latest('waktu_keluar')->paginate(25)->withQueryString();
        $totalPendapatan = (clone $query)->sum('biaya');

        return view('owner.index', [
            'transactions' => $report,
            'totalPendapatan' => $totalPendapatan,
            'tanggalAwal' => $filters['tanggal_awal'] ?? '',
            'tanggalAkhir' => $filters['tanggal_akhir'] ?? '',
        ]);
    }
}
