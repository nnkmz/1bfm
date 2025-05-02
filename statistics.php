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

// Dapatkan statistik pemain (menggunakan users table sebagai contoh)
$player_stats = $conn->query("SELECT 
    u.name, 
    COUNT(DISTINCT g.game_id) as games_played,
    SUM(g.score) as total_goals,
    AVG(g.score) as avg_goals_per_game
FROM users u
LEFT JOIN game_stats g ON u.id = g.user_id
WHERE u.role = 'player'
GROUP BY u.id");

// Dapatkan statistik pasukan
$team_stats = $conn->query("SELECT 
    t.name as name, 
    COUNT(DISTINCT g.id) as matches_played,
    SUM(CASE WHEN g.winner_team_id = t.id THEN 1 ELSE 0 END) as total_wins
FROM teams t
LEFT JOIN games g ON t.id IN (g.home_team_id, g.away_team_id)
GROUP BY t.id");
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">                                                                                                                                                                                                                                               
    <meta name="viewport"  
    <title>Statistik</titl 
    <link href="https://cd 
    <style>
        body {
            background-col 
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
        <!-- Statistik Pemain -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Statistik Pemain</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pemain</th>
                                <th>Bilangan Permainan</th>
                                <th>Jumlah Gol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($player = $player_stats->fetch_assoc()): ?>
                            <tr>
                                <td><?= $player['name'] ?></td>
                                <td><?= $player['games_played'] ?></td>
                                <td><?= $player['total_goals'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Statistik Pasukan -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Statistik Pasukan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Pasukan</th>
                                <th>Bilangan Perlawanan</th>
                                <th>Jumlah Kemenangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($team = $team_stats->fetch_assoc()): ?>
                            <tr>
                                <td><?= $team['name'] ?></td>
                                <td><?= $team['matches_played'] ?></td>
                                <td><?= $team['total_wins'] ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>
<?php
// Sambungan ke pangkalan data
$conn = new mysqli('localhost', 'username', 'password', '1bfm');
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan statistik
$query = "SELECT 
    u.name, 
    COUNT(ta.schedule_id) AS total_sessions,
    SUM(CASE WHEN ta.status = 'hadir' THEN 1 ELSE 0 END) AS attended_sessions,
    (SUM(CASE WHEN ta.status = 'hadir' THEN 1 ELSE 0 END) / COUNT(ta.schedule_id)) * 100 AS attendance_percentage
FROM 
    users u
LEFT JOIN 
    training_attendance ta ON u.id = ta.player_id
GROUP BY 
    u.id, u.name";

$result = $conn->query($query);

// Paparkan hasil
echo '<h2>Statistik Kehadiran Latihan</h2>';
echo '<table border="1">';
echo '<tr><th>Nama</th><th>Sesi Hadir</th><th>Jumlah Sesi</th><th>Peratus Kehadiran</th></tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
    echo '<td>' . $row['attended_sessions'] . '</td>';
    echo '<td>' . $row['total_sessions'] . '</td>';
    echo '<td>' . number_format($row['attendance_percentage'], 2) . '%</td>';
    echo '</tr>';
}

echo '</table>';

$conn->close();
?>