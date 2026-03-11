<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahoservis - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F0F4FF;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        nav {
            background: linear-gradient(135deg, #1A73E8 0%, #0D47A1 100%);
            padding: 0 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            box-shadow: 0 4px 20px rgba(26,115,232,0.3);
        }

        .nav-brand {
            font-size: 22px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 2px;
        }

        .nav-brand span {
            color: #FFD700;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.15);
            color: #FFFFFF;
        }

        .nav-links a.active {
            background: rgba(255,255,255,0.2);
            color: #FFFFFF;
            font-weight: 700;
        }

        .nav-links form button {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: #FFFFFF;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }

        .nav-links form button:hover {
            background: rgba(220,53,69,0.8);
            border-color: transparent;
        }

        .main {
            padding: 36px;
            max-width: 1280px;
            margin: 0 auto;
            flex: 1;
            width: 100%;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 28px;
            letter-spacing: -0.5px;
        }

        .page-title span {
            color: #1A73E8;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 36px;
        }

        .card {
            background: #FFFFFF;
            border: none;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1A73E8, #4FC3F7);
        }

        .card-label {
            font-size: 12px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .card-value {
            font-size: 36px;
            font-weight: 800;
            color: #1A73E8;
            line-height: 1;
        }

        .card-sub {
            font-size: 13px;
            color: #999;
            margin-top: 8px;
            font-weight: 500;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 3px solid #1A73E8;
            display: inline-block;
        }

        .table-wrap {
            background: #FFFFFF;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #1A73E8 0%, #0D47A1 100%);
        }

        th {
            padding: 14px 18px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #FFFFFF;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        td {
            padding: 14px 18px;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            font-weight: 500;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #F8FBFF;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-blue    { background: #E8F0FE; color: #1A73E8; }
        .badge-green   { background: #E6F4EA; color: #1E8E3E; }
        .badge-orange  { background: #FEF3E2; color: #E37400; }
        .badge-red     { background: #FDECEA; color: #D93025; }

        .btn {
            display: inline-block;
            padding: 9px 20px;
            background: linear-gradient(135deg, #1A73E8 0%, #0D47A1 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(26,115,232,0.3);
            font-family: 'Inter', sans-serif;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(26,115,232,0.4);
        }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12px;
        }

        td {
            white-space: nowrap;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

    </style>
</head>
<body>

<nav>
    <div class="nav-brand">TAHO<span>SERVIS</span></div>
    <div class="nav-links">
        @yield('nav-links')
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Odjavi se</button>
        </form>
    </div>
</nav>

<div class="main">
    @yield('content')
    {{-- Flash notifikacije --}}
    @if(session('success'))
        <div id="flash-success" style="
            background: linear-gradient(135deg, #1E8E3E, #137333);
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(30,142,62,0.3);
            animation: slideDown 0.3s ease;
        ">
            <span>✅ &nbsp;{{ session('success') }}</span>
            <span onclick="document.getElementById('flash-success').style.display='none'"
                style="cursor:pointer;font-size:18px;opacity:0.8;">×</span>
        </div>
    @endif

    @if(session('error'))
        <div id="flash-error" style="
            background: linear-gradient(135deg, #D93025, #B31412);
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(217,48,37,0.3);
            animation: slideDown 0.3s ease;
        ">
            <span>❌ &nbsp;{{ session('error') }}</span>
            <span onclick="document.getElementById('flash-error').style.display='none'"
                style="cursor:pointer;font-size:18px;opacity:0.8;">×</span>
        </div>
    @endif

    @if(session('warning'))
        <div id="flash-warning" style="
            background: linear-gradient(135deg, #E37400, #B45E00);
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 16px rgba(227,116,0,0.3);
            animation: slideDown 0.3s ease;
        ">
            <span>⚠️ &nbsp;{{ session('warning') }}</span>
            <span onclick="document.getElementById('flash-warning').style.display='none'"
                style="cursor:pointer;font-size:18px;opacity:0.8;">×</span>
        </div>
    @endif
</div>

</body>

<script>
    setTimeout(function() {
        ['flash-success', 'flash-error', 'flash-warning'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(function() { el.style.display = 'none'; }, 500);
            }
        });
    }, 4000);
</script>

<footer style="
    background: linear-gradient(135deg, #1A73E8 0%, #0D47A1 100%);
    color: #fff;
    margin-top: 60px;
    padding: 40px 36px 20px 36px;
    box-shadow: 0 -4px 20px rgba(26,115,232,0.15);
">
    <div style="max-width:1280px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr;gap:40px;margin-bottom:32px;">

            {{-- Brend --}}
            <div>
                <div style="font-size:24px;font-weight:800;letter-spacing:2px;margin-bottom:12px;">
                    TAHO<span style="color:#FFD700;">SERVIS</span>
                </div>
                <div style="font-size:14px;color:rgba(255,255,255,0.75);line-height:1.7;max-width:280px;">
                    Profesionalni servis za kalibraciju, popravku i plombiranje tahografa. Brzo, pouzdano i stručno.
                </div>
            </div>

            {{-- Brze veze --}}
            <div>
                <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;color:#FFD700;">
                    Brze veze
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @auth
                        @if(auth()->user()->isKlijent())
                            <a href="{{ route('dashboard.klijent') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;transition:color 0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Dashboard</a>
                            <a href="{{ route('service-requests.create') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Zakaži servis</a>
                            <a href="{{ route('service-requests.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Moji servisi</a>
                            <a href="{{ route('profile.show') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Profil</a>
                        @elseif(auth()->user()->isServiser())
                            <a href="{{ route('dashboard.serviser') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Dashboard</a>
                            <a href="{{ route('service-requests.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Servisni zahtevi</a>
                            <a href="{{ route('diagnostics.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Dijagnostika</a>
                            <a href="{{ route('repairs.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Popravke</a>
                        @elseif(auth()->user()->isAdmin())
                            <a href="{{ route('dashboard.admin') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Dashboard</a>
                            <a href="{{ route('users.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Korisnici</a>
                            <a href="{{ route('parts.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Zalihe</a>
                            <a href="{{ route('reports.index') }}" style="color:rgba(255,255,255,0.8);text-decoration:none;font-size:14px;font-weight:500;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.8)'">Izveštaji</a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- Kontakt --}}
            <div>
                <div style="font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;color:#FFD700;">
                    Kontakt
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="font-size:14px;color:rgba(255,255,255,0.8);font-weight:500;">
                        📍 Bulevar Oslobođenja 12, Beograd
                    </div>
                    <div style="font-size:14px;color:rgba(255,255,255,0.8);font-weight:500;">
                        📞 +381 11 123 4567
                    </div>
                    <div style="font-size:14px;color:rgba(255,255,255,0.8);font-weight:500;">
                        ✉️ info@tahoservis.rs
                    </div>
                    <div style="font-size:14px;color:rgba(255,255,255,0.8);font-weight:500;">
                        🕐 Pon - Pet: 08:00 - 16:00
                    </div>
                </div>
            </div>

        </div>

        {{-- Divider --}}
        <div style="border-top:1px solid rgba(255,255,255,0.2);padding-top:20px;display:flex;justify-content:space-between;align-items:center;">
            <div style="font-size:13px;color:rgba(255,255,255,0.6);">
                © {{ date('Y') }} TahoServis. Sva prava zadržana.
            </div>
            <div style="font-size:13px;color:rgba(255,255,255,0.6);">
                Verzija 1.0.0
            </div>
        </div>
    </div>
</footer>
</html>