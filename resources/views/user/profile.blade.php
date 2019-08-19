@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            {{-- Info --}}
            <div class="col-12 col-lg-3">
                <div class="card shadow-none border-0">
                    <div class="card-body py-5">
                        <div class="user-info text-center mb-5">
                            <img src="{{ asset(isset($user->avatar) ? 'storage/avatars/' . $user->avatar : 'defaults/avatar.jpg') }}" alt="Student Image" class="w-50 img-circle shadow mb-4">
                            <h3>{{ $user->name }}</h3>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                        <div class="nav flex-column nav-pills mt-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-basic-info-tab" data-toggle="pill"
                                    href="#v-pills-basic-info" role="tab"
                                    aria-controls="v-pills-basic-info" aria-selected="true">
                                        Basic Information</a>
                            <a class="nav-link" id="v-pills-scores-tab" data-toggle="pill"
                                    href="#v-pills-scores" role="tab"
                                    aria-controls="v-pills-scores" aria-selected="false">
                                        Scores</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill"
                                    href="#v-pills-settings" role="tab"
                                    aria-controls="v-pills-settings" aria-selected="false">
                                        Settings</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Contents --}}
            <div class="col-12 col-lg-9">
                <div class="card shadow-none border-0 p-3">
                        <div class="card-body">
                            <div class="tab-content" id="v-pills-tabContent">

                                {{-- Basic Information --}}
                                <div class="tab-pane fade show active" id="v-pills-basic-info" role="tabpanel" aria-labelledby="v-pills-basic-info-tab">
                                    <div class="d-flex w-100 justify-content-start align-items-center">
                                        <h2>Basic Information</h2>
                                        <a class="ml-3" data-toggle="modal" data-target="#editStudentInfo"><i class="fas fa-edit"></i></a>
                                    </div>
                                    <div class="basic-info my-5">
                                        <div class="row my-2">
                                            <p class="col-12 col-lg-2"> Name: </p>
                                            <p class="col-12 col-lg-10"> {{ $user->name }} </p>
                                        </div>
                                        <div class="row my-2">
                                            <p class="col-12 col-lg-2"> Email Address: </p>
                                            <p class="col-12 col-lg-10"> {{ $user->email }} </p>
                                        </div>
                                        <div class="row my-2">
                                            <p class="col-12 col-lg-2"> Mobile Number: </p>
                                            <p class="col-12 col-lg-10"> {{ $user->mobile ?? 'No mobile number specified' }} </p>
                                        </div>
                                        <div class="row my-2">
                                            <p class="col-12 col-lg-2"> Address </p>
                                            <p class="col-12 col-lg-10"> {{ $user->address ?? 'No address specified' }} </p>
                                        </div>
                                        <div class="row my-2">
                                            <p class="col-12 col-lg-2"> Member Since: </p>
                                            <p class="col-12 col-lg-10"> {{ $user->created_at->diffForHumans() }} </p>
                                        </div>
                                    </div>

                                </div>

                                {{-- Scores --}}
                                <div class="tab-pane fade" id="v-pills-scores" role="tabpanel" aria-labelledby="v-pills-scores-tab">
                                    <h2>Scores</h2>
                                    <div class="scores my-5">
                                        @forelse ($user->scores->chunk(4) as $chunk)
                                            <div class="row justify-content-center">
                                                @foreach ($chunk as $key => $score)
                                                    <div class="col-12 col-lg-3">
                                                        <div class="card shadow border-0">
                                                            <div class="card-body">
                                                                <div class="d-flex align-content-center text-center">
                                                                    <h1 class="display-2 font-weight-bold">{{ $score->score * $score->quiz->points_per_question }}</h1>
                                                                    <p class="text-muted align-self-end">/ {{ $score->quiz->questions->count() * $score->quiz->points_per_question }}</p>
                                                                </div>
                                                                <span class="text-muted">Quiz taken {{ $score->created_at->diffForHumans() }}</span>
                                                                <p class="text-dark">{{ $score->quiz->title }} </p>
                                                                <a href="{{ route('score', $score->quiz->id) }}">View details..</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @empty
                                            <em> You haven't answered any quiz yet. </em>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- Settings --}}
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    <h2>Settings</h2>
                                    <button class="btn btn-danger px-4" data-toggle="modal" data-target="#changePassword"><i class="fas fa-key"></i> Change Password </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->

    {{-- Edit Information --}}
    <div class="modal fade" id="editStudentInfo" tabindex="-1" role="dialog" aria-labelledby="editUserInfoModal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserInfoModal">{{ $user->name }}'s Basic Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-row p-sm-4">
                            <div class="form-group col-12 col-lg-4 text-center p-lg-4">
                                <img src="{{ asset(isset($user->avatar) ? 'storage/avatars/' . $user->avatar : 'defaults/avatar.jpg') }}" alt="Student Image" class="w-100 img-circle shadow">
                                <div class="custom-file mt-3">
                                    <input type="file" class="custom-file-input" id="avatar" name="avatar">
                                    <label class="custom-file-label text-left" for="avatar">Choose image</label>
                                </div>
                            </div>
                            <div class="form-group col-12 col-lg-8 p-lg-4">
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}">
                                        @error('mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Change Password --}}
    <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="changePasswordModal">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('profile.change-password', $user->id) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">{{ __('New Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
