@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row shadow-none border-0">

            <div class="col-12">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="countdown text-center mt-4 d-block d-md-none">
                    <h1 class="font-weight-bolder clock" id="clock"></h1>
                </div>

            </div>

            {{-- Quizzes --}}
            <div class="col-12 col-lg-8">
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
                                                <input type="radio" value="a" id="a-{{$key}}" name="student_answer" class="custom-control-input" required>
                                                <label class="custom-control-label font-weight-bold" for="a-{{$key}}">{{ $question->a }}</label>
                                            </div>
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="b" id="b-{{$key+1}}" name="student_answer" class="custom-control-input" required>
                                                <label class="custom-control-label font-weight-bold" for="b-{{$key+1}}">{{ $question->b }}</label>
                                            </div>
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="c" id="c-{{$key+2}}" name="student_answer" class="custom-control-input" required>
                                                <label class="custom-control-label font-weight-bold" for="c-{{$key+2}}">{{ $question->c }}</label>
                                            </div>
                                            <div class="custom-control custom-radio my-3">
                                                <input type="radio" value="d" id="d-{{$key+3}}" name="student_answer" class="custom-control-input" required>
                                                <label class="custom-control-label font-weight-bold" for="d-{{$key+3}}">{{ $question->d }}</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary px-5"> Submit </button>
                                        <p class="text-right text-danger font-italic mt-4 mb-0 p-0">
                                            * Please do not refresh. Otherwise your current score will be marked as your final score.
                                        </p>
                                    </form>
                                @endforeach
                            </div>
                            <div class="times-up text-center my-5 d-none">
                                <h1 class="font-weight-bold mb-3"> Time is up! </h1>
                                <p>That's okay! Study harder next time.</p>
                                <a href="{{ route('score', $quiz->id) }}" class="btn btn-primary px-4"> See Result &nbsp; <i class="fas fa-arrow-right"></i> </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4"> Go Home </a>
                            </div>
                            <div class="finished text-center my-5 d-none">
                                <h1 class="font-weight-bold mb-3"> Finished! </h1>
                                <p>Wow! You really must have been studying hard.</p>
                                <a href="{{ route('score', $quiz->id) }}" class="btn btn-primary px-4"> See Result &nbsp; <i class="fas fa-arrow-right"></i> </a>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4"> Go Home </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Timer --}}
            <div class="col-12 col-lg-4 d-none d-md-block">
                <div id="reports" class="mt-4">
                    <div class="card rounded-lg shadow-none border-0 p-3">
                        <div class="card-body">
                            <h2 class="font-weight-bolder"> {{ $quiz->title }} </h2>
                            <p> {{ $quiz->description ?: 'No Description'}} </p>
                            <hr>
                            <div class="countdown text-center my-5">
                                <h1 class="font-weight-bolder clock" id="clock"></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('scripts')

    {{-- countdown timer installed via npm doesnt work for some reason --}}
    <script src="https://cdn.rawgit.com/hilios/jQuery.countdown/2.2.0/dist/jquery.countdown.min.js" type="application/javascript"></script>

    <script>

        $(document).ready(function(){

            // disable refresh and right click
            pageConfiguration()

            $("#questions").children().first().addClass("active")
            $("#questions").children().first().removeClass("d-none")

            startTimer()

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
                    url: '/quiz/question/check',
                    data: {
                        quiz_id: quiz_id,
                        question_id: question_id,
                        student_answer: student_answer
                    }
                })

                nextQuestion()

            })
        })

        function startTimer() {

            // 10000 = 10 seconds

            var time = ({{ $quiz->timer }} * 1000) * 60
            var format = '%H Hours %M Mins %S Secs';

            $('.clock').countdown(new Date().valueOf() + time)

                .on('update.countdown', function(event) {

                    if (checkIfStudentIsFinished()) {
                        $(".clock").countdown("stop")
                    }

                    if(event.offset.totalHours == 0)
                        format = '%M Mins %S Secs';

                    if(event.offset.totalMinutes == 0)
                        format = '%S Seconds';

                    $(this).html(event.strftime(format));
                })

                .on('finish.countdown', function(event) {

                    $(".countdown").addClass("d-none")
                    $(".active").addClass("d-none")
                    $(".times-up").removeClass("d-none")
                    .parent().addClass('disabled');

            });
        }

        function nextQuestion() {

            var activeQuestion = $(".active")
            activeQuestion.removeClass("active")
            activeQuestion.addClass("d-none")

            // update progress bar
            var questions = $("#questions").children(".myForm").length
            var activeIndex = activeQuestion.next().index() == -1 ? questions : activeQuestion.next().index()
            $(".progress-bar").css("width", activeIndex/questions * 100 + "%")

            if(activeQuestion.next().length > 0){

                // show next question
                activeQuestion.next().removeClass("d-none")
                activeQuestion.next().addClass("active")

                // reset form
                $(".myForm").trigger("reset")
            } else {
                $(".finished").removeClass("d-none")
            }

        }

        function checkIfStudentIsFinished()
        {
            if ($(".finished").is(":visible")) {
                return true
            }

            return false
        }

        function pageConfiguration() {

            // disable right click
            document.addEventListener('contextmenu', event => event.preventDefault())

            // disable refresh
            $(document).on("keydown", disableF5)
            function disableF5(e) {
                if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82)
                e.preventDefault()
            }
            window.onbeforeunload = function(e) {
                e.preventDefault()
            }

        }

    </script>
@endsection
