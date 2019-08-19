
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Sign In</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="hold-transition login-page">

    <div class="login-box">

        <div class="login-logo">
            {{-- <a href="../../index2.html"><b>{{ config('app.name', 'Azimuth') }}</b></a> --}}
        </div>

        <div class="card">
            <div class="card-body login-card-body">

                <div class="text-center">
                    <img src="{{ asset('storage/logos/' . \App\Application::first()->logo) }}" alt="Logo" class="w-100 p-2">
                </div>

                <p class="login-box-msg">Sign in to start your session</p>

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
