@extends('layouts.app')

@section('title', 'Zalihe')

@section('nav-links')
    @if(auth()->user()->isAdmin())
        <a href="{{ route('dashboard.admin') }}">Home</a>
        <a href="{{ route('users.index') }}">Korisnici</a>
        <a href="{{ route('parts.index') }}" class="active">Zalihe</a>
        <a href="{{ route('service-requests.index') }}">Servisi</a>
        <a href="{{ route('reports.index') }}">Izveštaji</a>
    @else
        <a href="{{ route('dashboard.serviser') }}">Home</a>
        <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
        <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
        <a href="{{ route('repairs.index') }}">Popravke</a>
        <a href="{{ route('parts.index') }}" class="active">Zalihe</a>
    @endif
@endsection

@section('content')
    <div class="page-title">Upravljanje zalihama</div>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <form method="GET" action="{{ route('parts.index') }}" style="display:flex;gap:10px;">
            <input type="text" name="search" placeholder="Pretraži po nazivu ili kodu..."
                value="{{ request('search') }}"
                style="padding:8px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;width:280px;">
            <button type="submit" class="btn">Pretraži</button>
            @if(request('search'))
                <a href="{{ route('parts.index') }}" class="btn" style="background:#fff;color:#555;border:1px solid #CCCCCC;">Poništi</a>
            @endif
        </form>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('parts.create') }}" class="btn">+ Dodaj artikal</a>
        @endif
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Naziv dela</th>
                    <th>Kod proizvoda</th>
                    <th>Dobavljač</th>
                    <th>Količina</th>
                    @if(auth()->user()->isAdmin())
                        <th>Akcija</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($parts as $part)
                    <tr>
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
                        @if(auth()->user()->isAdmin())
                            <td style="display:flex;gap:8px;">
                                <a href="{{ route('parts.edit', $part) }}" class="btn btn-sm">Izmeni</a>
                                <form method="POST" action="{{ route('parts.destroy', $part) }}"
                                    onsubmit="return confirm('Da li ste sigurni?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm"
                                        style="background:#c0392b;">Obriši</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#888;padding:32px;">
                            Nema artikala u zalihama.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection