@extends('layouts.app')

@section('title', 'Moj profil')

@section('nav-links')
    <a href="{{ route('dashboard.klijent') }}">Home</a>
    <a href="{{ route('service-requests.create') }}">Zakazivanje servisa</a>
    <a href="{{ route('service-requests.index') }}">Moji servisi</a>
    <a href="{{ route('profile.show') }}" class="active">Profil</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Moj profil</div>

    <!-- @if(session('success'))
        <div style="background:#e6f4ea;border:1px solid #a8d5b5;color:#1e8e3e;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;max-width:620px;margin-left:auto;margin-right:auto;">
            {{ session('success') }}
        </div>
    @endif -->

    {{-- Lični podaci --}}
    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:620px;margin:0 auto 24px auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <div style="font-size:16px;font-weight:700;color:#333;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #E8F0FE;">
            Lični podaci
        </div>

        @if($errors->any())
            <div style="background:#fdecea;border:1px solid #f5c6c6;color:#c0392b;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:13px;">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
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

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Telefon</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                    placeholder="+381 60 000 0000"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Uloga</label>
                <div style="display:inline-block;background:#E8F0FE;color:#1A73E8;border:1px solid #1A73E8;border-radius:20px;padding:4px 14px;font-size:13px;font-weight:600;">
                    {{ ucfirst($user->role) }}
                </div>
            </div>

            <button type="submit"
                style="padding:11px 28px;background:#1A73E8;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:600;cursor:pointer;">
                Sačuvaj izmene
            </button>
        </form>
    </div>

    {{-- Promena lozinke --}}
    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:620px;margin:0 auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <div style="font-size:16px;font-weight:700;color:#333;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #E8F0FE;">
            Promena lozinke
        </div>

        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Trenutna lozinka</label>
                <input type="password" name="current_password" placeholder="••••••••"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
                @error('current_password')
                    <div style="color:#c0392b;font-size:12px;margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Nova lozinka</label>
                <input type="password" name="password" placeholder="Minimalno 8 karaktera"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Potvrda nove lozinke</label>
                <input type="password" name="password_confirmation" placeholder="Ponovite novu lozinku"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <button type="submit"
                style="padding:11px 28px;background:#1A73E8;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:600;cursor:pointer;">
                Promeni lozinku
            </button>
        </form>
    </div>
@endsection