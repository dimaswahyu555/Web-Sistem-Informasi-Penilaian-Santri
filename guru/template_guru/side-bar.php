<style>
    /* Ubah warna sidebar menjadi emas pucat */
    .sb-sidenav-dark {
        background-color:rgb(91, 138, 71) !important; /* Warna emas pucat */
    }

    /* Ubah warna teks agar tetap terbaca dengan baik */
    .sb-sidenav-dark .nav-link,
    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: #2D2D2D !important; /* Warna teks gelap agar kontras */
    }

    /* Warna ikon dalam sidebar */
    .sb-sidenav-dark .sb-nav-link-icon i {
        color:rgb(255, 255, 255) !important; /* Warna ikon lebih gelap */
    }

    /* Hover efek untuk link */
    .sb-sidenav-dark .nav-link:hover {
        background-color: rgb(0, 0, 0) !important; /* Warna hover sedikit lebih gelap */
        color: white !important;
    }

    /* Warna footer sidebar */
    .sb-sidenav-footer {
        background-color:  rgb(91, 138, 71)!important; /* Warna footer */
        color: #2D2D2D !important;
    }
</style>
         <!-- Side-bar-->
          
         <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Home</div>
                            <a class="nav-link" href="<?= $main_url?>/guru/index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard Guru
                            </a>
                            <hr class="mb-0">
                            <div class="sb-sidenav-menu-heading">Guru</div>
                            <a class="nav-link" href="<?= $main_url ?>/user/add-user.php">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTambahUser" aria-expanded="false" aria-controls="collapseTambahUser">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user-plus"></i></div>
                        Aktivitas
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseTambahUser" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion"> 
                         <nav class="sb-sidenav-menu-nested nav">
                          <a class="nav-link" href="<?= $main_url ?>/guru/tambah_absensi.php">Input Absensi</a>
                              <a class="nav-link" href="<?= $main_url ?>/guru/tambah-nilai.php">Input Nilai</a>
                             </nav>
                            </div>
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/admin/ganti_password.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
                                Ganti Password
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/guru/jadwal_mengajar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                Jadwal Mengajar
                            </a>
                            </a>
                            <hr class="mb-0">
                            <div class="sb-sidenav-menu-heading">Data Santri
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dataDropdown">
                            </ul>
                            </div>

                            <a class="nav-link" href="<?= $main_url?>/guru/data_santri.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Data Santri
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/guru/data_nilai.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                Data Nilai
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/guru/data_absensi.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-user-graduate"></i></div>
                                Absensi Santri
                            </a>
                            <hr class="mb-0">
                        </div>
                    </div>
                </nav>
            </div>
            