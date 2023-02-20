<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            width: 20%;
        }

        h1 {
            margin-bottom: 20px;
        }

        .form-control {
            width: 90%;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #d2d6dc;
        }

        .btn {
            width: 96%;
            padding: 10px;
            background-color: #4299e1;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #3182ce;
        }

        .btn-register {
            background-color: #dc3545;
            color: #fff;
            padding: 12px 24px;
            border-radius: 4px;
            text-decoration: none;
        }

        .btn-register:hover {
            background-color: #c82333;
            text-decoration: none;
        }

        .register-div {
            width: 96%;
            margin-top: 5px;
            display: flex;
            justify-content: end;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Login</h1>
            <form action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    @if ($errors->has('email'))
                        <span style="color:red">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span>{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">Login</button>
                </div>
                <div class="register-div">
                    <a href="/register" class="btn-register">Register</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
