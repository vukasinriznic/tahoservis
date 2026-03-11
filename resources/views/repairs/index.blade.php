@extends('layouts.app')

@section('title', 'Popravke')

@section('nav-links')
    <a href="{{ route('dashboard.serviser') }}">Home</a>
    <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
    <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
    <a href="{{ route('repairs.index') }}" class="active">Popravke</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
@endsection

@section('content')
    <div class="page-title">Pregled popravki</div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Klijent</th>
                    <th>Vozilo</th>
                    <th>Izvršeni radovi</th>
                    <th>Broj plombe</th>
                    <th>Datum</th>
                    <th>Status</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($repairs as $repair)
                    <tr>
                        <td>{{ $repair->serviceRequest->user->name }} {{ $repair->serviceRequest->user->surname }}</td>
                        <td>
                            {{ $repair->serviceRequest->vehicle->brand }}
                            {{ $repair->serviceRequest->vehicle->model }} ·
                            {{ $repair->serviceRequest->vehicle->registration }}
                        </td>
                        <td style="max-width:200px;">{{ \Str::limit($repair->work_done, 20) }}</td>
                        <td>{{ $repair->seal_number ?? '—' }}</td>
                        <td>{{ $repair->created_at->format('d.m.Y') }}</td>
                        <td><span class="badge badge-green">Završena popravka</span></td>
                        <td>
                            <a href="{{ route('repairs.show', $repair) }}" class="btn btn-sm" style="background:#1e8e3e;">Detalji popravke</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nema evidentiranih popravki.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection