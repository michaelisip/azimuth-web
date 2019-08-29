@extends('layouts.dashboard')

@section('content')

    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-sm-8 col-lg-9">
                                <h1 class="d-inline align-middle mr-3"><strong>{{ $quiz->title }}</strong></h1>
                            </div>
                            <div class="col col-sm-4 col-lg-3 d-none d-sm-block">
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
                    <div class="col-12 col-xl-4">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between">
                                    <h3 class="m-0"><strong> Information </strong></h3>
                                    <div class="button-group">
                                        <button type="button" class="btn btn-outline-secondary btn-sm d-none" id="cancelEditQuiz"><i class="fas fa-ban"></i></button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" id="editQuiz"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteQuiz"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <form method="POST" accept="{{ route('admin.quizzes.update', $quiz->id) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group row">
                                        <label for="title" class="col-12 col-form-label">Title</label>
                                        <div class="col-12">
                                        <input type="text" readonly class="form-control-plaintext" name="title" id="title" value="{{ $quiz->title }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="description" class="col-12 col-form-label">Description</label>
                                        <div class="col-12">
                                        <textarea readonly class="form-control-plaintext" name="description" id="description" rows="4">{{$quiz->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="points_per_question" class="col-12 col-form-label">Points Per Question</label>
                                        <div class="col-12">
                                        <input type="text" readonly class="form-control-plaintext" name="points_per_question" id="points_per_question" value="{{ $quiz->points_per_question }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="timer" class="col-12 col-form-label">Timer</label>
                                        <div class="col-12">
                                        <input type="text" readonly class="form-control-plaintext" name="timer" id="timer" value="{{ $quiz->timer }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="questions" class="col-12 col-form-label">Total Questions</label>
                                        <div class="col-12">
                                            <input type="text" readonly class="form-control-plaintext" id="questions" value="{{ $quiz->questions->count() }}" disabled>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm float-right px-5 d-none" id="submitEditQuiz">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>


                    {{-- Questions --}}
                    <div class="col-12 col-xl-8">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div>
                                    <h3 class="d-inline align-middle mr-3"> <strong> Questions </strong> </h3>
                                    <button class="btn btn-primary btn-sm align-middle px-4" data-toggle="modal" data-target="#addQuestion"> Add Questions </button>
                                    <div class="btn-group" role="group" aria-label="...">
                                        <button class="btn btn-secondary btn-sm align-middle px-4" data-toggle="modal" data-target="#importQuestions">Import Questions </button>
                                        <a href="{{ route('admin.export.questions', $quiz->id) }}" class="btn btn-outline-secondary btn-sm align-middle px-4"> Export Questions </a>
                                    </div>
                                </div>
                                <hr>
                                <div class="table-responsive">
                                    <table id="table" class="table table-striped table-hover quizQuestionsTable">
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
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
                                                <th>Action</th>
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
                        <p class="muted"> Please read the <a href="{{ asset('docs/Azimuth - Import Guides.pdf') }}" target="__blank">import guides.</a> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary px-5 py-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-5 py-1">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit --}}
    <div class="modal fade" id="editQuestionModal" tabindex="-1" role="dialog" aria-labelledby="editQuestionLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuestionLabel"><strong> Edit Question </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="editQuestionForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="question">Question</label>
                            <input type="text" class="form-control @error('question') is-invalid @enderror" id="editQuestion" name="question" placeholder="Question" autocomplete="question" required autofocus>
                            @error('question')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="a">Choice A</label>
                                <input type="text" class="form-control @error('a') is-invalid @enderror" id="editA" name="a" autocomplete="a" placeholder="Choice A" required>
                                @error('a')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="b">Choice B</label>
                                <input type="text" class="form-control @error('b') is-invalid @enderror" id="editB" name="b" autocomplete="b" placeholder="Choice B" required>
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
                                <input type="text" class="form-control @error('c') is-invalid @enderror" id="editC" name="c" autocomplete="c" placeholder="Choice C" required>
                                @error('c')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="d">Choice D</label>
                                <input type="text" class="form-control @error('d') is-invalid @enderror" id="editD" name="d" autocomplete="d" placeholder="Choice D" required>
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
                                <select class="custom-select mr-sm-2" name="answer" id="editAnswer" required>
                                    <option value="a">Choice A</option>
                                    <option value="b">Choice B</option>
                                    <option value="c">Choice C</option>
                                    <option value="d">Choice D</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="answer_explanation">Answer Explanation</label>
                                <textarea class="form-control @error('answer_explanation') is-invalid @enderror" id="edit_answer_explanation" name="answer_explanation" autocomplete="answer_explanation" placeholder="Answer Explanation" rows="5" style="resize: none;"></textarea>
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
    <div class="modal fade" id="deleteQuestionModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuestionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteQuestionLabel"><strong> Are you sure you want to delete this question? </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteQuestionForm">
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

@section('scripts')
    <script>

        var editQuestionUrl = '{{ route('admin.questions.edit', [$quiz->id, ":id"]) }}'
        var updateQuestionUrl = '{{ route('admin.questions.update', [$quiz->id, ":id"]) }}'
        var deleteQuestionUrl = '{{ route('admin.questions.destroy', [$quiz->id, ":id"]) }}'

        $(document).ready(function() {
            $('.quizQuestionsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.quizzes.show', $quiz->id) }}',
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'question'},
                    {data: 'a'},
                    {data: 'b'},
                    {data: 'c'},
                    {data: 'd'},
                    {data: 'answer'},
                    {data: 'answer_explanation', defaultContent: "<i>Not set</i>"},
                    {data: 'action'},
                ]
            })

            $("#editQuiz").on("click", function(){
                $("#cancelEditQuiz").removeClass("d-none")
                $("#submitEditQuiz").removeClass("d-none")
                $("#title").removeAttr("readonly")
                $("#title").focus()
                $("#description").removeAttr("readonly")
                $("#points_per_question").removeAttr("readonly")
                $("#timer").removeAttr("readonly")
            })

            $("#cancelEditQuiz").on("click", function(){
                $("#cancelEditQuiz").addClass("d-none")
                $("#submitEditQuiz").addClass("d-none")
                $("#title").prop("readonly", true)
                $("#description").prop("readonly", true)
                $("#points_per_question").prop("readonly", true)
                $("#timer").prop("readonly", true)
            })
        })

        $("#editQuestionModal").on("show.bs.modal", function(e) {
            var question_id = $(e.relatedTarget).data('id')

            $.ajax({
                type: 'GET',
                url: editQuestionUrl.replace(":id", question_id),
                success: function(data){
                    populateEditQuestionModal(data.result)
                }
            })
        })

        $("#deleteQuestionModal").on("show.bs.modal", function(e) {
            var question_id = $(e.relatedTarget).data('id')

            $.ajax({
                type: 'GET',
                url: editQuestionUrl.replace(":id", question_id),
                success: function(data){
                    populateDeleteQuestionModal(data.result)
                }
            })
        })

        function populateEditQuestionModal(data) {
            $("#editQuestionForm").attr("action", updateQuestionUrl.replace(":id", data.id))
            $("#editQuestion").val(data.question)
            $("#editA").val(data.a)
            $("#editB").val(data.b)
            $("#editC").val(data.c)
            $("#editD").val(data.d)
            $("#editAnswer").val(data.answer)
            $("#edit_answer_explanation").val(data.answer_explanation)
        }

        function populateDeleteQuestionModal(data) {
            $("#deleteQuestionForm").attr("action", deleteQuestionUrl.replace(":id", data.id))
        }

    </script>
@endsection
