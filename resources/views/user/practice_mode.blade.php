@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row shadow-none border-0">

            {{-- Quizzes --}}
            <div class="col-12 col-lg-7">
                <div id="quizzes" class="mt-4">
                    <div class="card rounded-lg shadow-none border-0 p-3 position-relative">
                        <div class="card-body">
                            <h1 class="font-weight-bolder"> Questions </h1>
                            <hr>
                            <div id="questions">
                                @foreach ($quiz->questions->shuffle() as $key => $question)
                                    <form method="POST" class="d-none myForm">
                                        <div class="question mb-4">
                                            <h3> {{ $question->question }} </h3>
                                        </div>
                                        @csrf
                                        <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                                        <div class="choices">
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="a" id="a-{{$key}}" name="student_answer" class="custom-control-input">
                                                <label class="custom-control-label font-weight-bold" for="a-{{$key}}">{{ $question->a }}</label>
                                            </div>
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="b" id="b-{{$key+1}}" name="student_answer" class="custom-control-input">
                                                <label class="custom-control-label font-weight-bold" for="b-{{$key+1}}">{{ $question->b }}</label>
                                            </div>
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="c" id="c-{{$key+2}}" name="student_answer" class="custom-control-input">
                                                <label class="custom-control-label font-weight-bold" for="c-{{$key+2}}">{{ $question->c }}</label>
                                            </div>
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="d" id="d-{{$key+3}}" name="student_answer" class="custom-control-input">
                                                <label class="custom-control-label font-weight-bold" for="d-{{$key+3}}">{{ $question->d }}</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary px-5"> Submit </button>
                                        <div class="progress mt-5">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ ($key/$quiz->questions->count())*100 }}%"></div>
                                        </div>
                                    </form>
                                @endforeach

                                <div class="finished text-center my-5 d-none">
                                    <h1><strong> Practice Finished </strong></h1>
                                    <p>Are you ready to take the quiz?</p>
                                    <button class="btn btn-primary mx-auto"> Take Quiz </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timer --}}
            <div class="col-12 col-lg-5">
                <div id="reports" class="mt-4">
                    <div class="card rounded-lg shadow-none border-0 p-3">
                        <div class="card-body">
                            <h2 class="font-weight-bolder"> {{ $quiz->title }} </h2>
                            <p> {{ $quiz->description ?: 'No Description'}} </p>
                            <hr>
                            <h3 class="text-center"><span class="badge badge-primary px-5 py-2">Practice Mode</span></h3>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#questions").children().first().addClass("active")
            $("#questions").children().first().removeClass("d-none")


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".myForm").on('submit', function(e){

                e.preventDefault()
                var quiz_id = $(".active input[name=quiz_id]").val()
                var question_id = $(".active input[name=question_id]").val()
                var student_answer = $(".active input[name=student_answer]:checked").val()

                $.ajax({
                    type: 'POST',
                    url: '/quiz/practice-mode/question/check',
                    data: {
                        quiz_id: quiz_id,
                        question_id: question_id,
                        student_answer: student_answer
                    },
                    success: function(data){
                        console.log(data.result)
                        if (data.result == 'wrong') {
                            wrongAnswer()
                        } else {
                            nextQuestion()
                        }
                    }
                })
            })
        })

        function wrongAnswer() {
            $("input[name=student_answer]:checked").parent().addClass("shake-vertical")

            setTimeout(function(){
                $("input[name=student_answer]:checked").parent().removeClass("shake-vertical")
            }, 500)
        }

        function nextQuestion() {

            var activeQuestion = $(".active")
            activeQuestion.removeClass("active")
            activeQuestion.addClass("d-none")

            if(activeQuestion.next().length > 0){
                activeQuestion.next().removeClass("d-none")
                activeQuestion.next().addClass("active")

                $(".myForm").trigger("reset")
            } else {
                $(".finished").removeClass("d-none")
            }

        }

    </script>
@endsection