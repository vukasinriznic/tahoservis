@extends('layouts.app')

@section('title', 'Administrator Dashboard')

@section('nav-links')
    <a href="{{ route('dashboard.admin') }}" class="active">Home</a>
    <a href="{{ route('users.index') }}">Korisnici</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
    <a href="{{ route('service-requests.index') }}">Servisi</a>
    <a href="{{ route('reports.index') }}">Izveštaji</a>
@endsection

@section('content')
    <div class="page-title">
        Dobrodošli, {{ auth()->user()->name }} {{ auth()->user()->surname }}
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Zakazani servisi</div>
            <div class="card-value">{{ $scheduledServices }}</div>
            <div class="card-sub">Čekaju obradu</div>
        </div>
        <div class="card">
            <div class="card-label">Obrađeni servisi</div>
            <div class="card-value">{{ $completedServices }}</div>
            <div class="card-sub">Ukupno završenih</div>
        </div>
        <div class="card">
            <div class="card-label">Kritične zalihe</div>
            <div class="card-value" style="{{ $criticalParts > 0 ? 'color:#c0392b;' : '' }}">{{ $criticalParts }}</div>
            <div class="card-sub">Delovi ispod minimuma</div>
        </div>
        <div class="card">
            <div class="card-label">Aktivni korisnici</div>
            <div class="card-value">{{ $activeUsers }}</div>
            <div class="card-sub">Registrovanih klijenata</div>
        </div>
    </div>

    <div class="section-title">Pregled svih servisa</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Klijent</th>
                    <th>Vozilo</th>
                    <th>Datum</th>
                    <th>Serviser</th>
                    <th>Status</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($allServices as $sr)
                    <tr>
                        <td>{{ $sr->user->name }} {{ $sr->user->surname }}</td>
                        <td>{{ $sr->vehicle->brand }} {{ $sr->vehicle->model }} · {{ $sr->vehicle->registration }}</td>
                        <td>{{ \Carbon\Carbon::parse($sr->desired_date)->format('d.m.Y') }}</td>
                        <td>{{ $sr->serviser ? $sr->serviser->name . ' ' . $sr->serviser->surname : '—' }}</td>
                        <td>
                            @php
                                $badge = match($sr->status) {
                                    'zakazano'       => 'badge-blue',
                                    'zavrsena_dijagnostika' => 'badge-orange',
                                    'zavrseno'       => 'badge-green',
                                    default          => 'badge-blue',
                                };
                                $label = match($sr->status) {
                                    'zakazano'       => 'Zakazano',
                                    'zavrsena_dijagnostika' => 'Završena dijagnostika',
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
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nema servisa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection