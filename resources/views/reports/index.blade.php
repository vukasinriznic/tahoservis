@extends('layouts.app')

@section('title', 'Izveštaji')

@section('nav-links')
    <a href="{{ route('dashboard.admin') }}">Home</a>
    <a href="{{ route('users.index') }}">Korisnici</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
    <a href="{{ route('service-requests.index') }}">Servisi</a>
    <a href="{{ route('reports.index') }}" class="active">Izveštaji</a>
@endsection

@section('content')
    <div class="page-title">Izveštaji i statistike</span></div>

    {{-- Filter sekcija --}}
    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:24px;margin-bottom:28px;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <form method="GET" action="{{ route('reports.index') }}">
            <div style="display:grid;grid-template-columns:1fr 1fr 2fr auto;gap:16px;align-items:flex-end;">
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Datum od</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Datum do</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Tip izveštaja</label>
                    <select name="type"
                        style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;background:#fff;">
                        <option value="servisi"   {{ request('type','servisi') == 'servisi'   ? 'selected' : '' }}>Servisi</option>
                        <option value="delovi"    {{ request('type') == 'delovi'    ? 'selected' : '' }}>Delovi</option>
                        <option value="finansije" {{ request('type') == 'finansije' ? 'selected' : '' }}>Finansije</option>
                        <option value="serviseri" {{ request('type') == 'serviseri' ? 'selected' : '' }}>Aktivnost servisera</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn" style="width:100%;padding:10px 20px;">
                        Prikaži izveštaj
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Kartice sa podacima --}}
    <div class="cards-grid" style="margin-bottom:28px;">
        <div class="card">
            <div class="card-label">Ukupan broj servisa</div>
            <div class="card-value">{{ $totalServices }}</div>
            <div class="card-sub">U odabranom periodu</div>
        </div>
        <div class="card">
            <div class="card-label">Završene popravke</div>
            <div class="card-value">{{ $completedRepairs }}</div>
            <div class="card-sub">Status: Završeno</div>
        </div>
        <div class="card">
            <div class="card-label">Prosečno vreme obrade</div>
            <div class="card-value" style="font-size:22px;">{{ $avgDays }} dana</div>
            <div class="card-sub">Od zakazivanja do završetka</div>
        </div>
        <div class="card">
            <div class="card-label">Aktivni serviseri</div>
            <div class="card-value">{{ $activeServisers }}</div>
            <div class="card-sub">Sa dodeljenim servisima</div>
        </div>
    </div>

    {{-- Najkorišćeniji delovi --}}
    <div class="section-title">Najkorišćeniji delovi</div>
    <div class="table-wrap" style="margin-bottom:28px;">
        <table>
            <thead>
                <tr>
                    <th>Naziv dela</th>
                    <th>Kod</th>
                    <th>Ukupno korišćeno</th>
                    <th>Trenutna zaliha</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topParts as $part)
                    <tr>
                        <td>{{ $part->name }}</td>
                        <td style="color:#888;">{{ $part->code }}</td>
                        <td><span class="badge badge-blue">{{ $part->total_used }} kom</span></td>
                        <td>
                            @if($part->quantity <= 2)
                                <span class="badge badge-red">{{ $part->quantity }} kom</span>
                            @elseif($part->quantity <= 5)
                                <span class="badge badge-orange">{{ $part->quantity }} kom</span>
                            @else
                                <span class="badge badge-green">{{ $part->quantity }} kom</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#888;padding:24px;">
                            Nema podataka o korišćenim delovima.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Dugmad --}}
    <div style="display:flex;gap:12px;">
        <button onclick="window.print()" class="btn">Štampaj PDF</button>
        <a href="{{ route('dashboard.admin') }}" class="btn"
            style="background:#fff;color:#555;border:1px solid #CCCCCC;">
            Nazad na dashboard
        </a>
    </div>
@endsection