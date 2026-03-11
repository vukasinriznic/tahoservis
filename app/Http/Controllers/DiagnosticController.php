<?php

namespace App\Http\Controllers;

use App\Models\Diagnostic;
use App\Models\ServiceRequest;
use App\Models\Part;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    public function index()
    {
        $diagnostics = Diagnostic::with('serviceRequest.user', 'serviceRequest.vehicle')
            ->whereHas('serviceRequest', function($query) {
                $query->where('status', 'zavrsena_dijagnostika');
            })
            ->latest()
            ->get();

        return view('diagnostics.index', compact('diagnostics'));
    }

    public function create(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load('user');
        $parts = Part::all();
        return view('diagnostics.create', compact('serviceRequest', 'parts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_request_id'  => ['required', 'exists:service_requests,id'],
            'problem_description' => ['required', 'string'],
            'diagnostic_results'  => ['required', 'string'],
            'recommended_work'    => ['nullable', 'string'],
        ]);

        Diagnostic::create([
            'service_request_id'  => $request->service_request_id,
            'problem_description' => $request->problem_description,
            'diagnostic_results'  => $request->diagnostic_results,
            'recommended_work'    => $request->recommended_work,
        ]);

        ServiceRequest::find($request->service_request_id)
            ->update([
            'status'      => 'zavrsena_dijagnostika',
            'serviser_id' => auth()->id(),
        ]);

        return redirect()->route('diagnostics.index')->with('success', 'Dijagnostika je uspešno sačuvana.');
    }
}