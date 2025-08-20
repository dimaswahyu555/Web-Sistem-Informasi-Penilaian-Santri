<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$data = [];

switch ($role) {
    case 'admin':
        $query = mysqli_query($conn, "SELECT nama_lengkap, email, no_hp, foto FROM admin WHERE email = '$username'");
        $data = mysqli_fetch_assoc($query);
        break;
    case 'guru':
        $query = mysqli_query($conn, "SELECT nama_guru, nip, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, email, pendidikan_terakhir FROM guru WHERE email = '$username'");
        $data = mysqli_fetch_assoc($query);
        break;
    case 'santri':
        $query = mysqli_query($conn, "SELECT nama_santri, nisn, tanggal_lahir, alamat, jenis_kelamin, kelas, program_pendidikan, foto FROM santri WHERE nisn = '$username'");
        $data = mysqli_fetch_assoc($query);
        break;
    default:
        echo "Role tidak dikenali.";
        exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #dfe9f3, #ffffff);
            padding: 40px;
        }
        .profile-card {
            max-width: 750px;
            margin: auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.05);
        }
        .profile-img {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f0f0f0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header h2 {
            font-weight: 600;
        }
        .profile-info p {
            font-size: 1rem;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

<div class="profile-card">
    <div class="profile-header">
        <img src="../image/<?= htmlspecialchars($data['foto'] ?? 'default-user.png') ?>" class="profile-img" alt="Foto Profil">
        <h2 class="mt-3"><?= ucfirst($role) ?> Profile</h2>
    </div>

    <div class="profile-info">
        <?php if ($role == 'admin'): ?>
            <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama_lengkap']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></p>
            <p><strong>No HP:</strong> <?= htmlspecialchars($data['no_hp']) ?></p>
        <?php elseif ($role == 'guru'): ?>
            <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama_guru']) ?></p>
            <p><strong>NIP:</strong> <?= htmlspecialchars($data['nip']) ?></p>
            <p><strong>TTL:</strong> <?= htmlspecialchars($data['tempat_lahir']) ?>, <?= htmlspecialchars($data['tanggal_lahir']) ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($data['jenis_kelamin']) ?></p>
            <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
            <p><strong>No HP:</strong> <?= htmlspecialchars($data['no_hp']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($data['email']) ?></p>
            <p><strong>Pendidikan Terakhir:</strong> <?= htmlspecialchars($data['pendidikan_terakhir']) ?></p>
        <?php elseif ($role == 'santri'): ?>
            <p><strong>Nama Santri:</strong> <?= htmlspecialchars($data['nama_santri']) ?></p>
            <p><strong>NISN:</strong> <?= htmlspecialchars($data['nisn']) ?></p>
            <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($data['tanggal_lahir']) ?></p>
            <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
            <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($data['jenis_kelamin']) ?></p>
            <p><strong>Kelas:</strong> <?= htmlspecialchars($data['kelas']) ?></p>
            <p><strong>Program Pendidikan:</strong> <?= htmlspecialchars($data['program_pendidikan']) ?></p>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="../logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
</div>

</body>
</html>
