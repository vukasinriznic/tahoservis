<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tahoservis - Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #E8F0FE;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #FFFFFF;
            border: 1px solid #CCCCCC;
            border-radius: 10px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        }

        .logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1A73E8;
            letter-spacing: 1px;
        }

        .logo p {
            font-size: 13px;
            color: #666;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #CCCCCC;
            border-radius: 6px;
            font-size: 14px;
            background: #FFFFFF;
            color: #333;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus {
            border-color: #1A73E8;
        }

        .btn {
            width: 100%;
            padding: 11px;
            background-color: #1A73E8;
            color: #FFFFFF;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 6px;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #1558b0;
        }

        .error {
            background: #fdecea;
            border: 1px solid #f5c6c6;
            color: #c0392b;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #555;
        }

        .footer-link a {
            color: #1A73E8;
            text-decoration: none;
            font-weight: 600;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">
            <h1>TAHOSERVIS</h1>
            <p>Servisiranje tahografa</p>
        </div>

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
</body>
</html>