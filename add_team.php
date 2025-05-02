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

$message = '';

// Proses borang jika dihantar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = $conn->real_escape_string($_POST['team_name']);
    $abbreviation = $conn->real_escape_string($_POST['abbreviation']);
    $location = $conn->real_escape_string($_POST['location']);
    $coach_id = isset($_POST['coach_id']) ? (int)$_POST['coach_id'] : null;
    $founded_year = isset($_POST['founded_year']) ? (int)$_POST['founded_year'] : null;
    $logo = isset($_POST['logo']) ? $conn->real_escape_string($_POST['logo']) : null;
    
    // Pastikan jadual teams wujud
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
            $message = "Ralat membuat jadual teams: " . $conn->error;
        }
    }
    
    // Masukkan data pasukan baru
    $stmt = $conn->prepare("INSERT INTO teams (team_name, abbreviation, location, coach_id, founded_year, logo) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiis", $team_name, $abbreviation, $location, $coach_id, $founded_year, $logo);
    
    if ($stmt->execute()) {
        header("Location: manage_teams.php?success=1");
        exit();
    } else {
        $message = "Ralat: " . $stmt->error;
    }
    
    $stmt->close();
}

// Dapatkan senarai jurulatih untuk dropdown
$coaches = $conn->query("SELECT id, name FROM users WHERE role = 'coach' ORDER BY name");
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pasukan Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 700px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Pasukan Baru</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($message)): ?>
                <div class="alert alert-danger"><?= $message ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pasukan</label>
                            <input type="text" class="form-control" name="team_name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Singkatan</label>
                            <input type="text" class="form-control" name="abbreviation" maxlength="10" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="location" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ditubuhkan</label>
                            <input type="number" class="form-control" name="founded_year" min="1900" max="<?= date('Y') ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jurulatih</label>
                        <select class="form-select" name="coach_id">
                            <option value="">-- Pilih Jurulatih --</option>
                            <?php while ($coach = $coaches->fetch_assoc()): ?>
                            <option value="<?= $coach['id'] ?>"><?= htmlspecialchars($coach['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">URL Logo (opsyenal)</label>
                        <input type="text" class="form-control" name="logo" placeholder="http://contoh.com/logo.png">
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="manage_teams.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Pasukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn->close();
?>