@extends('layouts.app')

@section('title', 'Servisni zahtevi')

@section('nav-links')
    @if(auth()->user()->isAdmin())
        <a href="{{ route('dashboard.admin') }}">Home</a>
        <a href="{{ route('users.index') }}">Korisnici</a>
        <a href="{{ route('parts.index') }}">Zalihe</a>
        <a href="{{ route('service-requests.index') }}" class="active">Servisi</a>
        <a href="{{ route('reports.index') }}">Izveštaji</a>
    @else
        <a href="{{ route('dashboard.serviser') }}">Home</a>
        <a href="{{ route('service-requests.index') }}" class="active">Servisni zahtevi</a>
        <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
        <a href="{{ route('repairs.index') }}">Popravke</a>
        <a href="{{ route('parts.index') }}">Zalihe</a>
    @endif
@endsection

@section('content')
    <div class="page-title">Servisni zahtevi</div>

    <div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
        <a href="{{ route('service-requests.index') }}"
            class="btn btn-sm" style="{{ !request('status') ? '' : 'background:#fff;color:#1A73E8;border:1px solid #1A73E8;box-shadow:none;' }}">
            Svi
        </a>
        <a href="{{ route('service-requests.index', ['status' => 'zakazano']) }}"
            class="btn btn-sm" style="{{ request('status') == 'zakazano' ? '' : 'background:#fff;color:#1A73E8;border:1px solid #1A73E8;box-shadow:none;' }}">
            Zakazano
        </a>
        <a href="{{ route('service-requests.index', ['status' => 'zavrsena_dijagnostika']) }}"
            class="btn btn-sm" style="{{ request('status') == 'zavrsena_dijagnostika' ? '' : 'background:#fff;color:#1A73E8;border:1px solid #1A73E8;box-shadow:none;' }}">
            Završena dijagnostika
        </a>
        <a href="{{ route('service-requests.index', ['status' => 'zavrseno']) }}"
            class="btn btn-sm" style="{{ request('status') == 'zavrseno' ? '' : 'background:#fff;color:#1A73E8;border:1px solid #1A73E8;box-shadow:none;' }}">
            Završeno
        </a>
    </div>

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
                @forelse ($serviceRequests as $sr)
                    <tr>
                        <td>{{ $sr->user->name }} {{ $sr->user->surname }}</td>
                        <td>{{ $sr->vehicle->brand }} {{ $sr->vehicle->model }} · {{ $sr->vehicle->registration }}</td>
                        <td>{{ \Carbon\Carbon::parse($sr->desired_date)->format('d.m.Y H:i') }}h</td>
                        <td>{{ ucfirst($sr->tachograph_type) }}</td>
                        <td>
                            @php
                                $badge = match($sr->status) {
                                    'zakazano'             => 'badge-blue',
                                    'zavrsena_dijagnostika'=> 'badge-orange',
                                    'u_popravci'           => 'badge-red',
                                    'zavrseno'             => 'badge-green',
                                    default                => 'badge-blue',
                                };
                                $label = match($sr->status) {
                                    'zakazano'             => 'Zakazano',
                                    'zavrsena_dijagnostika'=> 'Završena dijagnostika',
                                    'u_popravci'           => 'U popravci',
                                    'zavrseno'             => 'Završena popravka',
                                    default                => $sr->status,
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td style="display:flex;gap:8px;justify-content:space-between">
                            @if(auth()->user()->isServiser())
                                @if($sr->status === 'zakazano')
                                    <a href="{{ route('diagnostics.create', ['serviceRequest' => $sr->id]) }}"
                                        class="btn btn-sm">Pokreni dijagnostiku</a>
                                @elseif($sr->status === 'zavrsena_dijagnostika')
                                    <a href="{{ route('diagnostics.index') }}"
                                        class="btn btn-sm" style="background:#e37400;">Prikaži dijagnostiku</a>
                                @elseif($sr->status === 'zavrseno')
                                    <a href="{{ route('repairs.index') }}"
                                        class="btn btn-sm" style="background:#1e8e3e;">Prikaži popravku</a>
                                @endif
                            @endif
                            <a href="{{ route('service-requests.show', $sr) }}"
                                class="btn btn-sm" style="background:#fff;color:#1A73E8;border:1px solid #1A73E8;">Otvori zapis</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nema servisnih zahteva trenutno.
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