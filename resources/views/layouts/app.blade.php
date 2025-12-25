<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Perpustakaan')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f5f5f5;
        }
        .sidebar {
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            min-height: 100vh;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .card {
            border: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            font-weight: 500;
        }
        .table {
            margin-bottom: 0;
        }
        /* Fix pagination arrows */
        nav[role="navigation"] svg {
            width: 1em !important;
            height: 1em !important;
            display: inline-block;
            vertical-align: middle;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @if(auth()->user()->isAdmin())
        <!-- Admin Layout with Sidebar -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Admin -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar p-0">
                    <div class="p-3">
                        <h5 class="mb-3">Perpustakaan</h5>
                        
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}" href="{{ route('admin.buku.index') }}">
                                    <i class="bi bi-book"></i> Buku
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">
                                    <i class="bi bi-bookmark"></i> Kategori
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.anggota.*') ? 'active' : '' }}" href="{{ route('admin.anggota.index') }}">
                                    <i class="bi bi-people"></i> Anggota
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}" href="{{ route('admin.peminjaman.index') }}">
                                    <i class="bi bi-arrow-left-right"></i> Peminjaman
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.denda.*') ? 'active' : '' }}" href="{{ route('admin.denda.index') }}">
                                    <i class="bi bi-cash-stack"></i> Denda
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}" href="{{ route('admin.pengaturan') }}">
                                    <i class="bi bi-gear"></i> Pengaturan
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <!-- Main Content Admin -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-0">
                    <!-- Top Header -->
                    <nav class="navbar navbar-light bg-white border-bottom px-3">
                        <div class="container-fluid">
                            <span class="navbar-text">
                                
                            </span>
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                        {{ auth()->user()->nama }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('admin.profil.edit') }}">Profil</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    
                    <!-- Page Content -->
                    <div class="px-4">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-3">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mt-3">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        <div class="py-4">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    @else
        <!-- Anggota Layout with Container -->
        <div>
            <!-- Navbar Anggota -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('anggota.dashboard') }}">Perpustakaan</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('anggota.dashboard') ? 'active' : '' }}" href="{{ route('anggota.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('anggota.katalog*') ? 'active' : '' }}" href="{{ route('anggota.katalog') }}">Katalog</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('anggota.denda') ? 'active' : '' }}" href="{{ route('anggota.denda') }}">Denda</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    {{ auth()->user()->nama }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('anggota.profil.edit') }}">Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Main Content Anggota -->
            <div class="container">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                <!-- Page Content -->
                <div class="py-4">
                    @yield('content')
                </div>
            </div>
        </div>
    @endif
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
