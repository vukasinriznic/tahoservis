<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function index()
    {
        $parts = Part::when(request('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('code', 'like', '%' . request('search') . '%');
        })->latest()->get();

        return view('parts.index', compact('parts'));
    }

    public function create()
    {
        return view('parts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'code'     => ['required', 'string', 'unique:parts,code'],
            'supplier' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        Part::create($request->only('name', 'code', 'supplier', 'quantity'));

        return redirect()->route('parts.index')->with('success', 'Artikal je uspešno dodat.');
    }

    public function edit(Part $part)
    {
        return view('parts.edit', compact('part'));
    }

    public function update(Request $request, Part $part)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'code'     => ['required', 'string', 'unique:parts,code,' . $part->id],
            'supplier' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $part->update($request->only('name', 'code', 'supplier', 'quantity'));

        return redirect()->route('parts.index')->with('success', 'Artikal je uspešno ažuriran.');
    }

    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->route('parts.index')->with('success', 'Artikal je uspešno obrisan.');
    }
}