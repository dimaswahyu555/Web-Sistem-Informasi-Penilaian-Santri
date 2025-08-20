<?php
session_start();
require '../config.php';
require '../vendor/autoload.php'; // autoload dari composer

use Dompdf\Dompdf;

if (!isset($_SESSION['id_santri'])) {
    echo "Unauthorized";
    exit;
}

$id_santri = $_SESSION['id_santri'];

// Data santri
$santri = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM santri WHERE id_santri = '$id_santri'"));

// Data nilai
$nilai = mysqli_query($conn, "
    SELECT n.*, m.nama_matapelajaran
    FROM nilai n
    JOIN matapelajaran m ON n.id_matapelajaran = m.id_matapelajaran
    WHERE n.id_santri = '$id_santri'
    ORDER BY n.tahun_ajaran DESC, n.semester DESC
");

// HTML untuk PDF
$html = '
<h2 style="text-align:center;">Raport Santri</h2>
<p><strong>Nama:</strong> '.$santri['nama_santri'].'<br>
<strong>NISN:</strong> '.$santri['nisn'].'</p>

<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead>
        <tr style="background:#ccc;">
            <th>No</th>
            <th>Mata Pelajaran</th>
            <th>Semester</th>
            <th>Tahun Ajaran</th>
            <th>Tugas</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>Hafalan</th>
            <th>Nilai Akhir</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>';
$no = 1;
while ($row = mysqli_fetch_assoc($nilai)) {
    $html .= "<tr>
        <td>{$no}</td>
        <td>{$row['nama_matapelajaran']}</td>
        <td>{$row['semester']}</td>
        <td>{$row['tahun_ajaran']}</td>
        <td>{$row['nilai_tugas']}</td>
        <td>{$row['nilai_uts']}</td>
        <td>{$row['nilai_uas']}</td>
        <td>{$row['nilai_hafalan']}</td>
        <td>{$row['nilai_akhir']}</td>
        <td>{$row['keterangan']}</td>
    </tr>";
    $no++;
}
$html .= '</tbody></table>';

// Inisialisasi dan render PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("raport_{$santri['nisn']}.pdf", array("Attachment" => true));
exit;
