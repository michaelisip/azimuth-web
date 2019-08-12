@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            {{-- Info --}}
            <div class="col-12 col-lg-3">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="user-info text-center my-5">
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
                                <div class="tab-pane fade show active" id="v-pills-basic-info" role="tabpanel" aria-labelledby="v-pills-basic-info-tab">
                                    <h2>Basic Information</h2>
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
                                <div class="tab-pane fade" id="v-pills-scores" role="tabpanel" aria-labelledby="v-pills-scores-tab">
                                    <h2>Scores</h2>
                                    <div class="scores my-5">
                                        @foreach ($user->scores->chunk(4) as $chunk)
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
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    Settings
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
