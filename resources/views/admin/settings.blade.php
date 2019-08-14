@extends('layouts.dashboard')

@section('content')

    <div class="content-wrapper">

            {{-- Header --}}
            <section class="content-header">
                <div class="container-fluid">
                    <div class="card shadow-none border-0">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-8 col-lg-10">
                                    <h1 class="d-inline align-middle mr-3"> <strong> Settings </strong> </h1>
                                </div>
                                <div class="col-4 col-lg-2">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item active"> Settings </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        {{-- Credentials --}}
                        <div class="col-12 col-lg-3">
                            <div class="card shadow-none border-0">
                                <div class="card-body">
                                    <div class="user-info text-center my-5">
                                        <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Admin Image" class="img-circle w-50 mb-3">
                                        <h3>{{ Auth::user()->name }}</h3>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                    <button class="btn btn-block btn-primary"> Edit Credentials </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-9">
                            <div class="card shadow-none border-0">
                                <div class="card-body">
                                    <p>App Name</p>
                                    <h1>Azimuth</h1>
                                    <p>Logo</p>
                                    <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" alt="Admin Image" class="rounded w-25 mb-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


    </div>

@endsection
