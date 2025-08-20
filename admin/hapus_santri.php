<?php
// Include konfigurasi database
require $_SERVER['DOCUMENT_ROOT'] . '/ppinayatullah2/config.php';

// Pastikan parameter 'nama' ada di URL
if (isset($_GET['nama'])) {
    $nama = $_GET['nama'];

    // Jalankan query DELETE untuk menghapus santri berdasarkan nama
    $query = "DELETE FROM santri WHERE nama = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama);

    // Eksekusi query dan cek apakah berhasil
    if ($stmt->execute()) {
        echo "<script>
            alert('Data santri dengan nama \"$nama\" berhasil dihapus!');
            window.location.href = 'data_santri.php'; // Redirect ke data_santri.php setelah penghapusan
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data santri.');
            window.location.href = 'data_santri.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "<script>
        alert('Nama santri tidak ditemukan.');
        window.location.href = 'data_santri.php';
    </script>";
}

$conn->close();
?>
