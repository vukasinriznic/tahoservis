<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\RepairPart;
use App\Models\ServiceRequest;
use App\Models\Part;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    public function index()
    {
        $repairs = Repair::with('serviceRequest.user')->latest()->get();
        return view('repairs.index', compact('repairs'));
    }

    public function create(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load('user', 'vehicle');
        $parts = Part::all();
        return view('repairs.create', compact('serviceRequest', 'parts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_request_id' => ['required', 'exists:service_requests,id'],
            'work_done'          => ['required', 'string'],
            'seal_number'        => ['nullable', 'string'],
        ]);

        $repair = Repair::create([
            'service_request_id' => $request->service_request_id,
            'work_done'          => $request->work_done,
            'seal_number'        => $request->seal_number,
        ]);

        if ($request->has('parts')) {
            foreach ($request->parts as $partId => $data) {
                if (!empty($data['selected'])) {
                    $quantity = (int) $data['quantity'];

                    RepairPart::create([
                        'repair_id'     => $repair->id,
                        'part_id'       => $partId,
                        'quantity_used' => $quantity,
                    ]);

                    Part::where('id', $partId)->decrement('quantity', $quantity);
                }
            }
        }

        ServiceRequest::find($request->service_request_id)
            ->update(['status' => 'zavrseno']);

        return redirect()->route('repairs.index')->with('success', 'Popravka je uspešno završena.');
    }

    public function show(Repair $repair)
    {
        $repair->load('serviceRequest.user', 'serviceRequest.vehicle', 'repairParts.part');
        return view('repairs.show', compact('repair'));
    }
}