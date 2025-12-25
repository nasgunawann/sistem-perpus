<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f5f5f5;
        }
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h1 class="display-4 fw-bold mb-3">Sistem Perpustakaan</h1>
                    <p class="lead text-muted mb-4">
                        Kelola peminjaman buku dengan mudah dan efisien
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">
                            Daftar Anggota
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-book fs-1 text-primary"></i>
                                    <h6 class="mt-2 mb-0">Koleksi Buku</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 text-success"></i>
                                    <h6 class="mt-2 mb-0">Anggota</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-arrow-left-right fs-1 text-warning"></i>
                                    <h6 class="mt-2 mb-0">Peminjaman</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-bar-chart fs-1 text-info"></i>
                                    <h6 class="mt-2 mb-0">Laporan</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
