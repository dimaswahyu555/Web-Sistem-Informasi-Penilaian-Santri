<style>
    /* Warna latar sidebar */
    .sb-sidenav-dark {
        background-color: rgb(91, 138, 71) !important;
    }

    /* Warna teks menu dan heading */
    .sb-sidenav-dark .nav-link,
    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: #2D2D2D !important;
    }

    /* Warna ikon menu */
    .sb-sidenav-dark .sb-nav-link-icon i {
        color: rgb(255, 255, 255) !important;
    }

    /* Efek hover pada menu */
    .sb-sidenav-dark .nav-link:hover {
        background-color: rgb(0, 0, 0) !important;
        color: white !important;
    }

    /* Warna footer sidebar */
    .sb-sidenav-footer {
        background-color: rgb(91, 138, 71) !important;
        color: #2D2D2D !important;
    }
</style>

<!-- Layout wrapper -->
<div id="layoutSidenav">
    <!-- Sidebar -->
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Home</div>
                    <a class="nav-link" href="<?= $main_url ?>/santri/index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    <div class="sb-sidenav-menu-heading">Santri</div>
                    <a class="nav-link" href="<?= $main_url ?>/santri/profil.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                        Profil Saya
                    </a>

                    <a class="nav-link" href="<?= $main_url ?>/santri/raport.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                        Lihat Nilai
                    </a>

                    <a class="nav-link" href="<?= $main_url ?>/santri/jadwal.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-calendar-alt"></i></div>
                        Jadwal Pelajaran
                    </a>

                    <a class="nav-link" href="<?= $main_url ?>/santri/rekap_absen.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-check"></i></div>
                        Riwayat Absensi
                    </a>

                    <a class="nav-link" href="<?= $main_url ?>/admin/ganti_password.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-key"></i></div>
                        Ganti Password
                    </a>

                    <hr class="mb-0">

                    <a class="nav-link" href="<?= $main_url ?>/logout.php" onclick="return confirm('Yakin ingin logout?')">
                        <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                        Logout
                    </a>
                </div>
            </div>
        </nav>
    </div>