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
                            <div class="col-4 col-lg-2 d-none d-sm-block">
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
                                    <img src="{{ asset(isset($user->avatar) ? 'storage/avatars/' . $user->avatar : 'defaults/avatar.jpg') }}" alt="Admin Image" class="img-circle w-50 mb-3">
                                    <h3>{{ $user->name }}</h3>
                                    <p class="text-muted">{{ $user->email }}</p>
                                </div>
                                <button class="btn btn-block btn-outline-primary" data-toggle="modal" data-target="#updateProfile"> Edit Profile </button>
                                <button class="btn btn-block btn-danger" data-toggle="modal" data-target="#changePassword"> Change Password  </button>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="col-12 col-lg-9">
                        <div class="card shadow-none border-0">
                            <div class="card-body">
                                <p>App Name</p>
                                <h1>{{ \App\Application::first()->name }}</h1>
                                <p>Logo</p>
                                <img src="{{ asset(isset(\App\Application::first()->logo) ? 'storage/logos/' . \App\Application::first()->logo : 'defaults/logo.png') }}" alt="Admin Image" class="rounded w-25 mb-3">
                                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#updateSettings"> Edit Settings </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- Modals --}}

    {{-- Update Details --}}
    <div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="updateProfileLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateProfileLabel">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.settings.update-profile', $user->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mb-2">
                            <img src="{{ asset(isset($user->avatar) ? 'storage/avatars/' . $user->avatar : 'defaults/avatar.jpg') }}" alt="Admin Avatar" class="img-circle w-50">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                <label class="custom-file-label" for="avatar">Choose image</label>
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ $user->name }}" required autofocus autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ $user->email }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.settings.change-password', $user->id) }}">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New Password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Application --}}
    <div class="modal fade" id="updateSettings" tabindex="-1" role="dialog" aria-labelledby="updateSettingsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSettingsLabel">Update Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.settings.update', \App\Application::first()->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="text-center mb-2">
                            <img src="{{ asset(isset(\App\Application::first()->logo) ? 'storage/logos/' . \App\Application::first()->logo : 'defaults/logo.png') }}" alt="Logo" class="img-circle w-50">
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" id="logo" name="logo">
                                <label class="custom-file-label" for="logo">Choose image</label>
                                @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name" value="{{ \App\Application::first()->name }}" required autofocus autocomplete="name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
