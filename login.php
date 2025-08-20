<?php
session_start();
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ponpes Inayatullah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('image/ponpes.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .header {
            padding: 20px;
            text-align: center;
            margin: 20px;
        }
        .header img {
            height: 60px;
        }
        .card-custom {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
        }
        .footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 2px solid #4CAF50;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="image/logo.png" alt="Logo Ponpes">
        <h1>Sistem Informasi Penilaian Santri <br>Pondok Pesantren Inayatullah</h1>
    </div>

    <!-- Login Form -->
    <div class="container d-flex justify-content-center align-items-center" style="height: 50vh;">
        <div class="col-md-5">
            <div class="card card-custom shadow-lg">
                <div class="card-header text-center bg-transparent border-0">
                    <h3 class="text-white">Login</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div class="alert alert-danger text-center">
                            <?= htmlspecialchars($_SESSION['login_error']) ?>
                            <?php unset($_SESSION['login_error']); ?>
                        </div>
                    <?php endif; ?>
                    <form action="proses_login.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                            <label for="username">USERNAME</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <label for="password">PASSWORD</label>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <a href="https://inay.asadth95.web.id/warga-pondok/pengasuh/">Tentang Kami</a> |
        <a href="https://inay.asadth95.web.id/pendaftaran/alur-pendaftaran/">Informasi Pendaftaran</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
