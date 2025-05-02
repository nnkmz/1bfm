<?php
session_start();

// Sambung ke pangkalan data
$conn = new mysqli('localhost', 'root', '', '1bfm');
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}

// Dapatkan data dari borang login
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Cari pengguna dalam pangkalan data
$stmt = $conn->prepare("SELECT id, name, email, password, role FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Sahkan kata laluan
    if (password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
        
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    }
}

// Jika login gagal
header("Location: login.php?error=1");
$stmt->close();
$conn->close();
?>