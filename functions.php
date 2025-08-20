<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ponpes";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CRUD Functions
// --- CREATE ---
function createSantri($conn, $data) {
    $sql = "INSERT INTO santri (nama_santri, tanggal_lahir, alamat, jenis_kelamin, no_telepon_wali, nama_wali_santri, kelas, program_pendidikan, tanggal_daftar) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", ...$data);
    $stmt->execute();
}

function createGuru($conn, $data) {
    $sql = "INSERT INTO guru (nama_guru, nip, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, email, mata_pelajaran, pendidikan_terakhir, status_aktif, tanggal_bergabung) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", ...$data);
    $stmt->execute();
}

// --- READ ---
function readSantri($conn) {
    $sql = "SELECT * FROM santri";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row) . "\n";
    }
}

function readGuru($conn) {
    $sql = "SELECT * FROM guru";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        echo json_encode($row) . "\n";
    }
}

// --- UPDATE ---
function updateSantri($conn, $data) {
    $sql = "UPDATE santri SET nama_santri = ?, tanggal_lahir = ?, alamat = ?, jenis_kelamin = ?, no_telepon_wali = ?, nama_wali_santri = ?, kelas = ?, program_pendidikan = ?, tanggal_daftar = ? WHERE id_santri = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", ...$data);
    $stmt->execute();
}

function updateGuru($conn, $data) {
    $sql = "UPDATE guru SET nama_guru = ?, nip = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, alamat = ?, no_hp = ?, email = ?, mata_pelajaran = ?, pendidikan_terakhir = ?, status_aktif = ?, tanggal_bergabung = ? WHERE id_guru = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssi", ...$data);
    $stmt->execute();
}

// --- DELETE ---
function deleteSantri($conn, $id_santri) {
    $sql = "DELETE FROM santri WHERE id_santri = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_santri);
    $stmt->execute();
}

function deleteGuru($conn, $id_guru) {
    $sql = "DELETE FROM guru WHERE id_guru = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_guru);
    $stmt->execute();
}

// Example Usage
echo "=== CREATE ===\n";
$newSantri = ["Ahmad Zakaria", "2008-05-20", "Jl. Merapi No. 5", "Laki-laki", "0812345678", "H. Zakaria", "10", "SMP", "2021-06-15"];
createSantri($conn, $newSantri);

$newGuru = ["Ustadz Arif", "123456", "Yogyakarta", "1980-05-12", "Laki-laki", "Jl. Malioboro No. 10", "081234567890", "arif@gmail.com", "Matematika", "S1 Pendidikan", "Aktif", "2015-01-10"];
createGuru($conn, $newGuru);

echo "=== READ ===\n";
readSantri($conn);
readGuru($conn);

echo "=== UPDATE ===\n";
$updateSantri = ["Muhammad Zaki", "2009-06-01", "Jl. Kaliurang", "Laki-laki", "08121234567", "Bapak Zaki", "11", "SMA", "2022-07-10", 1];
updateSantri($conn, $updateSantri);

$updateGuru = ["Ustadz Arif Hidayat", "123457", "Yogyakarta", "1980-04-01", "Laki-laki", "Jl. Merapi No. 3", "081234567891", "arif.hidayat@gmail.com", "Fisika", "S2 Pendidikan", "Aktif", "2016-02-10", 1];
updateGuru($conn, $updateGuru);

echo "=== DELETE ===\n";
deleteSantri($conn, 2); // Menghapus santri dengan id_santri = 2
deleteGuru($conn, 2);   // Menghapus guru dengan id_guru = 2

$conn->close();
?>
