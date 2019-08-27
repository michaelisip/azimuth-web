@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-3">
            <div class="card shadow-none border-0 rounded-0 bg-transparent">
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-12">
                                <img src="{{ asset(isset(\App\Application::first()->logo) ? 'storage/logos/' . \App\Application::first()->logo : 'defaults/logo.png') }}" alt="Logo" class="w-100 p-2">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email Address" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-12">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-3">
                            <div class="col-12 text-center">
                                Don't have an account?
                                <a class="btn-link" href="{{ route('register') }}">
                                    {{ __(" Register.") }}
                                </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
