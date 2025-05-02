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

$id = $_GET['id'] ?? 0;
$conn->query("DELETE FROM users WHERE id = $id");
$conn->close();

header("Location: manage_users.php");
exit();
?>