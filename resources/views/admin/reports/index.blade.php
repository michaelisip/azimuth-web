@extends('layouts.dashboard')

@section('content')

    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-sm-8 col-lg-8">
                                <h1 class="d-inline align-middle mr-3"> <strong> Students Reports </strong> </h1>
                            </div>
                            <div class="col col-sm-4 col-lg-4 d-none d-sm-block">
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
                            <div class="card-body table-responsive">
                                <table id="table" class="table table-striped table-hover studentReportsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Quizzes Taken</th>
                                            <th>Last Quiz Taken</th>
                                            <th>Highest Quiz Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Quizzes Taken</th>
                                            <th>Last Quiz Taken</th>
                                            <th>Highest Quiz Score</th>
                                            <th>Action</th>
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

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.studentReportsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.reports.index') }}',
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'quizzes_taken'},
                    {data: 'last_quiz_taken'},
                    {data: 'highest_quiz_score'},
                    {data: 'action'},
                ]
            })
        })
    </script>
@endsection
