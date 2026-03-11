@extends('layouts.app')

@section('title', 'Moji servisi')

@section('nav-links')
    <a href="{{ route('dashboard.klijent') }}">Home</a>
    <a href="{{ route('service-requests.create') }}">Zakazivanje servisa</a>
    <a href="{{ route('service-requests.index') }}" class="active">Moji servisi</a>
    <a href="{{ route('profile.show') }}">Profil</a>
@endsection

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div class="page-title" style="margin-bottom:0;">Moji servisi</div>
        <a href="{{ route('service-requests.create') }}" class="btn">+ Zakaži novi servis</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Vozilo</th>
                    <th>Datum</th>
                    <th>Tip tahografa</th>
                    <th>Status</th>
                    <th>Serviser</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($serviceRequests as $sr)
                    <tr>
                        <td>{{ $sr->vehicle->brand }} {{ $sr->vehicle->model }} · {{ $sr->vehicle->registration }}</td>
                        <td>{{ \Carbon\Carbon::parse($sr->desired_date)->format('d.m.Y H:i') }}h</td>
                        <td>{{ ucfirst($sr->tachograph_type) }}</td>
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
                        <td>{{ $sr->serviser ? $sr->serviser->name . ' ' . $sr->serviser->surname : '—' }}</td>
                        <td><a href="{{ route('service-requests.show', $sr) }}" class="btn btn-sm">Detalji</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nemate zakazanih servisa. <a href="{{ route('service-requests.create') }}" style="color:#1A73E8;font-weight:600;">Zakaži prvi servis →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($serviceRequests->hasPages())
        <div style="display:flex;justify-content:center;align-items:center;gap:8px;margin-top:24px;">
            @if($serviceRequests->onFirstPage())
                <span style="padding:8px 16px;border-radius:8px;background:#fff;color:#ccc;border:1px solid #eee;font-size:14px;font-weight:600;">← Prethodna</span>
            @else
                <a href="{{ $serviceRequests->previousPageUrl() }}" style="padding:8px 16px;border-radius:8px;background:#fff;color:#1A73E8;border:1px solid #1A73E8;font-size:14px;font-weight:600;text-decoration:none;">← Prethodna</a>
            @endif

            @foreach($serviceRequests->getUrlRange(1, $serviceRequests->lastPage()) as $page => $url)
                @if($page == $serviceRequests->currentPage())
                    <span style="padding:8px 14px;border-radius:8px;background:linear-gradient(135deg,#1A73E8,#0D47A1);color:#fff;font-size:14px;font-weight:700;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:8px 14px;border-radius:8px;background:#fff;color:#1A73E8;border:1px solid #1A73E8;font-size:14px;font-weight:600;text-decoration:none;">{{ $page }}</a>
                @endif
            @endforeach

            @if($serviceRequests->hasMorePages())
                <a href="{{ $serviceRequests->nextPageUrl() }}" style="padding:8px 16px;border-radius:8px;background:#fff;color:#1A73E8;border:1px solid #1A73E8;font-size:14px;font-weight:600;text-decoration:none;">Sledeća →</a>
            @else
                <span style="padding:8px 16px;border-radius:8px;background:#fff;color:#ccc;border:1px solid #eee;font-size:14px;font-weight:600;">Sledeća →</span>
            @endif
        </div>
    @endif
@endsection