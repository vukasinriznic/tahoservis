@extends('layouts.app')

@section('title', 'Izmeni korisnika')

@section('nav-links')
    <a href="{{ route('dashboard.admin') }}">Home</a>
    <a href="{{ route('users.index') }}" class="active">Korisnici</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
    <a href="{{ route('service-requests.index') }}">Servisi</a>
    <a href="{{ route('reports.index') }}">Izveštaji</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Izmeni korisnika</div>

    @if ($errors->any())
        <div style="background:#fdecea;border:1px solid #f5c6c6;color:#c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;max-width:520px;margin-left:auto;margin-right:auto;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:520px;margin:0 auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Ime</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Prezime</label>
                    <input type="text" name="surname" value="{{ old('surname', $user->surname) }}"
                        style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Email adresa</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Uloga</label>
                <select name="role"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;background:#fff;">
                    <option value="klijent"       {{ old('role', $user->role) == 'klijent'       ? 'selected' : '' }}>Klijent</option>
                    <option value="serviser"      {{ old('role', $user->role) == 'serviser'      ? 'selected' : '' }}>Serviser</option>
                    <option value="administrator" {{ old('role', $user->role) == 'administrator' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit"
                    style="padding:11px 28px;background:#1A73E8;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:600;cursor:pointer;">
                    Sačuvaj izmene
                </button>
                <a href="{{ route('users.index') }}"
                    style="padding:11px 28px;background:#fff;color:#555;border:1px solid #CCCCCC;border-radius:6px;font-size:15px;font-weight:600;text-decoration:none;">
                    Otkaži
                </a>
            </div>
        </form>
    </div>
@endsection