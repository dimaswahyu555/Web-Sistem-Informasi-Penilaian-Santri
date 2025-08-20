<?php
// Hindari double session_start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../config.php";

// Pastikan user login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../login.php';</script>";
    exit;
}

// Pastikan session memiliki id_admin
if (!isset($_SESSION['id_admin'])) {
    echo "<script>alert('Session tidak valid. Silakan login ulang.'); window.location='../login.php';</script>";
    exit;
}

$id_admin = $_SESSION['id_admin'];

// Ambil data dari tabel users JOIN admin berdasarkan id_admin
$query = mysqli_query($conn, "SELECT users.username, users.role, admin.nama_lengkap, admin.email, admin.no_hp
                              FROM users
                              LEFT JOIN admin ON users.id_admin = admin.id_admin
                              WHERE users.id_admin = '$id_admin'") or die(mysqli_error($conn));

$profile = mysqli_fetch_assoc($query);

// Fallback jika data tidak ditemukan
if (!$profile) {
    $profile = [
        'username'      => 'Unknown',
        'role'          => '-', // Tambahkan default untuk role
        'nama_lengkap'  => '-',
        'email'         => '-',
        'no_hp'         => '-'
    ];
}
?>

<body class="sb-nav-fixed" style="padding-top: 40px;">
    <!-- Navbar -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark custom-navbar">
        <!-- Brand -->
        <a class="navbar-brand ps-3" href="<?= $main_url ?>index.php">Ponpes Inayatullah</a>

        <!-- User Info -->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <span class="text-white text-capitalize">
                <?= htmlspecialchars($profile['username']) ?>
            </span>
        </form>

        <!-- Profile Dropdown -->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i> Profile
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#mdlprofileUser">
                            Lihat Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?= $main_url ?>/logout.php">Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Modal Profile -->
    <div class="modal fade" id="mdlprofileUser" tabindex="-1" aria-labelledby="mdlprofileUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdlprofileUserLabel">Profil Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Tampilkan data profil lengkap termasuk role -->
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nama:</strong> <?= htmlspecialchars($profile['nama_lengkap']) ?></li>
                        <li class="list-group-item"><strong>Username:</strong> <?= htmlspecialchars($profile['username']) ?></li>
                        <li class="list-group-item"><strong>Role:</strong> <?= htmlspecialchars($profile['role']) ?></li> <!-- Tambahan Role -->
                        <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($profile['email']) ?></li>
                        <li class="list-group-item"><strong>No HP:</strong> <?= htmlspecialchars($profile['no_hp']) ?></li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional: Toggle Sidebar -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebarToggle = document.getElementById("sidebarToggle");
            if (sidebarToggle) {
                sidebarToggle.addEventListener("click", function () {
                    document.body.classList.toggle("sb-sidenav-toggled");
                });
            }
        });
    </script>

    <!-- Custom Style -->
    <style>
        .dropdown-menu {
            z-index: 1050 !important;
        }

        .custom-navbar {
            background-color: rgb(164, 167, 88) !important;
        }

        .modal-content {
            border-radius: 10px;
        }
    </style>
</body>
