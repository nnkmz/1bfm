<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', '1bfm');
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}

// Periksa jika jadual teams wujud
$check_table = $conn->query("SHOW TABLES LIKE 'teams'");
if ($check_table->num_rows == 0) {
    // Buat jadual jika belum wujud
    $create_table = "CREATE TABLE teams (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        team_name VARCHAR(100) NOT NULL,
        abbreviation VARCHAR(10) NOT NULL,
        location VARCHAR(100) NOT NULL,
        coach_id INT(11) NULL,
        founded_year INT(4) NULL,
        logo VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($create_table) === FALSE) {
        die("Ralat membuat jadual teams: " . $conn->error);
    }
}

// Dapatkan senarai pasukan dengan nama jurulatih
$teams = $conn->query("
    SELECT t.*, u.name as coach_name 
    FROM teams t 
    LEFT JOIN users u ON t.coach_id = u.id 
    ORDER BY t.id DESC
");

// Mesej kejayaan
$success_message = '';
if (isset($_GET['success'])) {
    $success_message = 'Pasukan berjaya disimpan!';
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Pasukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Senarai Pasukan</h4>
                <div>
                    <a href="admin.php" class="btn btn-light btn-sm me-2">Home</a>
                    <a href="add_team.php" class="btn btn-success btn-sm">Tambah Pasukan Baru</a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?= $success_message ?></div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama Pasukan</th>
                                <th>Singkatan</th>
                                <th>Lokasi</th>
                                <th>Jurulatih</th>
                                <th>Tahun Ditubuhkan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($teams->num_rows > 0): ?>
                                <?php while ($team = $teams->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $team['id'] ?></td>
                                    <td><?= htmlspecialchars($team['team_name']) ?></td>
                                    <td><?= htmlspecialchars($team['abbreviation']) ?></td>
                                    <td><?= htmlspecialchars($team['location']) ?></td>
                                    <td><?= $team['coach_name'] ? htmlspecialchars($team['coach_name']) : 'Tiada' ?></td>
                                    <td><?= $team['founded_year'] ? $team['founded_year'] : 'Tiada' ?></td>
                                    <td>
                                        <a href="edit_team.php?id=<?= $team['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_team.php?id=<?= $team['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Adakah anda pasti mahu padam pasukan ini?')">Padam</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Tiada pasukan dijumpai. Sila tambah pasukan baru.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>