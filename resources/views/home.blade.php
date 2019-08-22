@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row shadow-none border-0">

        {{-- Quizzes --}}
        <div class="col-12 col-xl-9">
            <div id="quizzes" class="mt-4">
                <div class="card rounded-lg shadow-none border-0 p-3">
                    <div class="card-body">
                        <h1 class="font-weight-bolder"> Quizzes </h1>
                        <hr>
                        <div class="row justify-content-center">
                            @forelse ($quizzes as $quiz)
                                <div class="col-12 col-md-6">
                                    <div class="card rounded bg-white border-0 shadow p-2">
                                        <div class="card-body">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h4 class="font-weight-bold"> {{ $quiz->title }} </h4>
                                                <p class="d-none d-sm-block">
                                                    <span class="badge badge-secondary badge-pill px-3 py-1 ml-1">{{ $quiz->questions->count() }} Questions </span>
                                                </p>
                                            </div>
                                            <p class="card-text"> {{ $quiz->description ?? 'No Description' }}</p>
                                            @if (Auth::user()->hasStudentAnsweredQuiz($quiz->id))
                                                <a href="{{ route('score', $quiz->id) }}" class="btn btn-sm btn-success px-4 my-1"> See Result &nbsp; <i class="fas fa-arrow-right"></i></a>
                                            @else
                                                <a href="{{ route('quiz', $quiz->id) }}" class="btn btn-sm btn-primary px-4 my-1">Take Quiz &nbsp; <i class="fas fa-arrow-right"></i></a>
                                            @endif
                                                <a href="{{ route('practice-mode', $quiz->id) }}" class="btn btn-sm btn-outline-secondary px-4 my-1">Practice Mode </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <em class="p-5"> No quizzes available yet. </em>
                            @endforelse
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $quizzes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- reports --}}
        <div class="col-12 col-xl-3 d-none d-xl-block">
            <div id="reports" class="mt-4">
                <div class="card rounded-0 shadow border border-bottom-0 border-left-0 border-right-0 border-primary p-3" style="border-width: 10px !important">
                    <div class="card-body">
                        <img src="{{ asset(isset(\App\Application::first()->logo) ? 'storage/logos/' . \App\Application::first()->logo : 'defaults/logo.png') }}" class="img-fluid w-100" alt="Responsive image">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
