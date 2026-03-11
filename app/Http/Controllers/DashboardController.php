<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Part;
use App\Models\User;

class DashboardController extends Controller
{
    public function klijent()
    {
        $user = auth()->user();

        $activeServices = ServiceRequest::where('user_id', $user->id)
            ->whereIn('status', ['zakazano', 'u_dijagnostici', 'u_popravci'])
            ->count();

        $nextAppointment = ServiceRequest::where('user_id', $user->id)
            ->where('status', 'zakazano')
            ->where('desired_date', '>=', now())
            ->orderBy('desired_date')
            ->first();

        $totalServices = ServiceRequest::where('user_id', $user->id)
            ->where('status', 'zavrseno')
            ->count();

        $recentServices = ServiceRequest::where('user_id', $user->id)
            ->with('vehicle')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.klijent', compact(
            'activeServices',
            'nextAppointment',
            'totalServices',
            'recentServices'
        ));
    }

    public function serviser()
    {
        $pending    = ServiceRequest::where('status', 'zakazano')->count();
        $inProgress = ServiceRequest::where('status', 'zavrsena_dijagnostika')->count();
        $lowParts   = Part::where('quantity', '<=', 2)->count();

        $todayServices = ServiceRequest::with('user', 'vehicle')
            ->where(function($query) {
                $query->whereDate('desired_date', today())
                    ->orWhereIn('status', ['zavrsena_dijagnostika', 'zakazano']);
            })
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.serviser', compact(
            'pending',
            'inProgress',
            'lowParts',
            'todayServices'
        ));
    }

    public function admin()
    {
        $scheduledServices = ServiceRequest::where('status', 'zakazano')->count();
        $completedServices = ServiceRequest::where('status', 'zavrseno')->count();
        $criticalParts     = Part::where('quantity', '<=', 2)->count();
        $activeUsers       = User::where('role', 'klijent')->count();

        $allServices = ServiceRequest::with('user', 'vehicle', 'serviser')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'scheduledServices',
            'completedServices',
            'criticalParts',
            'activeUsers',
            'allServices'
        ));
    }
}