@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-8 col-lg-8">
                                <h1 class="d-inline align-middle mr-3"> <strong> Top Students </strong> </h1>
                            </div>
                            <div class="col-4 col-lg-4">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"> Reports </li>
                                    <li class="breadcrumb-item active"> Top Students </li>
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
                    <div class="col-12">
                        <div class="card shadow-none border-0">
                            <div class="card-body">

                                @foreach ($quizzes->chunk(4) as $chunk)
                                    <div class="row justify-content-center">
                                        @foreach ($chunk as $quiz)
                                            <div class="col-12 col-lg-3">
                                                <div class="card shadow border-0">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Quiz</h5>
                                                        <p class="card-text">{{ $quiz->title }}</p>
                                                        <span class="text-muted">{{ $quiz->questions->count() }} Questions - {{ $quiz->questions->count() * $quiz->points_per_question }} Total Points</span>
                                                    </div>
                                                    <ul class="list-group list-group-flush px-3">
                                                        @foreach ($quiz->highestScores() as $topScore)
                                                            <li class="list-group-item d-flex w-100 justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="card-title">{{ $topScore->score }}</span> &nbsp;
                                                                    <span>
                                                                        {{ $topScore->user->name }}
                                                                    </span>
                                                                </div>
                                                                <span class="fas fa-2x
                                                                            @if($loop->first) fa-trophy
                                                                            @elseif($loop->last) fa-medal
                                                                            @else fa-award
                                                                            @endif"></span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="card-body">
                                                        <a href="{{ route('admin.reports.quiz', $quiz->id) }}" class="card-link btn btn-outline-primary">See all students scores</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
