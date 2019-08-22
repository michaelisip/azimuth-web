@extends('layouts.dashboard')

@section('content')
    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-md-8 col-lg-10">
                                <h1 class="d-inline align-middle mr-3"><strong> Quizzes </strong></h1>
                                <button class="btn btn-primary btn-sm align-middle px-4" data-toggle="modal" data-target="#addQuiz"> Add Quiz </button>
                                <div class="btn-group" role="group" aria-label="...">
                                    <button class="btn btn-secondary btn-sm align-middle px-4" data-toggle="modal" data-target="#importQuizzes">Import Quizzes </button>
                                    <a href="{{ route('admin.export.quizzes') }}" class="btn btn-outline-secondary btn-sm align-middle px-4"> Export Quizzes </a>
                                </div>
                            </div>
                            <div class="col col-md-4 col-lg-2 d-none d-lg-block">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active"> Quizzes </li>
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

                                {{-- Quizzes cards --}}
                                <div class="row justify-content-center">
                                    @forelse ($quizzes as $key => $quiz)
                                        <div class="col-12 col-lg-3 col-xl-4">
                                            <div class="card border-0 rounded-lg shadow">
                                                <div class="card-body">
                                                    <h6 class="card-subtitle mb-2 text-muted">{{ $quiz->timer }} minutes</h6>
                                                    <h5 class="card-title">{{ str_limit($quiz->title, 40) }}</h5>
                                                    <p class="card-text">
                                                        @if (is_null($quiz->description))
                                                            <em> No Description </em>
                                                        @else
                                                            {{ str_limit($quiz->description, 180) }}</p>
                                                        @endif
                                                    <div class="card-link">
                                                        <a href="{{ route('admin.quizzes.show', $quiz->id) }}" class="btn btn-primary btn-sm px-4"> See Details &nbsp; <i class="fas fa-arrow-right"></i> </a>
                                                        {{-- <a href="" class="btn btn-outline-secondary btn-sm px-4"> Practice Mode </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <em> No quizzes addded yet. </em>
                                    @endforelse
                                </div>

                                <div class="d-flex justify-content-center mt-3">
                                    {{ $quizzes->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- Modals --}}

    {{-- Add --}}
    <div class="modal fade" id="addQuiz" tabindex="-1" role="dialog" aria-labelledby="addQuizLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuizLabel"><strong> Add Quiz </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.quizzes.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" autocomplete="title" placeholder="Title" required autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" autocomplete="description" placeholder="Description" rows="5" style="resize: none;"></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="points_per_question">Points For Each Question</label>
                                <input type="number" class="form-control @error('points_per_question') is-invalid @enderror" id="points_per_question" name="points_per_question" value="{{ old('points_per_question') }}" autocomplete="points_per_question" placeholder="Points Per Question" min="1" required>
                                @error('points_per_question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="timer">Total Time in Minutes</label>
                                <input type="number" class="form-control @error('timer') is-invalid @enderror" id="timer" name="timer" value="{{ old('timer') }}" autocomplete="timer" placeholder="Total Time in Minutes" min="1" required>
                                @error('timer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-5 py-1">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Import --}}
    <div class="modal fade" id="importQuizzes" tabindex="-1" role="dialog" aria-labelledby="importQuizzesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importQuizzesLabel"><strong> Import Quizzes </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.quizzes.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="file">File</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="file">Choose file</label>
                                <input type="file" class="custom-file-input" id="file" name="file" required>
                            </div>
                        </div>
                        <p class="muted"> Please read the <a href="https://docs.google.com/document/d/17KJto5C3zyu8wYy_qepSweH41KXBC3PxfUvc8N-j-Vc/edit?usp=sharing" target="__blank">import guides.</a> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-5 py-1">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
