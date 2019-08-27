
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset(isset(\App\Application::first()->logo) ? 'storage/logos/' . \App\Application::first()->logo : 'defaults/logo.png') }}">

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> --}}
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')

</head>
<body class="hold-transition sidebar-mini layout-fixed">

    @include('partials.flash-messages')

    <div class="wrapper">

        <!-- Navbar -->
        @include('partials.admin.navbar')

        <!-- Main Sidebar Container -->
        @include('partials.admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')

        <!-- Footer -->
        @include('partials.admin.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>

    </div>
    <!-- ./wrapper -->

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}" defer></script>
    @yield('scripts')
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

</body>
</html>
