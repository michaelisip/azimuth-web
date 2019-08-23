@extends('layouts.dashboard')

@section('content')

    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-sm-8">
                                <h1 class="d-inline align-middle mr-3"> <strong> Quiz Scores </strong> </h1>
                            </div>
                            <div class="col col-sm-4 d-none d-sm-block">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}"></a> Reports </li>
                                    <li class="breadcrumb-item active"> Quiz </li>
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

                    {{-- Information --}}
                    <div class="col-12 col-xl-4">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between">
                                    <h3 class="m-0"><strong> Information </strong></h3>
                                    <div class="button-group">
                                        <button type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteQuiz"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <form>
                                    <div class="form-group row">
                                        <label for="title" class="col-12 col-form-label">Title</label>
                                        <div class="col-12">
                                        <input type="text" readonly class="form-control-plaintext" id="title" value="{{ $quiz->title }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description" class="col-12 col-form-label">Description</label>
                                        <div class="col-12">
                                        <textarea readonly class="form-control-plaintext" id="description" rows="4">{{$quiz->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="points_per_question" class="col-12 col-form-label">Points Per Question</label>
                                        <div class="col-12">
                                        <input type="text" readonly class="form-control-plaintext" id="points_per_question" value="{{ $quiz->points_per_question }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="timer" class="col-12 col-form-label">Timer</label>
                                        <div class="col-12">
                                        <input type="text" readonly class="form-control-plaintext" id="timer" value="{{ $quiz->timer }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="questions" class="col-12 col-form-label">Total Questions</label>
                                        <div class="col-12">
                                        <input type="number" readonly class="form-control-plaintext" id="questions" value="{{ $quiz->questions->count() }}" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Questions --}}
                    <div class="col-12 col-xl-8">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div>
                                    <h3 class="d-inline align-middle mr-3"> <strong> Students' Scores </strong> </h3>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Correct Answers</th>
                                                <th>Total Points</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($quiz->scores as $key => $score)
                                                <tr>
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $score->user->name }}</td>
                                                    <td>{{ $score->score }}</td>
                                                    <td>{{ $score->score * $quiz->points_per_question}}</td>
                                                    <td>{{ $score->created_at->diffForHumans() }}</td>
                                                </tr>
                                            @endforeach
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Correct Answers</th>
                                                <th>Total Points</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- Delete Quiz --}}
    <div class="modal fade" id="deleteQuiz" tabindex="-1" role="dialog" aria-labelledby="deleteQuizLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteQuizLabel"><strong> Are you sure you want to delete this question? </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <em> Please be informed that deleting this quiz will also delete the questions associated with it.</em>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger px-5 py-1">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
