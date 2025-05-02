<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Baseball Malaysia</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3e72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            margin: 0 auto; /* Tambah ini untuk centerkan */
        }
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .register-header img {
            height: 80px;
            margin-bottom: 1rem;
        }
        .register-header h2 {
            color: #1a3e72;
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }
        .btn-register {
            background-color: #1a3e72;
            color: white;
            border: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-register:hover {
            background-color: #0d2b57;
        }
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        .login-link a {
            color: #1a3e72;
            font-weight: bold;
            text-decoration: none;
        }
        .form-select {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="register-container">
                    <div class="register-header">
                        <img src="assets/css/img/logo-baseball.png" alt="Logo Baseball Malaysia">
                        <h2>DAFTAR AKAUN BARU</h2>
                    </div>
                    <form method="POST" action="proses_register.php">
                        <div class="mb-3">
                            <label class="form-label">Nama Penuh</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telefon</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Laluan</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sahkan Kata Laluan</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Peranan</label>
                            <select class="form-select" name="role" required>
                                <option value="player" selected>Pemain</option>
                                <option value="coach">Jurulatih</option>
                                <option value="umpire">Pengadil</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gambar Profil</label>
                            <input type="file" class="form-control" name="profile_pic" accept="image/*" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                        </div>
                    </form>
                    <div class="login-link">
                        Sudah ada akaun? <a href="login.php">Log Masuk di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>