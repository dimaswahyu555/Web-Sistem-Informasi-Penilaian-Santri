<?php
// ====================== KONEKSI & QUERY SANTRI ======================
require_once "../config.php";


// Ambil data santri dari database
$santri_query = "SELECT id_santri, nama_santri FROM santri";
$santri_result = $conn->query($santri_query);

// ====================== HANDLE FORM SUBMIT ======================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_santri = $_POST['id_santri'];
    $mapel = $_POST['mapel'];
    $semester = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $nilai_tugas = $_POST['nilai_tugas'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];
    $nilai_hafalan = $_POST['nilai_hafalan'];

    // Query insert nilai ke database
    $insert_query = "INSERT INTO nilai (
        id_santri, mapel, semester, tahun_ajaran,
        nilai_tugas, nilai_uts, nilai_uas, nilai_hafalan
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param(
        "issssddd",
        $id_santri, $mapel, $semester, $tahun_ajaran,
        $nilai_tugas, $nilai_uts, $nilai_uas, $nilai_hafalan
    );

    if ($stmt->execute()) {
        // Berhasil: redirect kembali ke halaman tambah_nilai.php
        echo "<script>alert('Nilai berhasil ditambahkan!'); window.location.href = 'tambah-nilai.php';</script>";
    } else {
        // Gagal insert
        echo "<script>alert('Gagal menambahkan nilai!');</script>";
    }

    $stmt->close();
}

// ====================== LOAD TEMPLATE ======================
require_once "./template_guru/header.php";
require_once "./template_guru/navbar.php";
require_once "./template_guru/side-bar.php";
?>

<!-- ====================== TAMPILAN FORM ====================== -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 mb-4">Tambah Nilai Santri</h1>
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-plus"></i> Form Tambah Nilai Santri
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST">
                        <div class="row">
                            <!-- =================== KOLOM KIRI =================== -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="id_santri" class="form-label">Nama Santri</label>
                                    <select name="id_santri" id="id_santri" class="form-select rounded-pill" required>
                                        <option value="">-- Pilih Santri --</option>
                                        <?php while ($row = $santri_result->fetch_assoc()): ?>
                                            <option value="<?= $row['id_santri'] ?>"><?= htmlspecialchars($row['nama_santri']) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="mapel" class="form-label">Mata Pelajaran</label>
                                    <input type="text" name="mapel" id="mapel" class="form-control rounded-pill" required>
                                </div>
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <select name="semester" id="semester" class="form-select rounded-pill" required>
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control rounded-pill" required placeholder="2024/2025">
                                </div>
                            </div>

                            <!-- =================== KOLOM KANAN =================== -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nilai_tugas" class="form-label">Nilai Tugas</label>
                                    <input type="number" step="0.01" name="nilai_tugas" class="form-control rounded-pill" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nilai_uts" class="form-label">Nilai UTS</label>
                                    <input type="number" step="0.01" name="nilai_uts" class="form-control rounded-pill" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nilai_uas" class="form-label">Nilai UAS</label>
                                    <input type="number" step="0.01" name="nilai_uas" class="form-control rounded-pill" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nilai_hafalan" class="form-label">Nilai Hafalan</label>
                                    <input type="number" step="0.01" name="nilai_hafalan" class="form-control rounded-pill" required>
                                </div>
                            </div>
                        </div>

                        <!-- =================== TOMBOL =================== -->
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success rounded-pill px-4">Tambah Nilai</button>
                            <a href="data_nilai.php" class="btn btn-secondary rounded-pill px-4">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ====================== TUTUP KONEKSI ====================== -->
<?php $conn->close(); ?>
