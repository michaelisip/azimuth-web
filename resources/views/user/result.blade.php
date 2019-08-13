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
                        <p class="text-muted"> {{ Auth::user()->quizScore($quiz->id) }} score </p>
                    </div>
                </div>
            </div>

            {{-- Questions --}}
            <div class="col-12 col-lg-9">
                <div class="card rounded-lg shadow-none border-0 p-3 position-relative">
                    <div class="card-body">
                        <h1><strong>Questions</strong></h1>
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
                                    <th>Correct Answer</th>
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
                                        <td>{{ $question->studentAnswer($quiz->id) }}</td>
                                        <td>{{ $question->answer }}</td>
                                        <td>{{ $question->answer_explanation ?? 'No Explanation' }}</td>
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
                                    <th>Correct Answer</th>
                                    <th>Answer Explanation</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
