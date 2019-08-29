<div class="position-absolute" style="z-index: 10000; top: 15px; right: 15px;">

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block  alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-block alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('info'))
        <div class="alert alert-info alert-block alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($messages = Session::get('import-danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            @foreach ($messages as $message)
                @foreach ($message->errors() as $error)
                Error at row {{ $message->row() }}: <strong>{{ $error }}</strong> <br>
                @endforeach
            @endforeach
        </div>
    @endif

    @if ($messages = Session::get('import-warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong> Some row(s) failed the import validations! </strong>
            @foreach ($messages as $message)
                @foreach ($message->errors() as $error)
                Error at row {{ $message->row() }}: <strong>{{ $error }}</strong> <br>
                @endforeach
            @endforeach
        </div>
    @endif

</div>

