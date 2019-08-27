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
                                <h1 class="d-inline align-middle mr-3"> <strong> {{ $user->name }}'s Scores </strong></h1>
                            </div>
                            <div class="col-4 col-lg-2 d-none d-sm-block">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}"></a> Reports </li>
                                    <li class="breadcrumb-item active"> Student </li>
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
                    <div class="col-12 col-md-3">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div class="d-flex w-100 justify-content-between">
                                    <h3 class="m-0"><strong> Quizzes </strong></h3>
                                    <div class="button-group">
                                        {{-- <button type="button" class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteQuiz"><i class="fas fa-trash"></i></button> --}}
                                    </div>
                                </div>
                                <hr>
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($quizzes as $quiz)
                                        <a class="nav-link @if($loop->first) active @endif" id="v-pills-{{ $quiz->id }}-tab" data-toggle="pill" href="#v-pills-{{ $quiz->id }}" role="tab" aria-controls="v-pills-{{ $quiz->id }}" aria-selected="@if($loop->first) true @else false @endif">
                                            {{ $quiz->title }}
                                        </a>
                                    @endforeach

                                </div>
                                <div class="d-flex justify-content-center w-100 mt-4">
                                    {{ $quizzes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Questions --}}
                    <div class="col-12 col-md-9">
                        <div class="card shadow-none border-0 p-2">
                            <div class="card-body">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach ($quizzes as $quiz)
                                        <div class="tab-pane fade @if($loop->first) show active @else @endif" id="v-pills-{{ $quiz->id }}" role="tabpanel" aria-labelledby="v-pills-{{ $quiz->id }}-tab">
                                            <div class="quiz-info">
                                                <div>
                                                    <h3 class="d-inline align-middle mr-3">
                                                        <strong> Students' Quiz Overview </strong>
                                                    </h3>
                                                </div>
                                                <hr>
                                                <p class="text-dark">
                                                    {{ $quiz->description }}
                                                </p>
                                                <p class="text-muted">
                                                    {{ $quiz->timer }} Minutes.
                                                    {{ $quiz->questions->count() }} Questions.
                                                    {{ $quiz->points_per_question }} Points Per Question.
                                                </p>
                                            </div>
                                            <hr>

                                            @if ($user->hasStudentAnsweredQuiz($quiz->id))
                                                <div class="tries my-3">
                                                    <ul class="nav nav-pills mb-3 d-flex" id="pills-tab" role="tablist">
                                                        @foreach ($user->quizScores($quiz->id)->get() as $key => $score)
                                                            <li class="nav-item">
                                                                <a class="nav-link @if($loop->first) active @endif" id="pills-{{ $key }}-tab" data-toggle="pill" href="#pills-{{ $key }}" role="tab" aria-controls="pills-{{ $key }}" aria-selected="@if($loop->first) true @else false @endif">{{ $score->created_at->diffForHumans() }}</a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>

                                                <div class="tab-content" id="pills-tabContent">
                                                    @foreach ($user->quizScores($quiz->id)->get() as $key => $score)
                                                        <div class="tab-pane fade @if($loop->first) show active @endif" id="pills-{{ $key }}" role="tabpanel" aria-labelledby="pills-{{ $key }}-tab">
                                                            <div class="results mb-5">
                                                                <h5><strong> Result: </strong> {{ $score->score }} total score | {{ $score->score * $quiz->points_per_question }} total points</h5>
                                                            </div>
                                                            <table id="table" class="table table-striped table-hover studentScores" data-id="{{ $quiz->id }}">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Question</th>
                                                                        <th>Choice A</th>
                                                                        <th>Choice B</th>
                                                                        <th>Choice C</th>
                                                                        <th>Choice D</th>
                                                                        <th>Answer</th>
                                                                        <th>Correct Answer</th>
                                                                        <th>Answer Explanation</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($quiz->questions as $key => $question)
                                                                        <tr>
                                                                            <td>{{ ++$key }}</td>
                                                                            <td>{{ $question->question }}</td>
                                                                            <td>{{ $question->a }}</td>
                                                                            <td>{{ $question->b }}</td>
                                                                            <td>{{ $question->c }}</td>
                                                                            <td>{{ $question->d }}</td>
                                                                            <td>{{ $question->studentAnswer($user->id, $quiz->id, $score->id) }}</td>
                                                                            <td>{{ $question->answer }}</td>
                                                                            <td>{{ $question->answer_explanation ?? 'No Explanation' }}</td>
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
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Question</th>
                                                                        <th>Choice A</th>
                                                                        <th>Choice B</th>
                                                                        <th>Choice C</th>
                                                                        <th>Choice D</th>
                                                                        <th>Answer</th>
                                                                        <th>Correct Answer</th>
                                                                        <th>Answer Explanation</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <h5><span class="badge badge-danger p-3"> Student Has Not Answered This Quiz yet </span class="badge badge-danger p-3"></h5>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection

@section('scripts')
    <script>
        // $(document).ready(function(){
        //     initializeDatatable($("a.nav-link.active").attr("href"))

        //     $("a.nav-link").on("click", function(){
        //         initializeDatatable($(this).attr("href"))
        //     })
        // })

        // function initializeDatatable(href){
        //     $('.table').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: '{{ route('admin.quizzes.show', $quiz->id) }}',
        //         columns: [
        //             {data: 'DT_RowIndex'},
        //             {data: 'question'},
        //             {data: 'a'},
        //             {data: 'b'},
        //             {data: 'c'},
        //             {data: 'd'},
        //             {data: 'answer'},
        //             {data: 'answer_explanation', defaultContent: "<i>Not set</i>"},
        //             {data: 'action'},
        //         ]
        //     })
        // }
    </script>
@endsection

