@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card shadow-none border-0 rounded-0 bg-transparent">
                    <div class="card-body text-center">
                        <p>
                            Set up your two factor authentication by scanning the barcode below. <br>
                            Alternatively, you can use the code <strong> {{ $secret }} </strong>
                        </p>
                        <div>
                            <img src="{{ $QR_Image }}" class="img-fluid bg-transparent" alt="QR Code">
                        </div>
                        <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                        <div>
                            <a href="/complete-registration">
                                <button class="btn btn-primary px-5">Complete Registration</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
