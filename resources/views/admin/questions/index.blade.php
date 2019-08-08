@extends('layouts.dashboard')

@section('content')
<div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="d-inline align-middle mr-3"> Questions </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active"> Questions </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">

                    <div class="card shadow-none border-0">
                        <div class="card-body">

                            <h1> Questions </h1>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection