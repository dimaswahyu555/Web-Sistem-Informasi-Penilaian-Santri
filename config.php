<?php 
$main_url = "http://localhost/ppinayatullah2";

// Konfigurasi Database
$host = 'localhost';
$user = 'root'; // atau sesuaikan dengan user database Anda
$password = ''; // kosong jika tanpa password
$dbname = 'ponpes'; // nama database yang digunakan

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
