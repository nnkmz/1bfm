<?php
// Fail untuk mengurus jadual latihan dan kehadiran
require_once 'config.php';

// Semak jika pengguna telah log masuk
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Dapatkan maklumat pengguna
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['user_role'] ?? '';
$message = '';

// Sambung ke pangkalan data
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Proses borang untuk jurulatih
    if ($user_role === 'coach' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_schedule'])) {
            $date = $_POST['date'];
            $time = $_POST['time'];
            $location = $_POST['location'];
            $notes = $_POST['notes'];
            
            $stmt = $conn->prepare("INSERT INTO training_schedule (date, time, location, notes, coach_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$date, $time, $location, $notes, $user_id]);
            $message = 'Jadual berjaya ditambah!';
        } elseif (isset($_POST['delete_schedule'])) {
            $schedule_id = $_POST['schedule_id'];
            $stmt = $conn->prepare("DELETE FROM training_schedule WHERE id = ? AND coach_id = ?");
            $stmt->execute([$schedule_id, $user_id]);
            $message = 'Jadual berjaya dipadam!';
        }
    }
    
    // Proses borang untuk pemain
    if ($user_role === 'player' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['attendance'])) {
        $schedule_id = $_POST['schedule_id'];
        $status = $_POST['status'];
        
        $stmt = $conn->prepare("INSERT INTO training_attendance (schedule_id, player_id, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = ?");
        $stmt->execute([$schedule_id, $user_id, $status, $status]);
        $message = 'Kehadiran berjaya dikemaskini!';
    }

    // Dapatkan jadual latihan
    $sql = "SELECT ts.id, ts.date, ts.time, ts.location, ts.notes, u.name AS coach_name 
            FROM training_schedule ts 
            JOIN users u ON ts.coach_id = u.id";
            
    if ($user_role === 'player') {
        $sql .= " WHERE ts.id IN (SELECT team_id FROM players WHERE user_id = ?)";
    } elseif ($user_role === 'coach') {
        $sql .= " WHERE ts.coach_id = ?";
    }
    
    $sql .= " ORDER BY ts.date, ts.time";
    
    $stmt = $conn->prepare($sql);
    if ($user_role === 'player' || $user_role === 'coach') {
        $stmt->bindParam(1, $user_id);
    }
    $stmt->execute();
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    
    // Dapatkan status kehadiran untuk pemain
    $attendance = [];
    if ($user_role === 'player') {
        $stmt = $conn->prepare("SELECT schedule_id, status FROM training_attendance WHERE player_id = ?");
        $stmt->execute([$user_id]);
        $attendance = $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?? [];
    }

} catch(PDOException $e) {
    $message = "Ralat: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadual Latihan - Baseball Malaysia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3e72 0%, #2a5298 100%);
            min-height: 100vh;
            padding-top: 2rem;
        }
        .schedule-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .schedule-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .schedule-header img {
            height: 80px;
            margin-bottom: 1rem;
        }
        .schedule-header h2 {
            color: #1a3e72;
            font-weight: bold;
        }
        .table-responsive {
            margin-top: 1.5rem;
        }
        .table th {
            background-color: #1a3e72;
            color: white;
        }
        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }
        .back-link a {
            color: #1a3e72;
            font-weight: bold;
            text-decoration: none;
        }
        .alert {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="schedule-container">
                    <div class="schedule-header">
                        <img src="assets/css/img/logo-baseball.png" alt="Logo Baseball Malaysia">
                        <h2>JADUAL LATIHAN</h2>
                    </div>
                    
                    <?php if ($message): ?>
                        <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($user_role === 'coach'): ?>
                        <div class="mb-4">
                            <h4>Tambah Jadual Baru</h4>
                            <form method="post">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label for="date" class="form-label">Tarikh</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="time" class="form-label">Masa</label>
                                        <input type="time" class="form-control" id="time" name="time" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="location" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" id="location" name="location" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="notes" class="form-label">Nota</label>
                                        <input type="text" class="form-control" id="notes" name="notes">
                                    </div>
                                </div>
                                <button type="submit" name="add_schedule" class="btn btn-primary mt-3">Tambah</button>
                            </form>
                        </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Tarikh</th>
                                    <th>Masa</th>
                                    <th>Lokasi</th>
                                    <th>Nota</th>
                                    <th>Jurulatih</th>
                                    <?php if ($user_role === 'player'): ?>
                                        <th>Kehadiran</th>
                                    <?php elseif ($user_role === 'coach'): ?>
                                        <th>Tindakan</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($schedules as $schedule): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($schedule['date']); ?></td>
                                    <td><?php echo htmlspecialchars($schedule['time']); ?></td>
                                    <td><?php echo htmlspecialchars($schedule['location']); ?></td>
                                    <td><?php echo htmlspecialchars($schedule['notes']); ?></td>
                                    <td><?php echo htmlspecialchars($schedule['coach_name']); ?></td>
                                    <?php if ($user_role === 'player'): ?>
                                        <td>
                                            <form method="post">
                                                <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
                                                <select name="status" class="form-select" onchange="this.form.submit()">
                                                    <option value="" disabled <?php echo !isset($attendance[$schedule['id']]) ? 'selected' : ''; ?>>Pilih</option>
                                                    <option value="hadir" <?php echo isset($attendance[$schedule['id']]) && $attendance[$schedule['id']] === 'hadir' ? 'selected' : ''; ?>>Hadir</option>
                                                    <option value="tidak_hadir" <?php echo isset($attendance[$schedule['id']]) && $attendance[$schedule['id']] === 'tidak_hadir' ? 'selected' : ''; ?>>Tidak Hadir</option>
                                                </select>
                                                <input type="hidden" name="attendance" value="1">
                                            </form>
                                        </td>
                                    <?php elseif ($user_role === 'coach'): ?>
                                        <td>
                                            <form method="post" style="display:inline">
                                                <input type="hidden" name="schedule_id" value="<?php echo $schedule['id']; ?>">
                                                <button type="submit" name="delete_schedule" class="btn btn-danger btn-sm" onclick="return confirm('Adakah anda pasti ingin memadam jadual ini?')">Padam</button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="back-link">
                        <a href="dashboard.php">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$conn = null;
?>