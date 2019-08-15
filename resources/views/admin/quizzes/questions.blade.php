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
                                <h1 class="d-inline align-middle mr-3"><strong>Quiz</strong>  - {{ $quiz->title }} </h1>
                            </div>
                            <div class="col-4 col-lg-2">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}"></a> Quizzes </li>
                                    <li class="breadcrumb-item active"> Questions </li>
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
                    <div class="col-12 col-md-4">
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
                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- Questions --}}
                    <div class="col-12 col-md-8">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div>
                                    <h3 class="d-inline align-middle mr-3"> <strong> Questions </strong> </h3>
                                    <button class="btn btn-primary btn-sm align-middle px-4" data-toggle="modal" data-target="#addQuestion"> Add Questions </button>
                                    <button class="btn btn-outline-secondary btn-sm align-middle px-4" data-toggle="modal" data-target="#importQuestions">Import Questions </button>
                                </div>
                                <hr>
                                <table id="table" class="table table-responsive table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Choice A</th>
                                            <th>Choice B</th>
                                            <th>Choice C</th>
                                            <th>Choice D</th>
                                            <th>Answer</th>
                                            <th>Explanation</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quiz->questions as $key => $question)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td class="w-25">{{ $question->question }}</td>
                                                <td>{{ str_limit($question->a, 8) }}</td>
                                                <td>{{ str_limit($question->b, 8) }}</td>
                                                <td>{{ str_limit($question->c, 8) }}</td>
                                                <td>{{ str_limit($question->d, 8) }}</td>
                                                <td>{{ $question->answer }}</td>
                                                <td>{{ $question->answer_explanation ? str_limit($question->answer_explanation, 50) : 'No Explanation' }}</td>
                                                <td style="min-width: 110px;">
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#view-{{$question->id}}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-{{$question->id}}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-{{$question->id}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Choice A</th>
                                            <th>Choice B</th>
                                            <th>Choice C</th>
                                            <th>Choice D</th>
                                            <th>Answer</th>
                                            <th>Explanation</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
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
                <div class="modal-header bg-danger">
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

    {{-- Add Question --}}
    <div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionLabel"><strong> Add Question </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.questions.store', $quiz->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" value="{{ old('question') }}" placeholder="Question" autocomplete="question" required autofocus>
                            @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="a">Choice A</label>
                                <input type="text" class="form-control @error('a') is-invalid @enderror" id="a" name="a" value="{{ old('a') }}" autocomplete="a" placeholder="Choice A" required>
                                @error('a')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="b">Choice B</label>
                                <input type="text" class="form-control @error('b') is-invalid @enderror" id="b" name="b" value="{{ old('b') }}" autocomplete="b" placeholder="Choice B" required>
                                @error('b')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="c">Choice C</label>
                                <input type="text" class="form-control @error('c') is-invalid @enderror" id="c" name="c" value="{{ old('c') }}" autocomplete="c" placeholder="Choice C" required>
                                @error('c')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="d">Choice D</label>
                                <input type="text" class="form-control @error('d') is-invalid @enderror" id="d" name="d" value="{{ old('d') }}" autocomplete="d" placeholder="Choice D" required>
                                @error('d')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="answer">Answer</label>
                                <select class="custom-select mr-sm-2" name="answer" id="answer" required>
                                    <option value="" selected disabled hidden>Choose...</option>
                                    <option value="a">Choice A</option>
                                    <option value="b">Choice B</option>
                                    <option value="c">Choice C</option>
                                    <option value="d">Choice D</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="answer_explanation">Answer Explanation</label>
                                <textarea class="form-control @error('answer_explanation') is-invalid @enderror" id="answer_explanation" name="answer_explanation" value="{{ old('answer_explanation') }}" autocomplete="answer_explanation" placeholder="Answer Explanation" rows="5" style="resize: none;"></textarea>
                                @error('answer_explanation')
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

    {{-- Import Question --}}
    <div class="modal fade" id="importQuestions" tabindex="-1" role="dialog" aria-labelledby="importUsersLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importUsersLabel"><strong> Import Questions </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.questions.import', $quiz->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="file">File</label>
                            <div class="custom-file">
                                <label class="custom-file-label" for="file">Choose file</label>
                                <input type="file" class="custom-file-input" id="file" name="file" required>
                            </div>
                        </div>
                        <p class="muted"> Please read the <a href="">import guides.</a> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-5 py-1">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($quiz->questions as $key => $quizQuestion)

        {{-- View --}}
        <div class="modal fade" id="view-{{ $quizQuestion->id }}" tabindex="-1" role="dialog" aria-labelledby="viewQuestionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewQuestionLabel"><strong> {{ $quizQuestion->question }} </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit --}}
        <div class="modal fade" id="edit-{{ $quizQuestion->id }}" tabindex="-1" role="dialog" aria-labelledby="editQuestionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editQuestionLabel"><strong> Edit Question </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.questions.update', [$quiz->id, $quizQuestion->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" value="{{ $quizQuestion->question }}" placeholder="Question" autocomplete="question" required autofocus>
                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="a">Choice A</label>
                                    <input type="text" class="form-control @error('a') is-invalid @enderror" id="a" name="a" value="{{ $quizQuestion->a }}" autocomplete="a" placeholder="Choice A" required>
                                    @error('a')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="b">Choice B</label>
                                    <input type="text" class="form-control @error('b') is-invalid @enderror" id="b" name="b" value="{{ $quizQuestion->b }}" autocomplete="b" placeholder="Choice B" required>
                                    @error('b')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="c">Choice C</label>
                                    <input type="text" class="form-control @error('c') is-invalid @enderror" id="c" name="c" value="{{ $quizQuestion->c }}" autocomplete="c" placeholder="Choice C" required>
                                    @error('c')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="d">Choice D</label>
                                    <input type="text" class="form-control @error('d') is-invalid @enderror" id="d" name="d" value="{{ $quizQuestion->d }}" autocomplete="d" placeholder="Choice D" required>
                                    @error('d')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="answer">Answer</label>
                                    <select class="custom-select mr-sm-2" name="answer" id="answer" required>
                                        <option value="a" @if ($quizQuestion->answer == 'a') selected @endif>Choice A</option>
                                        <option value="b" @if ($quizQuestion->answer == 'b') selected @endif>Choice B</option>
                                        <option value="c" @if ($quizQuestion->answer == 'c') selected @endif>Choice C</option>
                                        <option value="d" @if ($quizQuestion->answer == 'd') selected @endif>Choice D</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="answer_explanation">Answer Explanation</label>
                                    <textarea class="form-control @error('answer_explanation') is-invalid @enderror" id="answer_explanation" name="answer_explanation" autocomplete="answer_explanation" placeholder="Answer Explanation" rows="5" style="resize: none;">{{ $question->answer_explanation }}</textarea>
                                    @error('answer_explanation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-5 py-1" id="addQuestionSubmit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Delete --}}
        <div class="modal fade" id="delete-{{ $quizQuestion->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="deleteQuestionLabel"><strong> Are you sure you want to delete this question? </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.questions.destroy', [$quiz->id, $quizQuestion->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger px-5 py-1">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
@endsection
