<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;

class DashboardController extends Controller
{
    public function index()
    {
        // KPI utama
        $total = Masyarakat::count();
        $layak = Masyarakat::where('status_penerima', 'layak')->count();
        $tidakLayak = Masyarakat::where('status_penerima', 'tidak_layak')->count();
        $sudah = Masyarakat::where('status_penyaluran', 'sudah')->count();
        $belum = Masyarakat::where('status_penyaluran', 'belum')->count();

        // Distribusi status ekonomi
        $statusEkonomi = Masyarakat::select('status_ekonomi')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status_ekonomi')
            ->orderBy('status_ekonomi')
            ->get();

        // Distribusi status rumah
        $statusRumah = Masyarakat::select('status_rumah')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status_rumah')
            ->get();

        // Distribusi kelayakan
        $statusPenerima = Masyarakat::select('status_penerima')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status_penerima')
            ->get();

        return view('dashboard', compact(
            'total',
            'layak',
            'tidakLayak',
            'sudah',
            'belum',
            'statusEkonomi',
            'statusRumah',
            'statusPenerima'
        ));
    }
}
