<?php
session_start();
if (isset($_SESSION['user'])) {
    header("location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #dfd5dc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background-color: #f7f2ef;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }
        .btn-custom {
            background-color: #8c708f;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px;
        }
        .btn-custom:hover {
            background-color: #785a7b;
            color: white;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px 15px;
            background-color: #ffffff;
            border: 1px solid #e0d2dc;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold" style="color: #4a3b4c;"><i class="bi bi-book-half"></i> Login Library</h4>
                <p class="text-muted small">Silakan masuk untuk mengelola koleksi buku</p>
            </div>
            
            <form action="proses_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-secondary">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <!-- Opsi Remember Me yang tadi tertinggal -->
                <div class="mb-4 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                    <label class="form-check-label small text-secondary" for="rememberMe">Remember Me</label>
                </div>
                <button type="submit" name="login" class="btn btn-custom w-100 shadow-sm">Login</button>
            </form>
        </div>
    </div>

</body>
</html>