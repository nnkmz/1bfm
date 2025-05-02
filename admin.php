<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Sambungan ke pangkalan data
$conn = new mysqli('localhost', 'root', '', '1bfm');
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <!-- Header Dashboard -->
    <div class="dashboard-header bg-blue-500 text-white p-4"> <!-- Added bg-blue-500, text-white, p-4 -->
        <div class="container mx-auto flex justify-between items-center"> <!-- Use Tailwind container, flexbox -->
            <h1 class="text-xl font-bold">Selamat Datang Admin</h1> <!-- Tailwind text styling -->
            <a href="logout.php" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Log Keluar</a> <!-- Tailwind button styling -->
        </div>
    </div>

    <!-- Kandungan Dashboard Admin -->
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <!-- Card Pengurusan Pengguna -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Pengurusan Pengguna</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Urus akaun pengguna termasuk pemain, jurulatih dan pengadil</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="manage_users.php" class="btn btn-primary">Urus Pengguna</a>
                    </div>
                </div>
            </div>
            
            <!-- Card Pengurusan Pasukan -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Pengurusan Pasukan</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Buat, kemaskini dan urus pasukan besbol</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="manage_teams.php" class="btn btn-primary">Urus Pasukan</a>
                    </div>
                </div>
            </div>
            
            <!-- Card Pengurusan Pemain -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Pengurusan Pemain</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Urus profil, statistik dan prestasi pemain besbol</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="manage_players.php" class="btn btn-primary">Urus Pemain</a>
                    </div>
                </div>
            </div>
            
            <!-- Card Pengurusan Pertandingan -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Pengurusan Pertandingan</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Jadualkan dan urus pertandingan besbol</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="manage_tournaments.php" class="btn btn-primary">Urus Pertandingan</a>
                    </div>
                </div>
            </div>

            <!-- Card Pengurusan Pengadil -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Pengurusan Pengadil</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Urus jadual dan tugasan pengadil</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="manage_umpires.php" class="btn btn-primary">Urus Pengadil</a>
                    </div>
                </div>
            </div>
            
            <!-- Card Statistik -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Statistik</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Lihat dan analisis statistik pemain dan pasukan</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="statistics.php" class="btn btn-success">Lihat Statistik</a>
                    </div>
                </div>
            </div>
            
            <!-- Card Laporan -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-4 h-full">
                    <div class="bg-blue-500 text-white rounded-t-lg p-3">
                        <h5 class="card-title mb-0">Laporan</h5>
                    </div>
                    <div class="p-4">
                        <p class="card-text">Jana dan lihat laporan prestasi dan aktiviti</p>
                    </div>
                    <div class="bg-gray-100 rounded-b-lg px-4 py-3">
                        <a href="reports.php" class="btn btn-info">Lihat Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 
if (isset($conn)) {
    $conn->close(); 
}
?>