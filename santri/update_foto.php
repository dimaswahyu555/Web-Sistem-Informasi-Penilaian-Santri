<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "Akses ditolak.";
    exit;
}

$id_santri = $_SESSION['id_santri'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $file_name = $_FILES['foto']['name'];
    $file_tmp = $_FILES['foto']['tmp_name'];
    $file_size = $_FILES['foto']['size'];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo "Format tidak valid (hanya jpg, png, gif).";
        exit;
    }
    if ($file_size > 2 * 1024 * 1024) {
        echo "Ukuran maksimal 2MB.";
        exit;
    }

    // Pastikan folder image/ ada
    if (!is_dir("../image")) {
        mkdir("../image", 0777, true);
    }

    $new_name = "santri_" . $id_santri . "_" . time() . "." . $ext;
    $upload_path = "../image/$new_name";

    if (move_uploaded_file($file_tmp, $upload_path)) {
        // Hapus foto lama jika ada dan bukan default
        $q_old = mysqli_query($conn, "SELECT foto FROM santri WHERE id_santri='$id_santri'");
        $d_old = mysqli_fetch_assoc($q_old);
        $foto_lama = $d_old['foto'];
        if ($foto_lama && $foto_lama !== 'default.png' && file_exists("../image/$foto_lama")) {
            unlink("../image/$foto_lama");
        }

        // Update nama file di database
        $q = mysqli_query($conn, "UPDATE santri SET foto='$new_name' WHERE id_santri='$id_santri'");
        echo $q ? "Foto berhasil diupdate." : "Gagal menyimpan ke database.";
    } else {
        echo "Gagal upload foto.";
    }
} else {
    echo "Tidak ada file dikirim.";
}
?>
