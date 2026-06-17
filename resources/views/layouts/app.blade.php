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
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
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

        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">RBAC SYSTEM</span>
        </a>

        <div class="sidebar">

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column">

                    <!-- SINGLE DASHBOARD -->
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- ROLE BASED NAV -->
                    @if(auth()->check() && auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>Create User</p>
                            </a>
                        </li>
                    @endif

                    @if(auth()->check())
                        <li class="nav-item">
                            <a href="{{ route('institutes.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-school"></i>
                                <p>Institutes</p>
                            </a>
                        </li>

                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('institutes.create') }}" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Create New Institute</p>
                                </a>
                            </li>
                        @endif




                        

                        <li class="nav-item">
                            <a href="{{ route('candidates.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>Candidates</p>
                            </a>
                        </li>



                        <!-- 🛑 Pehle check karein jahan Candidates ka block khatam ho raha hai, uske thik niche ye paste karein -->

                        <!-- ADMISSIONS FLOW HEADER -->
                        <li class="nav-header" style="padding: 15px 1rem 5px 1rem; font-size: .75rem; font-weight: 700; color: #6c757d; text-transform: uppercase;">
                            Admission Flow
                        </li>

                        <!-- VIEW ADMISSIONS LINK -->
                        <li class="nav-item">
                            <a href="{{ route('admissions.index') }}" class="nav-link {{ request()->routeIs('admissions.index') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 10px; padding: 0.6rem 1rem; color: #c2c7d0;">
                                <i class="nav-icon fas fa-list-alt" style="width: 1.6rem; text-align: center; font-size: 1.1rem;"></i>
                                <p style="margin: 0;">View Admissions</p>
                            </a>
                        </li>

                        <!-- ADD ADMISSION LINK -->
                        <li class="nav-item">
                            <a href="{{ route('admissions.create') }}" class="nav-link {{ request()->routeIs('admissions.create') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 10px; padding: 0.6rem 1rem; color: #c2c7d0;">
                                <i class="nav-icon fas fa-plus-circle" style="width: 1.6rem; text-align: center; font-size: 1.1rem;"></i>
                                <p style="margin: 0;">Add Admission</p>
                            </a>
                        </li>

                        @if(auth()->user()->role !== 'admin')
                            @php $institute = auth()->user()->institute; @endphp
                            @if($institute)
                                <li class="nav-item">
                                    <a href="{{ route('institutes.show', $institute) }}" class="nav-link">
                                        <i class="nav-icon fas fa-building"></i>
                                        <p>{{ $institute->name }}</p>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif

                </ul>
            </nav>

        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper p-3">

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
