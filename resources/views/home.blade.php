@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>

    <div class="row shadow-none border-0">

        {{-- Quizzes --}}
        <div class="col-12 col-lg-8">
            <div id="quizzes" class="mt-4">
                <div class="card rounded-lg shadow-none border-0 p-3">
                    <div class="card-body">
                        <h1 class="font-weight-bolder"> Quizzes </h1>
                        <hr>
                        <div class="row justify-content-center">
                            @foreach ($quizzes as $quiz)
                                <div class="col-12 col-md-6">
                                    <div class="card rounded bg-white border-0 shadow p-2">
                                        <div class="card-body">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h4 class="font-weight-bold"> {{ $quiz->title }} </h4>
                                                <p>
                                                    <span class="badge badge-secondary badge-pill px-3 py-1 ml-1">{{ $quiz->questions->count() }} Questions </span>
                                                </p>
                                            </div>
                                            <p class="card-text"> {{ $quiz->description ? str_limit($quiz->description, 100) : 'No Description' }}</p>
                                            @if (Auth::user()->hasStudentAnsweredQuiz($quiz->id))
                                                <a href="{{ route('score', $quiz->id) }}" class="btn btn-sm btn-success px-4"> See Result &nbsp; <i class="fas fa-arrow-right"></i></a>
                                            @else
                                                <a href="{{ route('quiz', $quiz->id) }}" class="btn btn-sm btn-primary px-4">Take Quiz &nbsp; <i class="fas fa-arrow-right"></i></a>
                                            @endif
                                                <a href="{{ route('practice-mode', $quiz->id) }}" class="btn btn-sm btn-outline-secondary px-4">Practice Mode </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- reports --}}
        <div class="col-12 col-lg-4">
            <div id="reports" class="mt-4">
                <div class="card rounded-lg shadow-none border-0 p-3">
                    <div class="card-body">
                        <h1 class="font-weight-bolder"> Reports </h1>
                        <hr>
                        <div class="card rounded border-0 shadow bg-gradient-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            </div>
                        </div>
                        <div class="card rounded border-0 shadow bg-gradient-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Special title treatment</h5>
                                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
