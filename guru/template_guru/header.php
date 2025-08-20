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
        <title>Dashboard Guru - Ponpes Inayatullah</title>

        <!-- Link ke CSS menggunakan variabel base_url -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="<?= $base_url ?>css/styles.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>

        <!-- Link ke Font Awesome -->
       