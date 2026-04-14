<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahoservis - Prijava</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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
            max-width: 420px;
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

        .form-group { margin-bottom: 18px; }

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
    <nav>
        <div class="nav-brand">TAHO<span>SERVIS</span></div>
    </nav>

    <div class="wrapper">
        <div class="card">
            <div class="card-title">Dobro došli <span>nazad</span></div>
            <div class="card-sub">Prijavite se na vaš nalog</div>

            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email adresa</label>
                    <input type="email" id="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="vas@email.com"
                        required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Lozinka</label>
                    <input type="password" id="password" name="password"
                        placeholder="••••••••"
                        required>
                </div>

                <button type="submit" class="btn">Prijavi se</button>
            </form>

            <div class="footer-link">
                Nemate nalog? <a href="{{ route('register') }}">Registrujte se</a>
            </div>
        </div>
    </div>
</body>
</html>
