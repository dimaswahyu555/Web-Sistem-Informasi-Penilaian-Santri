<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$user = 'root';  // Sesuaikan dengan username database
$password = '';   // Masukkan password jika ada
$dbname = 'ponpes';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Mengambil data dari form dengan validasi untuk mencegah error undefined array key
$nama_guru          = mysqli_real_escape_string($conn, $_POST['nama_guru'] ?? '');
$nip                = mysqli_real_escape_string($conn, $_POST['nip'] ?? '');
$tempat_lahir       = mysqli_real_escape_string($conn, $_POST['tempat_lahir'] ?? '');
$tanggal_lahir      = mysqli_real_escape_string($conn, $_POST['tanggal_lahir'] ?? '');
$jenis_kelamin      = $_POST['jenis_kelamin'] ?? '';
$alamat             = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');
$no_hp              = mysqli_real_escape_string($conn, $_POST['no_hp'] ?? '');
$email              = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$mata_pelajaran     = mysqli_real_escape_string($conn, $_POST['mata_pelajaran'] ?? '');
$pendidikan_terakhir = mysqli_real_escape_string($conn, $_POST['pendidikan_terakhir'] ?? '');
$status_aktif       = $_POST['status_aktif'] ?? 'Aktif'; // Default ke 'Aktif'

// Validasi jenis kelamin agar sesuai dengan ENUM di database ('Laki-laki' atau 'Perempuan')
if (!in_array($jenis_kelamin, ['Laki-laki', 'Perempuan'])) {
    $jenis_kelamin = 'Laki-laki';  // Default ke 'Laki-laki' jika input tidak valid
}

// Validasi Tanggal Lahir (jika kosong, gunakan NULL)
if (empty($tanggal_lahir)) {
    $tanggal_lahir = null;
} else {
    $tanggal_lahir = date('Y-m-d', strtotime($tanggal_lahir)); // Format valid
}

// Query untuk menambahkan data ke tabel guru
$query = "INSERT INTO guru (nama_guru, nip, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, 
                            email, mata_pelajaran, pendidikan_terakhir, status_aktif)
          VALUES ('$nama_guru', '$nip', '$tempat_lahir', " . ($tanggal_lahir ? "'$tanggal_lahir'" : "NULL") . ", 
                  '$jenis_kelamin', '$alamat', '$no_hp', '$email', '$mata_pelajaran', 
                  '$pendidikan_terakhir', '$status_aktif')";

if (mysqli_query($conn, $query)) {
    // Redirect ke halaman tambah guru dengan status sukses
    header("Location: ../tambah_guru.php?status=success");
    exit;
} else {
    // Redirect dengan pesan error
    header("Location: ../tambah_guru.php?status=error&message=" . mysqli_error($conn));
    exit;
}
?>
