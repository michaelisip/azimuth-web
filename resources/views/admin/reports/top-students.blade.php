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
                            <div class="col-4 col-lg-4 d-none d-sm-block">
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

                                @forelse ($quizzes->chunk(4) as $chunk)
                                    <div class="row justify-content-center">
                                        @foreach ($chunk as $quiz)
                                            <div class="col-12 col-lg-3">
                                                <div class="card shadow border-0">
                                                    <div class="card-body">
                                                        <h5 class="card-title font-weight-bold">{{ $quiz->title }}</h5>
                                                        <p class="card-text">{{ $quiz->description }}</p>
                                                        <span class="text-muted">{{ $quiz->questions->count() }} Questions - {{ $quiz->questions->count() * $quiz->points_per_question }} Total Points</span>
                                                    </div>
                                                    <ul class="list-group list-group-flush px-3">
                                                        @foreach ($quiz->highestScores()->take(3) as $topScore)
                                                            <li class="list-group-item d-flex w-100 justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="card-title">{{ $topScore->score }}</span> &nbsp;
                                                                    <span>
                                                                        {{ $topScore->user->name }}
                                                                    </span>
                                                                </div>
                                                                <span class="fas fa-2x
                                                                            @if($loop->first) fa-trophy
                                                                            @elseif($loop->last) fa-award pr-1
                                                                            @else fa-medal
                                                                            @endif"></span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="card-body">
                                                        @if ($quiz->scores->count() > 0)
                                                            <a href="{{ route('admin.reports.quiz', $quiz->id) }}" class="card-link btn btn-outline-primary">See all students scores</a>
                                                        @else
                                                            <h6 class="mt-n3"><span class="badge badge-danger p-3"> No Student Has Answered Yet </span></h6>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @empty
                                    <em>No quizzes added yet.</em>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
