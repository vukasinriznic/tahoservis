@extends('layouts.app')

@section('title', 'Detalji popravke')

@section('nav-links')
    <a href="{{ route('dashboard.serviser') }}">Home</a>
    <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
    <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
    <a href="{{ route('repairs.index') }}" class="active">Popravke</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Detalji popravke</div>

    {{-- Info kartica --}}
    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:700px;margin:0 auto 24px auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">

        <div style="font-size:16px;font-weight:700;color:#333;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #E8F0FE;">
            Osnovne informacije
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Klijent</div>
                <div style="font-size:15px;color:#333;font-weight:500;">
                    {{ $repair->serviceRequest->user->name }} {{ $repair->serviceRequest->user->surname }}
                </div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Vozilo</div>
                <div style="font-size:15px;color:#333;font-weight:500;">
                    {{ $repair->serviceRequest->vehicle->brand }}
                    {{ $repair->serviceRequest->vehicle->model }} ·
                    {{ $repair->serviceRequest->vehicle->registration }}
                </div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Broj plombe</div>
                <div style="font-size:15px;color:#333;font-weight:500;">
                    {{ $repair->seal_number ?? '—' }}
                </div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Datum popravke</div>
                <div style="font-size:15px;color:#333;font-weight:500;">
                    {{ $repair->created_at->format('d.m.Y') }}
                </div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Tip tahografa</div>
                <div style="font-size:15px;color:#333;font-weight:500;">
                    {{ ucfirst($repair->serviceRequest->tachograph_type) }}
                </div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Status</div>
                <span class="badge badge-green">Završena popravka</span>
            </div>
        </div>

        <div style="margin-bottom:24px;">
            <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:6px;">Izvršeni radovi</div>
            <div style="background:#F5F8FF;border:1px solid #CCCCCC;border-radius:6px;padding:14px;font-size:14px;color:#444;line-height:1.6;">
                {{ $repair->work_done }}
            </div>
        </div>

        {{-- Korišćeni delovi --}}
        @if($repair->repairParts->count() > 0)
            <div style="font-size:16px;font-weight:700;color:#333;margin-bottom:14px;padding-bottom:10px;border-bottom:2px solid #E8F0FE;">
                Korišćeni delovi
            </div>
            <div class="table-wrap" style="margin-bottom:24px;">
                <table>
                    <thead>
                        <tr>
                            <th>Naziv dela</th>
                            <th>Kod</th>
                            <th>Dobavljač</th>
                            <th>Količina</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repair->repairParts as $rp)
                            <tr>
                                <td>{{ $rp->part->name }}</td>
                                <td style="color:#888;">{{ $rp->part->code }}</td>
                                <td>{{ $rp->part->supplier ?? '—' }}</td>
                                <td><span class="badge badge-blue">{{ $rp->quantity_used }} kom</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <a href="{{ route('repairs.index') }}" class="btn">← Nazad na listu</a>
    </div>
@endsection