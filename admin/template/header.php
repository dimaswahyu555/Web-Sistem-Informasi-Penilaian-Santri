<?php
    // Mengatur path dasar untuk folder 'sbadmin' secara fleksibel
    $base_url = '../sbadmin/'; // Path relatif menuju folder 'sbadmin'
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard Admin - Ponpes Inayatullah</title>

        <!-- Tambahkan favicon -->
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
            <!-- Jika kamu punya versi PNG juga -->
            <link rel="icon" href="/favicon.png" type="image/png" />


        <!-- Link ke CSS menggunakan variabel base_url -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="<?= $base_url ?>css/styles.css" rel="stylesheet" />

        <!-- Link ke Font Awesome -->
        <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
