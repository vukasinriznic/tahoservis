@extends('layouts.app')

@section('title', 'Klijent Dashboard')

@section('nav-links')
    <a href="{{ route('dashboard.klijent') }}" class="active">Home</a>
    <a href="{{ route('service-requests.create') }}">Zakazivanje servisa</a>
    <a href="{{ route('service-requests.index') }}">Moji servisi</a>
    <a href="{{ route('profile.show') }}">Profil</a>
@endsection

@section('content')
    <div class="page-title">
        Dobrodošli, {{ auth()->user()->name }} {{ auth()->user()->surname }}
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Aktivni servisi</div>
            <div class="card-value">{{ $activeServices }}</div>
            <div class="card-sub">U toku</div>
        </div>
        <div class="card">
            <div class="card-label">Naredni termin</div>
            @if($nextAppointment)
                <div class="card-value" style="font-size:20px;">
                    {{ \Carbon\Carbon::parse($nextAppointment->desired_date)->format('d. M Y') }}
                </div>
                <div class="card-sub">Zakazano - {{ \Carbon\Carbon::parse($nextAppointment->desired_date)->format('H:i') }}h</div>
            @else
                <div class="card-value" style="font-size:18px;color:#888;">—</div>
                <div class="card-sub">Nema zakazanih</div>
            @endif
        </div>
        <div class="card">
            <div class="card-label">Istorija servisa</div>
            <div class="card-value">{{ $totalServices }}</div>
            <div class="card-sub">Ukupno završenih</div>
        </div>
    </div>

    <div class="section-title">Poslednji servisi</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Vozilo</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentServices as $sr)
                    <tr>
                        <td>{{ $sr->vehicle->brand }} {{ $sr->vehicle->model }} · {{ $sr->vehicle->registration }}</td>
                        <td>{{ \Carbon\Carbon::parse($sr->desired_date)->format('d.m.Y') }}</td>
                        <td>
                            @php
                                $badge = match($sr->status) {
                                    'zakazano'       => 'badge-blue',
                                    'zavrsena_dijagnostika'=> 'badge-orange',
                                    'u_popravci'     => 'badge-red',
                                    'zavrseno'       => 'badge-green',
                                    default          => 'badge-blue',
                                };
                                $label = match($sr->status) {
                                    'zakazano'       => 'Zakazano',
                                    'zavrsena_dijagnostika' => 'Zavrsena dijagnostika',
                                    'u_popravci'     => 'U popravci',
                                    'zavrseno'       => 'Završena popravka',
                                    default          => $sr->status,
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td><a href="{{ route('service-requests.show', $sr) }}" class="btn btn-sm">Detalji</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#888;padding:32px;">
                            Nemate servisa. <a href="{{ route('service-requests.create') }}" style="color:#1A73E8;font-weight:600;">Zakaži prvi →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection