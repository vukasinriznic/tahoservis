@extends('layouts.app')

@section('title', 'Dijagnostika')

@section('nav-links')
    <a href="{{ route('dashboard.serviser') }}">Home</a>
    <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
    <a href="{{ route('diagnostics.index') }}" class="active">Dijagnostika</a>
    <a href="{{ route('repairs.index') }}">Popravke</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
@endsection

@section('content')
    <div class="page-title">Završene dijagnostike</div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Klijent</th>
                    <th>Vozilo</th>
                    <th>Opis problema</th>
                    <th>Preporučeni radovi</th>
                    <th>Datum</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($diagnostics as $diag)
                    <tr>
                        <td>{{ $diag->serviceRequest->user->name }} {{ $diag->serviceRequest->user->surname }}</td>
                        <td>
                            {{ $diag->serviceRequest->vehicle->brand }}
                            {{ $diag->serviceRequest->vehicle->model }} ·
                            {{ $diag->serviceRequest->vehicle->registration }}
                        </td>
                        <td style="max-width:200px;">{{ \Str::limit($diag->problem_description, 28) }}</td>
                        <td style="max-width:200px;">{{ $diag->recommended_work ? \Str::limit($diag->recommended_work, 28) : '—' }}</td>
                        <td>{{ $diag->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if($diag->serviceRequest->status === 'zavrsena_dijagnostika')
                                <a href="{{ route('repairs.create', ['serviceRequest' => $diag->service_request_id]) }}"
                                    class="btn btn-sm">Pokreni popravku</a>
                            @elseif($diag->serviceRequest->status === 'zavrseno')
                                <span class="badge badge-green" style="padding:6px 12px;">Popravka završena</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nema završenih dijagnostika.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection