<?php
namespace App\Http\Controllers;

use App\Models\Kunci;
use App\Models\SkPenugasan;
use App\Models\TandaTangan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSk      = SkPenugasan::count();
        $totalTtd     = TandaTangan::count();
        $totalBelumTtd = $totalSk - $totalTtd;
        $kunciAktif   = Kunci::latest()->first();

        return view('dashboard', compact(
            'totalSk',
            'totalTtd',
            'totalBelumTtd',
            'kunciAktif'
        ));
    }
}