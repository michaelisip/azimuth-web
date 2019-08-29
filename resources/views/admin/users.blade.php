@extends('layouts.dashboard')


@section('content')

    <div class="content-wrapper">

        {{-- Header --}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="card shadow-none border-0">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-12 col-sm-8 col-lg-10">
                                <h1 class="d-inline align-middle mr-3"> <strong> Students </strong> </h1>
                                <button class="btn btn-primary btn-sm align-middle px-4" data-toggle="modal" data-target="#addUser"> Add Student </button>
                                <div class="btn-group" role="group" aria-label="...">
                                    <button class="btn btn-secondary btn-sm align-middle px-4" data-toggle="modal" data-target="#importUsers">Import Students </button>
                                    <a href="{{ route('admin.export.users') }}" class="btn btn-outline-secondary btn-sm align-middle px-4"> Export Students </a>
                                </div>
                            </div>
                            <div class="col col-sm-4 col-lg-2 d-none d-sm-block">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                                <table class="table table-striped table-hover usersTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Mobile Number</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email Address</th>
                                            <th>Mobile Number</th>
                                            <th>Address</th>
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

    {{-- Modals --}}

    {{-- Add --}}
    <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserLabel"><strong> Add Student </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Name" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}" autocomplete="mobile" placeholder="Mobile">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" autocomplete="password" placeholder="Password" required>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" autocomplete="password_confirmation" placeholder="Confirm Password" required>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="1234 Main St">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

    {{-- Import --}}
    <div class="modal fade" id="importUsers" tabindex="-1" role="dialog" aria-labelledby="importUsersLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importUsersLabel"><strong> Import Students </strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data">
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
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bolder" id="editUserLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" id="editUserForm">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="editName" name="name" autocomplete="name" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="editEmail" name="email" autocomplete="email" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input type="number" class="form-control @error('mobile') is-invalid @enderror" id="editMobile" name="mobile" autocomplete="mobile">
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="editAddress" name="address">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

    {{-- Delete --}}
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title font-weight-bolder" id="deleteUserLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="deleteUserForm">
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

        var editUserUrl = '{{ route('admin.users.edit', ":id") }}'
        var updateUserUrl = '{{ route('admin.users.update', ":id") }}'
        var deleteUserUrl = '{{ route('admin.users.destroy', ":id") }}'

        $(document).ready(function() {
            $('.usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.users.index') }}',
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'mobile', "defaultContent": "<i>Not set</i>"},
                    {data: 'address', "defaultContent": "<i>Not set</i>"},
                    {data: 'action'},
                ]
            })

            $("#editUserModal").on("show.bs.modal", function(e) {
                var user_id = $(e.relatedTarget).data('id')
                $.ajax({
                    type: 'GET',
                    url: editUserUrl.replace(":id", user_id),
                    success: function(data){
                        console.log(data)
                        populateEditUserModal(data.result)
                    }
                })
            })

            $("#deleteUserModal").on("show.bs.modal", function(e) {
                var user_id = $(e.relatedTarget).data('id')
                $.ajax({
                    type: 'GET',
                    url: editUserUrl.replace(":id", user_id),
                    success: function(data){
                        console.log(data)
                        populateDeleteUserModal(data.result)
                    }
                })
            })

        })

        function populateEditUserModal(data) {
            $("#editUserLabel").text("Edit " + data.name + "'s Information")
            $("#editUserForm").attr("action", updateUserUrl.replace(":id", data.id))
            $("#editName").val(data.name)
            $("#editEmail").val(data.email)
            $("#editMobile").val(data.mobile)
            $("#editAddress").val(data.address)
        }

        function populateDeleteUserModal(data) {
            $("#deleteUserLabel").text("Are you sure you want to delete " + data.name + "?")
            $("#deleteUserForm").attr("action", deleteUserUrl.replace(":id", data.id))
        }

    </script>
@endsection
