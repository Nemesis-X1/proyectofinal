<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Inicio de sesión del sistema" />
    <meta name="author" content="SakCode" />
    <title>Sistema de ventas - Login</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #fce4ec 0%, #f9f0ffff 50%, #eac3fcff 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .logo-container {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: -90px auto 20px auto;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .logo-container i {
            font-size: 50px;
            color: #333;
        }

        .login-title {
            font-weight: 700;
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .login-subtitle {
            font-size: 0.85rem;
            color: #888;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .form-label-custom {
            display: block;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .input-group-custom {
            background: rgba(240, 240, 240, 0.5);
            border-radius: 12px;
            padding: 12px 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .input-group-custom:focus-within {
            background: rgba(240, 240, 240, 0.8);
            box-shadow: 0 0 0 2px rgba(100, 37, 130, 0.1);
        }

        .input-group-custom i {
            color: #999;
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .input-group-custom input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.95rem;
            color: #333;
        }

        .input-group-custom input::placeholder {
            color: #bbb;
        }

        .remember-me {
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 30px;
            cursor: pointer;
        }

        .remember-me input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: #642582;
        }

        .btn-login {
            background: linear-gradient(90deg, #642582, #8e44ad);
            border: none;
            border-radius: 10px;
            color: white;
            width: 100%;
            padding: 15px;
            font-weight: 600;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(100, 37, 130, 0.3);
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(100, 37, 130, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .alert-custom {
            background: rgba(255, 0, 0, 0.1);
            color: #d32f2f;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo-container">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" style="width: 100%; height: 100%; object-fit: contain; border-radius: 20px;">
        </div>

        <h1 class="login-title">INICIO DE SESIÓN</h1>
        <p class="login-subtitle"> </p>

        @if ($errors->any())
            <div class="alert-custom">
                @foreach ($errors->all() as $item)
                    <div>{{$item}}</div>
                @endforeach
            </div>
        @endif

        <form action="{{route('login.login')}}" method="post">
            @csrf
            
            <label class="form-label-custom">CORREO ELECTRÓNICO</label>
            <div class="input-group-custom">
                <i class="far fa-envelope"></i>
                <input autofocus autocomplete="off" value="admin@admin.com" name="email" id="inputEmail" type="email" placeholder="ejemplo@gmail.com" required />
            </div>

            <label class="form-label-custom">CONTRASEÑA</label>
            <div class="input-group-custom">
                <i class="fas fa-lock"></i>
                <input name="password" value="admin" id="inputPassword" type="password" placeholder="********" required />
            </div>


            <button class="btn-login" type="submit">
                <i class="fas fa-sign-in-alt"></i>
                ENTRAR AL SISTEMA
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>
