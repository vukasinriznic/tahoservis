<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahoservis - Registracija</title>
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
            height: 64px;
            box-shadow: 0 4px 20px rgba(26,115,232,0.3);
        }

        .nav-brand {
            font-size: 22px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 2px;
        }

        .nav-brand span { color: #FFD700; }

        .wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 44px 40px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #1A73E8, #4FC3F7);
        }

        .card-title {
            font-size: 22px;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 4px;
            letter-spacing: -0.5px;
        }

        .card-title span { color: #1A73E8; }

        .card-sub {
            font-size: 13px;
            color: #888;
            font-weight: 500;
            margin-bottom: 32px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group { margin-bottom: 16px; }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #FAFAFA;
            color: #333;
            outline: none;
            transition: border-color 0.2s, background 0.2s;
        }

        input:focus {
            border-color: #1A73E8;
            background: #FFFFFF;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #E8F0FE;
            color: #1A73E8;
            border: 1px solid #c5d8fb;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 4px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #1A73E8 0%, #0D47A1 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(26,115,232,0.3);
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(26,115,232,0.4);
        }

        .error {
            background: #FDECEA;
            border: 1px solid #f5c6c6;
            color: #D93025;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .footer-link {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #666;
            font-weight: 500;
        }

        .footer-link a {
            color: #1A73E8;
            text-decoration: none;
            font-weight: 700;
        }

        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="card">
            <div class="card-title">Kreirajte nalog</div>
            <div class="card-sub">Registracija novog klijenta</div>

            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <div class="form-group">
                        <label for="name">Ime</label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name') }}"
                            placeholder="Vaše ime"
                            required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="surname">Prezime</label>
                        <input type="text" id="surname" name="surname"
                            value="{{ old('surname') }}"
                            placeholder="Vaše prezime"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email adresa</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="vas@email.com"
                        required>
                </div>

                <div class="form-group">
                    <label for="phone">Telefon</label>
                    <input type="text" id="phone" name="phone"
                        value="{{ old('phone') }}"
                        placeholder="+381 60 000 0000">
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="password">Lozinka</label>
                        <input type="password" id="password" name="password"
                            placeholder="Min. 8 karaktera"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Potvrda</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Ponovite lozinku"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Uloga</label>
                    <div class="role-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Klijent
                    </div>
                </div>

                <button type="submit" class="btn">Registruj se</button>
            </form>

            <div class="footer-link">
                Već imate nalog? <a href="{{ route('login') }}">Prijavite se</a>
            </div>
        </div>
    </div>
</body>
</html>
