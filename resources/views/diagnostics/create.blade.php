@extends('layouts.app')

@section('title', 'Dijagnostika')

@section('nav-links')
    <a href="{{ route('dashboard.serviser') }}">Home</a>
    <a href="{{ route('service-requests.index') }}">Servisni zahtevi</a>
    <a href="{{ route('diagnostics.index') }}">Dijagnostika</a>
    <a href="{{ route('repairs.index') }}">Popravke</a>
    <a href="{{ route('parts.index') }}">Zalihe</a>
@endsection

@section('content')
    <div class="page-title" style="text-align:center;">Dijagnostika tahografa</div>

    @if ($errors->any())
        <div style="background:#fdecea;border:1px solid #f5c6c6;color:#c0392b;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Info o servisu --}}
    <div style="background:#F5F8FF;border:1px solid #CCCCCC;border-radius:10px;padding:20px;max-width:780px;margin:0 auto 24px auto;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
            <div>
                <div style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Klijent</div>
                <div style="font-size:14px;font-weight:600;color:#333;">{{ $serviceRequest->user->name }} {{ $serviceRequest->user->surname }}</div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Vozilo</div>
                <div style="font-size:14px;font-weight:600;color:#333;">{{ $serviceRequest->vehicle->brand }} {{ $serviceRequest->vehicle->model }} · {{ $serviceRequest->vehicle->registration }}</div>
            </div>
            <div>
                <div style="font-size:11px;font-weight:600;color:#888;text-transform:uppercase;margin-bottom:4px;">Tip tahografa</div>
                <div style="font-size:14px;font-weight:600;color:#333;">{{ ucfirst($serviceRequest->tachograph_type) }}</div>
            </div>
        </div>
    </div>

    <div style="background:#fff;border:1px solid #CCCCCC;border-radius:10px;padding:36px;max-width:780px;margin:0 auto;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <form method="POST" action="{{ route('diagnostics.store') }}">
            @csrf
            <input type="hidden" name="service_request_id" value="{{ $serviceRequest->id }}">

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Opis problema</label>
                <textarea name="problem_description" rows="3" placeholder="Opišite uočeni problem..."
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;resize:vertical;">{{ old('problem_description') }}</textarea>
            </div>

            <div style="margin-bottom:18px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">Rezultati dijagnostike</label>
                <textarea name="diagnostic_results" rows="4" placeholder="Unesite rezultate dijagnostike..."
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;resize:vertical;">{{ old('diagnostic_results') }}</textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block;font-size:13px;font-weight:600;color:#333;margin-bottom:6px;">
                    Preporučeni radovi <span style="font-weight:400;color:#888;">(opciono)</span>
                </label>
                <textarea name="recommended_work" rows="3" placeholder="Navedite preporučene radove..."
                    style="width:100%;padding:10px 14px;border:1px solid #CCCCCC;border-radius:6px;font-size:14px;outline:none;resize:vertical;">{{ old('recommended_work') }}</textarea>
            </div>

            {{-- Dostupni delovi --}}
            <div style="margin-bottom:24px;">
                <div class="section-title">Dostupni delovi u skladištu</div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Naziv dela</th>
                                <th>Kod</th>
                                <th>Kategorija</th>
                                <th>Cena</th>
                                <th>Zaliha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($parts as $part)
                                <tr>
                                    <td>{{ $part->name }}</td>
                                    <td style="color:#888;">{{ $part->code }}</td>
                                    <td>{{ $part->supplier ?? '—' }}</td>
                                    <td>—</td>
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
                                    <td colspan="5" style="text-align:center;color:#888;padding:20px;">Nema delova u skladištu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit"
                    style="padding:11px 28px;background:#1A73E8;color:#fff;border:none;border-radius:6px;font-size:15px;font-weight:600;cursor:pointer;">
                    Sačuvaj dijagnostiku
                </button>
                <a href="{{ route('service-requests.index') }}"
                    style="padding:11px 28px;background:#fff;color:#555;border:1px solid #CCCCCC;border-radius:6px;font-size:15px;font-weight:600;text-decoration:none;">
                    Otkaži
                </a>
            </div>
        </form>
    </div>
@endsection