@extends('layouts.app')

@section('title', 'Zakazivanje servisa')

@section('nav-links')
    <a href="{{ route('dashboard.klijent') }}">Home</a>
    <a href="{{ route('service-requests.create') }}" class="active">Zakazivanje servisa</a>
    <a href="{{ route('service-requests.index') }}">Moji servisi</a>
    <a href="{{ route('profile.show') }}">Profil</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Zakazivanje servisa tahografa</div>

    @if ($errors->any())
        <div style="background:#fdecea;border:1px solid #f5c6c6;color:#c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div style="background:#fff;margin: 0 auto;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:620px;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <form method="POST" action="{{ route('service-requests.store') }}">
            @csrf

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Vozilo</label>
                <select name="vehicle_id"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;background:#fff;color:#333;">
                    <option value="">-- Odaberite vozilo --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->brand }} {{ $vehicle->model }} · {{ $vehicle->registration }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dodaj novo vozilo --}}
            <div style="background:#F5F8FF;border:1px solid #CCCCCC;border-radius:8px;padding:20px;margin-bottom:18px;">
                <div style="font-size:13px;font-weight:600;color:#555;margin-bottom:12px;">
                    Ili dodaj novo vozilo
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:4px;">Marka</label>
                        <input type="text" name="brand" placeholder="npr. Volkswagen"
                            value="{{ old('brand') }}"
                            style="width:100%;padding:8px 12px;border:1px solid #CCCCCC;border-radius:6px;font-size:13px;outline:none;">
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:4px;">Model</label>
                        <input type="text" name="model" placeholder="npr. Transporter"
                            value="{{ old('model') }}"
                            style="width:100%;padding:8px 12px;border:1px solid #CCCCCC;border-radius:6px;font-size:13px;outline:none;">
                    </div>
                    <div>
                        <label style="display:block;font-size:12px;font-weight:600;color:#555;margin-bottom:4px;">Registracija</label>
                        <input type="text" name="registration" placeholder="npr. BG-123-AB"
                            value="{{ old('registration') }}"
                            style="width:100%;padding:8px 12px;border:1px solid #CCCCCC;border-radius:6px;font-size:13px;outline:none;">
                    </div>
                </div>
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Tip tahografa</label>
                <select name="tachograph_type"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;background:#fff;color:#333;">
                    <option value="">-- Odaberite tip --</option>
                    <option value="analogni" {{ old('tachograph_type') == 'analogni' ? 'selected' : '' }}>Analogni</option>
                    <option value="digitalni" {{ old('tachograph_type') == 'digitalni' ? 'selected' : '' }}>Digitalni</option>
                </select>
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">
                    Opis problema <span style="font-weight:400;color:#888;">(opciono)</span>
                </label>
                <textarea name="description" rows="3" placeholder="Opišite problem ili simptome..."
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;resize:vertical;">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Željeni termin</label>
                <input type="datetime-local" name="desired_date"
                    value="{{ old('desired_date') }}"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Kontakt telefon</label>
                <input type="text" name="phone" placeholder="+381 60 000 0000"
                    value="{{ old('phone', auth()->user()->phone) }}"
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit"
                    style="padding:11px 28px;background:#1A73E8;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:600;cursor:pointer;">
                    Potvrdi zakazivanje
                </button>
                <a href="{{ route('dashboard.klijent') }}"
                    style="padding:11px 28px;background:#fff;color:#555;border:1px solid #CCCCCC;border-radius:6px;font-size:15px;font-weight:600;text-decoration:none;">
                    Otkaži
                </a>
            </div>
        </form>
    </div>
@endsection