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

$tournaments = $conn->query("SELECT * FROM tournaments ORDER BY start_date DESC");
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Pertandingan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>Senarai Pertandingan</h4>
            </div>
            <div class="card-body">
                <a href="add_tournament.php" class="btn btn-primary mb-3">Tambah Pertandingan Baru</a>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tarikh Mula</th>
                                <th>Tarikh Tamat</th>
                                <th>Lokasi</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($tournament = $tournaments->fetch_assoc()): ?>
                            <tr>
                                <td><?= $tournament['name'] ?></td>
                                <td><?= date('d/m/Y', strtotime($tournament['start_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($tournament['end_date'])) ?></td>
                                <td><?= $tournament['location'] ?></td>
                                <td>
                                    <a href="edit_tournament.php?id=<?= $tournament['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="delete_tournament.php?id=<?= $tournament['id'] ?>" class="btn btn-sm btn-danger">Padam</a>
                                </td>
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