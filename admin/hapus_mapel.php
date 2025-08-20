<?php
// Mulai sesi
session_start();
require_once "../config.php";

// Cek apakah user sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Jika belum login atau bukan admin, arahkan ke login
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}

// Ambil nilai ID dari parameter URL dan pastikan bertipe integer
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {
    // Cek apakah data dengan ID tersebut ada di database
    $cek = mysqli_query($conn, "SELECT * FROM matapelajaran WHERE id_matapelajaran = $id");

    if (mysqli_num_rows($cek) > 0) {
        // Jika data ditemukan, lakukan penghapusan
        $hapus = mysqli_query($conn, "DELETE FROM matapelajaran WHERE id_matapelajaran = $id");

        if ($hapus) {
            // ✅ Jika berhasil dihapus, tampilkan alert SweetAlert lalu redirect ke data_mapel.php
            echo "
            <!DOCTYPE html>
            <html lang='id'>
            <head>
                <meta charset='UTF-8'>
                <title>Berhasil</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Mata pelajaran berhasil dihapus!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = 'data_mapel.php';
                    });
                </script>
            </body>
            </html>";
            exit;
        } else {
            // ❌ Jika gagal dihapus karena error query, tampilkan pesan gagal
            echo "
            <!DOCTYPE html>
            <html lang='id'>
            <head>
                <meta charset='UTF-8'>
                <title>Gagal</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menghapus data!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = 'data_mapel.php';
                    });
                </script>
            </body>
            </html>";
            exit;
        }
    } else {
        // ⚠️ Jika data dengan ID tersebut tidak ditemukan
        echo "
        <!DOCTYPE html>
        <html lang='id'>
        <head>
            <meta charset='UTF-8'>
            <title>Tidak Ditemukan</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Tidak Ditemukan',
                    text: 'ID mata pelajaran tidak ditemukan.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'data_mapel.php';
                });
            </script>
        </body>
        </html>";
        exit;
    }
} else {
    // ⚠️ Jika ID tidak valid (misal kosong atau bukan angka)
    echo "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>ID Tidak Valid</title>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'ID tidak valid',
                text: 'Permintaan penghapusan tidak valid.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = 'data_mapel.php';
            });
        </script>
    </body>
    </html>";
    exit;
}
?>
