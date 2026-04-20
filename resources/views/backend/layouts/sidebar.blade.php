@php
    $segment = Request::segment(2);
    $segment3 = Request::segment(3);
    $authUser = auth()->user();
@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"
                onclick="sidebarCollapse()"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item d-none d-sm-inline-block">
            <span class="nav-link" style="color:#6366f1; font-weight:600; font-size:0.82rem;">
                <i class="fas fa-circle"
                    style="color:#22c55e; font-size:0.5rem; vertical-align:middle; margin-right:5px;"></i>
                {{ $authUser->name ?? 'Admin' }}
            </span>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" onclick="fullScreen()">
                <i class="fas fa-expand-arrows-alt" id="add-fa-class"></i>
            </a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('backend.dashboard') }}" class="brand-link text-center">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('backend.dashboard') }}"
                        class="nav-link @if ($segment == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.project.index') }}"
                        class="nav-link @if ($segment == 'project') active @endif">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Project</p>
                    </a>
                </li>

                <li class="nav-header">My Account</li>

                <li class="nav-item">
                    <a href="{{ route('backend.profile.edit', auth()->id()) }}"
                        class="nav-link @if ($segment == 'profile') active @endif">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('backend.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>