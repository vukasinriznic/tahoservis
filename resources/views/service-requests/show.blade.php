@extends('layouts.app')

@section('title', 'Detalji servisa')

@section('nav-links')
    <a href="{{ route('dashboard.klijent') }}">Home</a>
    <a href="{{ route('service-requests.create') }}">Zakazivanje servisa</a>
    <a href="{{ route('service-requests.index') }}" class="active">Moji servisi</a>
    <a href="{{ route('profile.show') }}">Profil</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Detalji servisa</div>

    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:680px;margin:0 auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;">
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Vozilo</div>
                <div style="font-size:15px;color:#333;font-weight:500;">{{ $serviceRequest->vehicle->brand }} {{ $serviceRequest->vehicle->model }} · {{ $serviceRequest->vehicle->registration }}</div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Tip tahografa</div>
                <div style="font-size:15px;color:#333;font-weight:500;">{{ ucfirst($serviceRequest->tachograph_type) }}</div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Željeni termin</div>
                <div style="font-size:15px;color:#333;font-weight:500;">{{ \Carbon\Carbon::parse($serviceRequest->desired_date)->format('d.m.Y H:i') }}h</div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Kontakt telefon</div>
                <div style="font-size:15px;color:#333;font-weight:500;">{{ $serviceRequest->phone }}</div>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Status</div>
                @php
                    $badge = match($serviceRequest->status) {
                        'zakazano'       => 'badge-blue',
                        'zavrsena_dijagnostika' => 'badge-orange',
                        'zavrseno'       => 'badge-green',
                        default          => 'badge-blue',
                    };
                    $label = match($serviceRequest->status) {
                        'zakazano'       => 'Zakazano',
                        'zavrsena_dijagnostika' => 'Zavrsena dijagnostika',
                        'zavrseno'       => 'Završena popravka',
                        default          => $serviceRequest->status,
                    };
                @endphp
                <span class="badge {{ $badge }}">{{ $label }}</span>
            </div>
            <div>
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Serviser</div>
                <div style="font-size:15px;color:#333;font-weight:500;">{{ $serviceRequest->serviser ? $serviceRequest->serviser->name . ' ' . $serviceRequest->serviser->surname : '—' }}</div>
            </div>
        </div>

        @if($serviceRequest->description)
            <div style="margin-bottom:24px;">
                <div style="font-size:12px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:6px;">Opis problema</div>
                <div style="background:#F5F8FF;border:1px solid #CCCCCC;border-radius:6px;padding:14px;font-size:14px;color:#444;line-height:1.6;">
                    {{ $serviceRequest->description }}
                </div>
            </div>
        @endif

        <div style="display:flex;gap:12px;">
            <a href="{{ route('service-requests.index') }}" class="btn">← Nazad na listu</a>
        </div>
    </div>
@endsection