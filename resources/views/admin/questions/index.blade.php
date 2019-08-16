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
                                <h1 class="d-inline align-middle mr-3"> <strong> Questions </strong> </h1>
                                <button class="btn btn-primary btn-sm align-middle px-4" data-toggle="modal" data-target="#addQuestion"> Add Question </button>
                                <button class="btn btn-outline-secondary btn-sm align-middle px-4" data-toggle="modal" data-target="#importQuestions">Import Questions </button>
                            </div>
                            <div class="col-4 col-lg-2">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                    <div class="col-12">

                        <div class="card shadow-none border-0">
                            <div class="card-body">
                                <table id="table" class="table table-responsive table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Question</th>
                                            <th>Quiz</th>
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
                                        @foreach ($questions as $key => $question)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td class="w-25">{{ $question->question }}</td>
                                                <td>{{ $question->quiz->title }}</td>
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

    {{-- Modals --}}

    {{-- Add --}}
    <div class="modal fade" id="addQuestion" tabindex="-1" role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuestionLabel"><strong> Add Question </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="addQuestionForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="quiz_id">Quiz</label>
                            <select class="custom-select mr-sm-2" name="quiz_id" id="quiz_id" required>
                                <option value="" selected disabled hidden>Choose...</option>
                                @foreach ($quizzes as $quiz)
                                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                                @endforeach
                            </select>
                        </div>
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
                        <button type="submit" class="btn btn-primary px-5 py-1" id="addQuestionSubmit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Import --}}
    <div class="modal fade" id="importQuestions" tabindex="-1" role="dialog" aria-labelledby="importQuestionsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importQuestionsLabel"><strong> Import Students </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.questions.import', $quiz->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="quiz_id">Quiz</label>
                            <select class="custom-select mr-sm-2" name="quiz_id" id="quiz_id" required>
                                <option value="" selected disabled hidden>Choose...</option>
                                @foreach ($quizzes as $selectQuiz)
                                    <option value="{{ $selectQuiz->id }}">{{ $selectQuiz->title }}</option>
                                @endforeach
                            </select>
                        </div>
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


    @foreach ($questions as $question)

        {{-- Edit --}}
        <div class="modal fade" id="edit-{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="editQuestionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editQuestionLabel"><strong> Edit Question </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('admin.questions.update', [$question->quiz->id, $question->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="quiz_id">Quiz</label>
                                <select class="custom-select mr-sm-2" name="quiz_id" id="quiz_id" required>
                                    <option value="" selected disabled hidden>Choose...</option>
                                    @foreach ($quizzes as $quiz)
                                        <option value="{{ $quiz->id }}" @if($question->quiz->id === $quiz->id) selected @endif>{{ $quiz->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" class="form-control @error('question') is-invalid @enderror" id="question" name="question" value="{{ $question->question }}" placeholder="Question" autocomplete="question" required autofocus>
                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="a">Choice A</label>
                                    <input type="text" class="form-control @error('a') is-invalid @enderror" id="a" name="a" value="{{ $question->a }}" autocomplete="a" placeholder="Choice A" required>
                                    @error('a')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="b">Choice B</label>
                                    <input type="text" class="form-control @error('b') is-invalid @enderror" id="b" name="b" value="{{ $question->b }}" autocomplete="b" placeholder="Choice B" required>
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
                                    <input type="text" class="form-control @error('c') is-invalid @enderror" id="c" name="c" value="{{ $question->c }}" autocomplete="c" placeholder="Choice C" required>
                                    @error('c')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="d">Choice D</label>
                                    <input type="text" class="form-control @error('d') is-invalid @enderror" id="d" name="d" value="{{ $question->d }}" autocomplete="d" placeholder="Choice D" required>
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
                                        <option value="a" @if ($question->answer == 'a') selected @endif>Choice A</option>
                                        <option value="b" @if ($question->answer == 'b') selected @endif>Choice B</option>
                                        <option value="c" @if ($question->answer == 'c') selected @endif>Choice C</option>
                                        <option value="d" @if ($question->answer == 'd') selected @endif>Choice D</option>
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
        <div class="modal fade" id="delete-{{ $question->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="deleteQuestionLabel"><strong> Are you sure you want to delete this question? </strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('admin.questions.destroy', [$question->quiz->id, $question->id]) }}" method="POST" id="delete-{{ $question->id }}">
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
