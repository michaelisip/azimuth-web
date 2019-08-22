@extends('layouts.dashboard')

@section('content')

    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-7 col-lg-8">
                                <h1 class="d-inline align-middle mr-3"> <strong> Activity Logs </strong> </h1>
                            </div>
                            <div class="col-5 col-lg-4 d-none d-sm-block">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item active"> Acivity Logs </li>
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
                                <table id="table" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $key => $log)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $log->name }}</td>
                                                <td>{{ ucfirst($log->action) }}</td>
                                                <td>{{ $log->created_at->diffForHumans() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Action</th>
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
