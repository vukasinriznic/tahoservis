@extends('layouts.app')

@section('title', 'Evidencija popravke')

@section('nav-links')
    <a href="{{ route('dashboard.serviser') }}">Home</a>
    <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
    <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
    <a href="{{ route('repairs.index') }}">Popravke</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Evidencija popravke</div>

    @if ($errors->any())
        <div style="background:#fdecea;border:1px solid #f5c6c6;color:#c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Info o servisu --}}
    <div style="background:#F5F8FF;border:1px solid #CCCCCC;border-radius:10px;padding:20px;max-width:780px;margin:0 auto 24px auto;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            <div>
                <div style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Klijent</div>
                <div style="font-size:14px;font-weight:600;color:#333;">{{ $serviceRequest->user->name }} {{ $serviceRequest->user->surname }}</div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Vozilo</div>
                <div style="font-size:14px;font-weight:600;color:#333;">{{ $serviceRequest->vehicle->brand }} {{ $serviceRequest->vehicle->model }} · {{ $serviceRequest->vehicle->registration }}</div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Tip tahografa</div>
                <div style="font-size:14px;font-weight:600;color:#333;">{{ ucfirst($serviceRequest->tachograph_type) }}</div>
            </div>
        </div>
    </div>

    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:780px;margin:0 auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <form method="POST" action="{{ route('repairs.store') }}">
            @csrf
            <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Izvršeni radovi</label>
                <textarea name="work_done" rows="4" placeholder="Opišite izvršene radove..."
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;resize:vertical;">{{ old('work_done') }}</textarea>
            </div>

            {{-- Korišćeni delovi --}}
            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:10px;">Korišćeni delovi</label>
                <div class="table-wrap" style="margin-bottom:10px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Odabir</th>
                                <th>Naziv dela</th>
                                <th>Kod</th>
                                <th>Dobavljač</th>
                                <th>Dostupno</th>
                                <th>Količina</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parts as $part)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="parts[{{ $part->id }}][selected]"
                                            value="1"
                                            style="width:16px;height:16px;cursor:pointer;">
                                    </td>
                                    <td>{{ $part->name }}</td>
                                    <td style="color:#888;">{{ $part->code }}</td>
                                    <td>{{ $part->supplier ?? '—' }}</td>
                                    <td>
                                        @if($part->quantity <= 2)
                                            <span class="badge badge-red">{{ $part->quantity }} kom</span>
                                        @elseif($part->quantity <= 5)
                                            <span class="badge badge-orange">{{ $part->quantity }} kom</span>
                                        @else
                                            <span class="badge badge-green">{{ $part->quantity }} kom</span>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" name="parts[{{ $part->id }}][quantity]"
                                            min="1" max="{{ $part->quantity }}" value="1"
                                            style="width:70px;padding:6px 10px;border:1px solid #CCCCCC;border-radius:6px;font-size:13px;">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Broj plombe</label>
                <input type="text" name="seal_number" placeholder="npr. PL-2026-00123"
                    value="{{ old('seal_number') }}"
                    style="width:100%;max-width:300px;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit"
                    style="padding:11px 28px;background:#1A73E8;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:600;cursor:pointer;">
                    Završi popravku
                </button>
                <a href="{{ route('diagnostics.index') }}"
                    style="padding:11px 28px;background:#fff;color:#555;border:1px solid #CCCCCC;border-radius:6px;font-size:15px;font-weight:600;text-decoration:none;">
                    Otkaži
                </a>
            </div>
        </form>
    </div>
@endsection