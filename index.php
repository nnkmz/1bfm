<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baseball Malaysia - Sistem Pengurusan</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(120deg, #1a3e72 60%, #2a5298 100%);
            min-height: 100vh;
        }
        .welcome-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .logo-baseball {
            max-width:800px; /* Diubah dari 320px ke 576px (80% lebih besar) */
            width:500%;
            margin: 50 auto;
            display: block;
        }
        .brand-title {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: bold;
            letter-spacing: 2px;
            color: #ffc107;
            text-align: center;
            margin-top: 1rem;
        }
        .card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            min-height: 200px;
        }
        .card .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #ffc107;
        }
        .navbar {
            background: transparent !important;
        }
        .btn-login {
            background: #1a3e72;
            color: #fff;
            border: none;
        }
        .btn-login:hover {
            background: #0d2b57;
            color: #fff;
        }
        .btn-register {
            background: #ffc107;
            color: #1a3e72;
            border: none;
        }
        .btn-register:hover {
            background: #e0a800;
            color: #fff;
        }
        @media (max-width: 991px) {
            .welcome-section {
                flex-direction: column;
                padding-top: 2rem;
            }
            .logo-baseball {
                margin: 2rem auto 0;
                order: 1; /* Memastikan logo muncul di bawah card */
                max-width: 400px; /* Saiz yang sesuai untuk mobile */
            }
            .col-lg-7 {
                order: 2; /* Memastikan card muncul di atas */
            }
        }
    </style>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/css/img/logo-baseball.png" alt="Logo" height="40" class="me-2">
                <span class="fw-bold text-white">Baseball Malaysia</span>
            </a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-login me-2"><i class="bi bi-box-arrow-in-right"></i> Log Masuk</a>
                <a href="register.php" class="btn btn-register"><i class="bi bi-person-plus"></i> Daftar</a>
            </div>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="container welcome-section">
        <div class="row w-100 align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold text-white mb-3">Selamat Datang ke<br>Baseball Malaysia</h1>
                <div class="mb-4" style="height:4px;width:80px;background:#ffc107;border-radius:2px;"></div>
                <p class="lead text-white-50 mb-4">Platform rasmi untuk pengurusan dan pembangunan sukan baseball di Malaysia</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <div class="card-icon"><i class="bi bi-trophy-fill"></i></div>
                                <h5 class="card-title fw-bold">Pengurusan Pertandingan</h5>
                                <p class="card-text">Urus dan pantau pertandingan baseball di seluruh Malaysia dengan mudah dan efisien</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <div class="card-icon"><i class="bi bi-people-fill"></i></div>
                                <h5 class="card-title fw-bold">Pengurusan Jurulatih</h5>
                                <p class="card-text">Sistem pengurusan jurulatih yang komprehensif untuk pembangunan sukan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <div class="card-icon"><i class="bi bi-bar-chart-fill"></i></div>
                                <h5 class="card-title fw-bold">Statistik &amp; Analisis</h5>
                                <p class="card-text">Pantau prestasi dan perkembangan pemain dengan analisis terperinci</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-flex flex-column align-items-center justify-content-center">
                <img src="assets/css/img/logo-baseball.png" alt="Logo Baseball Malaysia" class="logo-baseball mb-3"> 
            </div>
        </div>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>