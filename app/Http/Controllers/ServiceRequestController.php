<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isServiser() || $user->isAdmin()) {
            $serviceRequests = ServiceRequest::with('user', 'vehicle', 'serviser')
                ->when(request('status'), function($query) {
                    $query->where('status', request('status'));
                })
                ->latest()
                ->paginate(10);
            return view('service-requests.index-serviser', compact('serviceRequests'));
        }

        $serviceRequests = ServiceRequest::where('user_id', $user->id)
            ->with('vehicle', 'serviser')
            ->when(request('status'), function($query) {
                $query->where('status', request('status'));
            })
            ->latest()
            ->paginate(10);
        return view('service-requests.index', compact('serviceRequests'));
    }

    public function create()
    {
        $vehicles = Vehicle::where('user_id', auth()->id())->get();
        return view('service-requests.create', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tachograph_type' => ['required', 'in:analogni,digitalni'],
            'description'     => ['nullable', 'string'],
            'desired_date'    => ['required', 'date'],
            'phone'           => ['required', 'string'],
        ]);

        // Ako je odabrano postojeće vozilo
        if ($request->vehicle_id) {
            $vehicleId = $request->vehicle_id;
        } else {
            // Kreiraj novo vozilo
            $request->validate([
                'registration' => ['required', 'string'],
                'brand'        => ['nullable', 'string'],
                'model'        => ['nullable', 'string'],
            ]);

            $vehicle = Vehicle::create([
                'user_id'      => auth()->id(),
                'registration' => $request->registration,
                'brand'        => $request->brand,
                'model'        => $request->model,
            ]);

            $vehicleId = $vehicle->id;
        }

        ServiceRequest::create([
            'user_id'         => auth()->id(),
            'vehicle_id'      => $vehicleId,
            'tachograph_type' => $request->tachograph_type,
            'description'     => $request->description,
            'desired_date'    => $request->desired_date,
            'phone'           => $request->phone,
            'status'          => 'zakazano',
        ]);

        return redirect()->route('service-requests.index')->with('success', 'Servis je uspešno zakazan.');
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load('vehicle', 'user', 'serviser');
        return view('service-requests.show', compact('serviceRequest'));
    }
}