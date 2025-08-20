<?php
// Konfigurasi koneksi ke database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'ponpes';

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil data dari form (dengan validasi array key)
$nama_santri        = mysqli_real_escape_string($conn, $_POST['nama_santri'] ?? '');
$nisn               = mysqli_real_escape_string($conn, $_POST['nisn'] ?? '');
$tanggal_lahir      = mysqli_real_escape_string($conn, $_POST['tanggal_lahir'] ?? '');
$jenis_kelamin      = $_POST['jenis_kelamin'] ?? '';
$alamat             = mysqli_real_escape_string($conn, $_POST['alamat'] ?? '');
$no_telepon_wali    = mysqli_real_escape_string($conn, $_POST['no_hp'] ?? ''); // disesuaikan dengan name="no_hp"
$nama_wali_santri   = mysqli_real_escape_string($conn, $_POST['nama_wali_santri'] ?? '');
$kelas              = mysqli_real_escape_string($conn, $_POST['kelas'] ?? '');
$program_pendidikan = mysqli_real_escape_string($conn, $_POST['program_pendidikan'] ?? '');

// Validasi jenis kelamin
if (!in_array($jenis_kelamin, ['Laki-laki', 'Perempuan'])) {
    $jenis_kelamin = 'Laki-laki'; // default fallback
}

// Validasi tanggal lahir
$tanggal_lahir = !empty($tanggal_lahir) ? date('Y-m-d', strtotime($tanggal_lahir)) : null;

// Proses upload foto
$foto_nama = $_FILES['image']['name'] ?? '';
$foto_tmp  = $_FILES['image']['tmp_name'] ?? '';
$allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
$foto_dir = "../assets/image/" . $foto_nama;

if (!empty($foto_tmp) && in_array($_FILES['image']['type'], $allowed_types)) {
    move_uploaded_file($foto_tmp, $foto_dir);
} else {
    $foto_nama = "default-user.png"; // fallback default image
}

// Query tambah santri
$query = "INSERT INTO santri (
    nama_santri, nisn, tanggal_lahir, jenis_kelamin, alamat, no_telepon_wali,
    nama_wali_santri, kelas, program_pendidikan, status_santri, foto, tanggal_daftar
) VALUES (
    '$nama_santri', '$nisn', " . ($tanggal_lahir ? "'$tanggal_lahir'" : "NULL") . ",
    '$jenis_kelamin', '$alamat', '$no_telepon_wali', '$nama_wali_santri',
    '$kelas', '$program_pendidikan', 'Aktif', '$foto_nama', NOW()
)";

// Eksekusi query
if (mysqli_query($conn, $query)) {
    header("Location: ../tambah_santri.php?status=success");
} else {
    echo "Gagal menambahkan data santri. Error: " . mysqli_error($conn);
}

mysqli_close($conn);
exit();
?>
