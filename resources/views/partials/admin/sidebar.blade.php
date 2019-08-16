<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        <h1 class="brand-text font-weight-bold">{{ \App\Application::first()->name }}</h1>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" class="img-circle elevation-2" alt="Admin Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="/admin" class="nav-link @if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>

                {{-- Students --}}
                <li class="nav-header">STUDENTS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link @if(Route::currentRouteName() == 'admin.users.index') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            All Students
                            {{-- <span class="badge badge-info right">2</span> --}}
                        </p>
                    </a>
                </li>

                {{-- Students --}}
                <li class="nav-header">EXAMS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.quizzes.index') }}" class="nav-link
                            @if(Route::currentRouteName() == 'admin.quizzes.index'
                                || Route::currentRouteName() == 'admin.quizzes.show') active @endif">
                        <i class="nav-icon fas fa-book"></i>
                        <p> All Quizzes </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.questions.index', 'all') }}" class="nav-link @if(Route::currentRouteName() == 'admin.questions.index') active @endif">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p> All Questions </p>
                    </a>
                </li>

                {{-- Reports --}}
                <li class="nav-header">REPORTS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link
                            @if(Route::currentRouteName() == 'admin.reports.index'
                                || Route::currentRouteName() == 'admin.reports.student-scores') active @endif">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p> Student Reports </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.top-students') }}" class="nav-link
                            @if(Route::currentRouteName() == 'admin.reports.top-students'
                                || Route::currentRouteName() == 'admin.reports.quiz') active @endif">
                        <i class="nav-icon fas fa-award"></i>
                        <p> Top Students </p>
                    </a>
                </li>
                <li class="nav-header">SETTINGS</li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link @if(Route::currentRouteName() == 'admin.settings') active @endif">
                        <i class="nav-icon fas fa-cog"></i>
                        <p> Settings </p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</aside>
