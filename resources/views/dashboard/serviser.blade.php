@extends('layouts.app')

@section('title', 'Serviser Dashboard')

@section('nav-links')
    <a href="{{ route('dashboard.serviser') }}" class="active">Home</a>
    <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
    <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
    <a href="{{ route('repairs.index') }}">Popravke</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
@endsection

@section('content')
    <div class="page-title">
        Dobrodošli, {{ auth()->user()->name }} {{ auth()->user()->surname }}
    </div>

    <div class="cards-grid">
        <div class="card">
            <div class="card-label">Servisi na čekanju</div>
            <div class="card-value">{{ $pending }}</div>
            <div class="card-sub">Čekaju obradu</div>
        </div>
        <div class="card">
            <div class="card-label">Trenutno u radu</div>
            <div class="card-value">{{ $inProgress }}</div>
            <div class="card-sub">Aktivne dijagnostike</div>
        </div>
        <div class="card">
            <div class="card-label">Kritične zalihe</div>
            <div class="card-value" style="{{ $lowParts > 0 ? 'color:#c0392b;' : '' }}">{{ $lowParts }}</div>
            <div class="card-sub">Delovi ispod minimuma</div>
        </div>
    </div>

    <div class="section-title">Servisni zahtevi danas</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Klijent</th>
                    <th>Vozilo</th>
                    <th>Termin</th>
                    <th>Tip tahografa</th>
                    <th>Status</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($todayServices as $sr)
                    <tr>
                        <td>{{ $sr->user->name }} {{ $sr->user->surname }}</td>
                        <td>{{ $sr->vehicle->brand }} {{ $sr->vehicle->model }} · {{ $sr->vehicle->registration }}</td>
                        <td>{{ \Carbon\Carbon::parse($sr->desired_date)->format('H:i') }}h</td>
                        <td>{{ ucfirst($sr->tachograph_type) }}</td>
                        <td>
                            @php
                                $badge = match($sr->status) {
                                    'zakazano'       => 'badge-blue',
                                    'zavrsena_dijagnostika' => 'badge-orange',
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
                        <td style="display:flex;gap:8px;justify-content:space-between">
                            @if($sr->status === 'zakazano')
                                <a href="{{ route('diagnostics.create', ['serviceRequest' => $sr->id]) }}" class="btn btn-sm">Pokreni dijagnostiku</a>
                            @elseif($sr->status === 'zavrsena_dijagnostika')
                                <a href="{{ route('repairs.create', ['serviceRequest' => $sr->id]) }}" class="btn btn-sm" style="background:#e37400;">Pokreni popravku</a>
                            @elseif($sr->status === 'zavrseno')
                                <span class="badge badge-green" style="padding:6px 12px;">Završeno</span>
                            @endif
                            <a href="{{ route('service-requests.show', $sr) }}" class="btn btn-sm" style="background:#fff;color:#1A73E8;border:1px solid #1A73E8;">Otvori zapis</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nema aktivnih servisa.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection