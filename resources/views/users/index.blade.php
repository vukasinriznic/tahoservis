@extends('layouts.app')

@section('title', 'Korisnici')

@section('nav-links')
    <a href="{{ route('dashboard.admin') }}">Home</a>
    <a href="{{ route('users.index') }}" class="active">Korisnici</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
    <a href="{{ route('service-requests.index') }}">Servisi</a>
    <a href="{{ route('reports.index') }}">Izveštaji</a>
@endsection

@section('content')


    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div class="page-title" style="margin-bottom:0;">Upravljanje korisnicima</div>
        <a href="{{ route('users.create') }}" class="btn">+ Dodaj korisnika</a>
    </div>

    {{-- Pretraga --}}
    <div style="margin-bottom:16px;">
        <form method="GET" action="{{ route('users.index') }}" style="display:flex;gap:10px;">
            <input type="text" name="search" placeholder="Pretraži po imenu, prezimenu ili emailu..."
                value="{{ request('search') }}"
                style="padding:8px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;width:340px;">
            <button type="submit" class="btn">Pretraži</button>
            @if(request('search'))
                <a href="{{ route('users.index') }}" class="btn" style="background:#fff;color:#555;border:1px solid #CCCCCC;">Poništi</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Ime i prezime</th>
                    <th>Email</th>
                    <th>Telefon</th>
                    <th>Uloga</th>
                    <th>Registrovan</th>
                    <th>Akcija</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }} {{ $user->surname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            @php
                                $badge = match($user->role) {
                                    'administrator' => 'badge-red',
                                    'serviser'      => 'badge-green',
                                    default         => 'badge-blue',
                                };
                                $label = match($user->role) {
                                    'administrator' => 'Administrator',
                                    'serviser'      => 'Serviser',
                                    default         => 'Klijent',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">{{ $label }}</span>
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td style="display:flex;gap:8px;">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm">Izmeni</a>
                            @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.destroy', $user) }}"
                                    onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background:#c0392b;">Obriši</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#888;padding:32px;">
                            Nema registrovanih korisnika.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection