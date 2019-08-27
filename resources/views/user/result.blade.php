@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row shadow-none border-0">


            {{-- Result --}}
            <div class="col-12 col-lg-3">
                <a href="{{ route('home') }}" class="btn btn-block btn-outline-primary mb-4"> Go Home </a>
                <div class="card rounded-lg shadow-none border-0 p-3 position-relative">
                    <div class="card-body">
                        <h5 class="card-title font-weight-bold">{{ $quiz->title }}</h5>
                        <p class="card-text">{{ $quiz->description }}</p>
                        <p class="text-muted"> {{ $quiz->points_per_question }} points per question </p>
                        <p class="text-muted"> {{ $quiz->timer }} minutes</p>
                        <p class="text-muted"> {{ $quiz->questions->count() }} total questions</p>
                    </div>
                </div>
            </div>

            {{-- Questions --}}
            <div class="col-12 col-lg-9">
                <div class="card rounded-lg shadow-none border-0 p-3 position-relative">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="tries">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    @foreach (Auth::user()->quizScores($quiz->id)->get() as $key => $score)
                                        <li class="nav-item">
                                            <a class="nav-link @if($loop->first) active @endif" id="pills-{{ $key }}-tab" data-toggle="pill" href="#pills-{{ $key }}" role="tab" aria-controls="pills-{{ $key }}" aria-selected="@if($loop->first) true @else false @endif">{{ $score->created_at->diffForHumans() }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                @foreach (Auth::user()->quizScores($quiz->id)->get() as $key => $score)
                                    <div class="tab-pane fade @if($loop->first) show active @endif" id="pills-{{ $key }}" role="tabpanel" aria-labelledby="pills-{{ $key }}-tab">
                                        <div class="results mb-5">
                                            <h5><strong> Result: </strong> {{ $score->score }} total score | {{ $score->score * $quiz->points_per_question }} total points</h5>
                                        </div>
                                        <table id="table" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Question</th>
                                                    <th>Choice A</th>
                                                    <th>Choice B</th>
                                                    <th>Choice C</th>
                                                    <th>Choice D</th>
                                                    <th>Answer</th>
                                                    <th>Answer Explanation</th>
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
                                                        <td>{{ $question->studentAnswer(Auth::id(), $quiz->id, $score->id) }}</td>
                                                        <td>{{ $question->answer }}</td>
                                                        <td>{{ $question->answer_explanation ?? 'No Explanation' }}</td>
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
                                                    <th>Answer Explanation</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
