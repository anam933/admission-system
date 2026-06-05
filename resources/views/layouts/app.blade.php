<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RBAC Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light  layout-fixed">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">

        <a href="#" class="brand-link">
            <span class="brand-text font-weight-light">RBAC SYSTEM</span>
        </a>

        <div class="sidebar">

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @if(auth()->user()->role == 'admin')

                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Create User</p>
                            </a>
                        </li>

                        @endif

                    @if(auth()->user()->role == 'manager')
                    <li class="nav-item">
                        <a href="{{ route('manager.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manager Panel</p>
                        </a>
                    </li>
                    @endif

                    @if(auth()->user()->role == 'employee')
                    <li class="nav-item">
                        <a href="{{ route('employee.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>Employee Panel</p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>

        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper p-3">

        <!-- Page Content -->
        @yield('content')

    </div>

    <!-- Footer -->
    <footer class="main-footer">
    <strong>RBAC Management System</strong>
    <div class="float-right d-none d-sm-inline-block">
        Version 1.0
    </div>
</footer>

</div>

<!-- JS -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
</body>
</html>