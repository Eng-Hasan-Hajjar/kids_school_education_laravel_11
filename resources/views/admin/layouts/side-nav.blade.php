<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}"  class="brand-link elevation-2">
        
        <span class="brand-text font-weight-light "style="margin-left: 20px; " >Kids Education</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                @if(auth()->user()->profile_image)
                    <img src="{{ asset(auth()->user()->profile_image) }}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{ asset('dist/img/default-user.png') }}" class="img-circle elevation-2" alt="Default Image">
                @endif
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">{{ auth()->user()->name }}</a>
                <span class="text-muted">{{ auth()->user()->roles->pluck('name')->implode(', ') }}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user"></i>
                                <p>My Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                            <li class="nav-item">
                                <a href="{{ route('sections.index') }}" class="nav-link {{ request()->routeIs('sections.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-book"></i>
                                    <p>Sections</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('units.index') }}" class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>Units</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('lessons.index') }}" class="nav-link {{ request()->routeIs('lessons.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>Lessons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('contents.index') }}" class="nav-link {{ request()->routeIs('contents.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-alt"></i>
                                    <p>Contents</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('quizzes.index') }}" class="nav-link {{ request()->routeIs('quizzes.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>Quizzes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('questions.index') }}" class="nav-link {{ request()->routeIs('questions.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-question"></i>
                                    <p>Questions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('answers.index') }}" class="nav-link {{ request()->routeIs('answers.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-check-square"></i>
                                    <p>Answers</p>
                                </a>
                            </li>
                        @endif
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>