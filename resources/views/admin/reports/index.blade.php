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
                                <h1 class="d-inline align-middle mr-3"> <strong> Students </strong> </h1>
                            </div>
                            <div class="col-4 col-lg-2">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"> Reports </li>
                                    <li class="breadcrumb-item active"> Students </li>
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
                                <table id="table" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Quizzes Answered</th>
                                            <th>Last Quiz Taken</th>
                                            <th>Highest Quiz Score</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $user->name }}</td>

                                                {{-- Refactory these lines --}}
                                                <td>{{ $user->scores->count() > 0 ? $user->scores->count() : 'None'}}</td>
                                                <td>{{ isset($user->latestQuiz()->created_at) ? $user->latestQuiz()->created_at->diffForHumans() : "Hasn't Answered Any Quiz" }}</td>
                                                <td>{{ $user->highestQuizScore()->score ?? "Hasn't Answered Any Quiz" }}</td>

                                                <td>
                                                    @if(!$user->scores->isEmpty())
                                                        <a href="{{ route('admin.reports.student-scores', $user->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye"></i> &nbsp; View Reports
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Quizzes Answered</th>
                                            <th>Last Quiz Taken</th>
                                            <th>Highest Quiz Score</th>
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

@endsection
