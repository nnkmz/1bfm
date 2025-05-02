<?php
// Pastikan data borang dihantar
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: register.php");
    exit();
}

// Sambungan ke pangkalan data
$conn = new mysqli('localhost', 'root', '', '1bfm');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dapatkan dan bersihkan data dari borang
$name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
$email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
$phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : ''; // Tambah phone
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : 'player';

// Pastikan jadual users wujud
$check_table = $conn->query("SHOW TABLES LIKE 'users'");
if ($check_table->num_rows == 0) {
    die("Jadual users belum wujud. Sila jalankan skema pangkalan data terlebih dahulu.");
}

// Masukkan data pengguna baru
$stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)"); // Tambah phone
// Buat direktori untuk menyimpan gambar profil
$upload_dir = 'uploads/profile_pics/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Proses fail gambar profil
$profile_pic = '';
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $file_name = basename($_FILES['profile_pic']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($file_ext, $allowed_ext)) {
        $new_file_name = uniqid('', true) . '.' . $file_ext;
        $file_path = $upload_dir . $new_file_name;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $file_path)) {
            $profile_pic = $file_path;
        }
    }
}

// Tambah kolom profile_pic dalam query SQL
$stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, role, profile_pic) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $name, $email, $phone, $password, $role, $profile_pic); // Tambah 's' untuk phone
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: login.php?register=success");
} else {
    header("Location: register.php?error=1");
}

$stmt->close();
$conn->close();
?>