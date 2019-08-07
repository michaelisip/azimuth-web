@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verification</div>

                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="one_time_password">One Time Password</label>
                                <input type="number" class="form-control" id="one_time_password" name="one_time_password" aria-describedby="otp_description" placeholder="Enter One Time Password">

                                <small id="otp_description" class="form-text text-muted">Enter the digits from your Google Authenticator.</small>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection