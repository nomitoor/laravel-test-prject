<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <h2>Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Name"
                        value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span style="color:red">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="email"
                        value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span style="color:red">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password"
                        value="{{ old('password') }}" required>
                    @if ($errors->has('password'))
                        <span style="color:red">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Confirm Password" value="{{ old('password_confirmation') }}" required>
                    @if ($errors->has('password_confirmation'))
                        <span style="color:red">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn">Register</button>
            </form>
            <div class="register-div">
                <a href="/login" class="btn-register">Login</a>
            </div>
        </div>
    </div>
</body>

</html>
