<?php
// Fail untuk memaparkan statistik pemain
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
$stats = []; // Inisialisasi array kosong untuk statistik

// Sambung ke pangkalan data
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Dapatkan statistik pemain
    $sql = "SELECT 
        u.name AS player_name,
        p.jersey_number,
        p.position,
        SUM(pgs.at_bats) AS total_at_bats,
        SUM(pgs.hits) AS total_hits,
        SUM(pgs.runs) AS total_runs,
        SUM(pgs.rbi) AS total_rbi,
        SUM(pgs.walks) AS total_walks,
        SUM(pgs.strikeouts) AS total_strikeouts,
        SUM(pgs.home_runs) AS total_home_runs,
        SUM(pgs.stolen_bases) AS total_stolen_bases
    FROM player_game_stats pgs
    JOIN players p ON pgs.player_id = p.id
    JOIN users u ON p.user_id = u.id";

    // Tambah syarat berdasarkan peranan pengguna
    if ($user_role === 'player') {
        $sql .= " WHERE p.user_id = :user_id";
    } elseif ($user_role === 'coach') {
        $sql .= " WHERE p.team_id IN (SELECT team_id FROM coaches WHERE user_id = :user_id)";
    }

    $sql .= " GROUP BY pgs.player_id";

    $stmt = $conn->prepare($sql);
    if ($user_role === 'player' || $user_role === 'coach') {
        $stmt->bindParam(':user_id', $user_id);
    }
    $stmt->execute();
    $stats = $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];

} catch(PDOException $e) {
    echo "Ralat: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Pemain - Baseball Malaysia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3e72 0%, #2a5298 100%);
            min-height: 100vh;
            padding-top: 2rem;
        }
        .stats-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .stats-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .stats-header img {
            height: 80px;
            margin-bottom: 1rem;
        }
        .stats-header h2 {
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="stats-container">
                    <div class="stats-header">
                        <img src="assets/css/img/logo-baseball.png" alt="Logo Baseball Malaysia">
                        <h2>STATISTIK PEMAIN</h2>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Pemain</th>
                                    <th>No Jersi</th>
                                    <th>Posisi</th>
                                    <th>At Bats</th>
                                    <th>Hits</th>
                                    <th>Runs</th>
                                    <th>RBI</th>
                                    <th>Walks</th>
                                    <th>Strikeouts</th>
                                    <th>Home Runs</th>
                                    <th>Stolen Bases</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stats as $stat): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($stat['player_name']); ?></td>
                                    <td><?php echo htmlspecialchars($stat['jersey_number']); ?></td>
                                    <td><?php echo htmlspecialchars($stat['position']); ?></td>
                                    <td><?php echo htmlspecialchars($stat['total_at_bats']); ?></td>
                                    <td><?php echo isset($row['runs']) ? $row['runs'] : '0'; ?></td>
                                    <td><?php echo isset($row['points']) ? $row['points'] : '0'; ?></td>
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