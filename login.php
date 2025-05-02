<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - Baseball Malaysia</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3e72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 450px;
            width: 100%;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header img {
            height: 80px;
            margin-bottom: 1rem;
        }
        .login-header h2 {
            color: #1a3e72;
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
        }
        .btn-login {
            background-color: #1a3e72;
            color: white;
            border: none;
            padding: 0.75rem;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: #0d2b57;
        }
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        .register-link a {
            color: #1a3e72;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-container">
                    <div class="login-header">
                        <img src="assets/css/img/logo-baseball.png" alt="Logo Baseball Malaysia">
                        <h2>LOG MASUK</h2>
                    </div>
                    <?php
                    if (isset($_GET['error']) && $_GET['error'] == 1) {
                        echo '<div class="alert alert-danger text-center mb-3" role="alert">E-mel atau kata laluan salah. Sila cuba lagi.</div>';
                    }
                    ?>
                    <form action="proses_login.php" method="POST">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Alamat Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Kata Laluan" required>
                        </div>
                        <button type="submit" class="btn btn-login">Log Masuk</button>
                    </form>
                    <div class="register-link">
                        Tiada akaun? <a href="register.php">Daftar di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>