<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from ?? now()->startOfMonth()->toDateString();
        $dateTo   = $request->date_to   ?? now()->toDateString();

        $query = ServiceRequest::whereBetween('created_at', [$dateFrom, $dateTo]);

        $totalServices    = $query->count();
        $completedRepairs = (clone $query)->where('status', 'zavrseno')->count();
        $activeServisers  = User::where('role', 'serviser')
                                ->whereHas('serviceRequests')
                                ->count();

        // Prosecno vreme obrade u danima
        $avgDays = round(
            ServiceRequest::where('status', 'zavrseno')
                ->whereBetween('created_at', [$dateFrom, $dateTo])
                ->selectRaw('AVG(DATEDIFF(updated_at, created_at)) as avg_days')
                ->value('avg_days') ?? 0
        );

        // Najkorisceniji delovi
        $topParts = Part::withSum('repairParts as total_used', 'quantity_used')
                        ->orderByDesc('total_used')
                        ->take(5)
                        ->get();

        return view('reports.index', compact(
            'totalServices',
            'completedRepairs',
            'avgDays',
            'activeServisers',
            'topParts'
        ));
    }
}