<?php
session_start();

// Semak jika pengguna telah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Dapatkan maklumat pengguna dari session
$user_role = $_SESSION['user_role'];
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Baseball Malaysia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-header {
            background: linear-gradient(135deg, #1a3e72 0%, #2a5298 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Selamat Datang, <?= htmlspecialchars($user_name) ?></h1>
                    <p class="mb-0">Anda log masuk sebagai <?= ucfirst($user_role) ?></p>
                    <p>Email: <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                    <p>Telefon: <?= htmlspecialchars($_SESSION['phone']) ?></p>
                </div>
                <div class="col-md-6 text-end">
            <?php if (!empty($_SESSION['profile_pic'])): ?>
                <img src="<?php echo $_SESSION['profile_pic']; ?>" alt="Profile Picture" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            <?php endif; ?>
                    <a href="logout.php" class="btn btn-light">Log Keluar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Kandungan Dashboard -->
    <div class="container">
        <div class="row">
            <?php if ($user_role === 'player'): ?>
                <!-- Dashboard Pemain -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Statistik Saya</h5>
                            <p class="card-text">Lihat prestasi dan statistik permainan anda</p>
                            <a href="player_stats.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Jadual Latihan</h5>
                            <p class="card-text">Semak jadual latihan terkini</p>
                            <a href="training_schedule.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Pasukan Saya</h5>
                            <p class="card-text">Maklumat pasukan dan ahli pasukan</p>
                            <a href="my_team.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>

            <?php elseif ($user_role === 'coach'): ?>
                <!-- Dashboard Jurulatih -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Urus Pasukan</h5>
                            <p class="card-text">Pengurusan ahli pasukan dan maklumat</p>
                            <a href="manage_team.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Jadual Latihan</h5>
                            <p class="card-text">Buat dan urus jadual latihan</p>
                            <a href="manage_schedule.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Analisis Prestasi</h5>
                            <p class="card-text">Analisis statistik pemain</p>
                            <a href="performance_analysis.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>

            <?php elseif ($user_role === 'umpire'): ?>
                <!-- Dashboard Pengadil -->
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Jadual Perlawanan</h5>
                            <p class="card-text">Semak jadual perlawanan</p>
                            <a href="match_schedule.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Laporan Perlawanan</h5>
                            <p class="card-text">Isi laporan perlawanan</p>
                            <a href="match_reports.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Profil Saya</h5>
                            <p class="card-text">Kemaskini maklumat profil</p>
                            <a href="profile.php" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>