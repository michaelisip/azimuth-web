@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-4">
                <div class="card shadow-none border-0 rounded-0 bg-transparent">
                    <div class="card-body text-center">
                        <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                            {{ csrf_field() }}

                            <h4 class="font-weight-bolder">One Time Password</h4>
                            <p class="text-muted">Enter the digits from your Google Authenticator.</p>

                            <div class="form-group mt-5">
                                <input type="number" class="form-control" id="one_time_password" name="one_time_password" aria-describedby="otp_description" placeholder="Enter One Time Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
