<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: http://localhost/ppinayatullah2/login.php");
    exit;
}

require_once "../../config.php";
$redirect_url = "http://localhost/ppinayatullah2/guru/tambah_absensi.php";

$id_guru          = $_SESSION['id_guru'] ?? '';
$id_matapelajaran = $_POST['id_matapelajaran'] ?? '';
$tanggal          = $_POST['tanggal'] ?? '';
$jam_ke           = $_POST['jam_ke'] ?? '';
$kelas            = $_POST['kelas'] ?? '';
$absensi_data     = $_POST['absensi'] ?? [];

// Validasi input
if (empty($id_guru) || empty($id_matapelajaran) || empty($tanggal) || empty($jam_ke) || empty($absensi_data)) {
    $msg = urlencode("Mohon lengkapi semua data yang diperlukan.");
    header("Location: $redirect_url?kelas=$kelas&msg=$msg");
    exit;
}

$sukses = 0;
$gagal = 0;

foreach ($absensi_data as $id_santri => $status_kehadiran) {
    $id_santri = mysqli_real_escape_string($conn, $id_santri);
    $status_kehadiran = mysqli_real_escape_string($conn, $status_kehadiran);

    // Cek apakah data absensi sudah ada sebelumnya
    $cek = mysqli_query($conn, "SELECT id_absensi FROM absensi WHERE id_santri='$id_santri' AND id_matapelajaran='$id_matapelajaran' AND tanggal='$tanggal' AND jam_ke='$jam_ke'");
    if (mysqli_num_rows($cek) > 0) {
        $gagal++;
        continue;
    }

    // Simpan data absensi baru
    $query = "INSERT INTO absensi (id_santri, id_guru, id_matapelajaran, tanggal, status_kehadiran, jam_ke)
              VALUES ('$id_santri', '$id_guru', '$id_matapelajaran', '$tanggal', '$status_kehadiran', '$jam_ke')";

    if (mysqli_query($conn, $query)) {
        $sukses++;
    } else {
        $gagal++;
    }
}

// Buat pesan notifikasi
if ($gagal > 0 && $sukses == 0) {
    $msg = urlencode("Gagal menyimpan semua absensi. Periksa kembali data.");
} elseif ($gagal > 0 && $sukses > 0) {
    $msg = urlencode("Sebagian absensi berhasil disimpan ($sukses berhasil, $gagal gagal).");
} else {
    $msg = urlencode("Absensi berhasil disimpan ($sukses data).");
}

// Redirect kembali ke halaman form absensi dengan notifikasi
header("Location: $redirect_url?kelas=$kelas&msg=$msg");
exit;
