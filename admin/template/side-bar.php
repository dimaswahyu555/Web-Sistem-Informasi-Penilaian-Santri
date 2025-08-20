<style>
    /* Ubah warna sidebar menjadi hijau lembut */
    .sb-sidenav-dark {
        background-color: #5B8A47 !important; /* Hijau lembut */
    }

    /* Ubah warna teks agar tetap elegan */
    .sb-sidenav-dark .nav-link,
    .sb-sidenav-dark .sb-sidenav-menu-heading {
        color: #F5F5F5 !important; /* Warna putih lembut */
        font-weight: 500; /* Sedikit tebal untuk estetika */
    }

    /* Warna ikon dalam sidebar */
    .sb-sidenav-dark .sb-nav-link-icon i,
    .sb-sidenav-dark .sb-sidenav-menu-heading i {
        color: #FFD700 !important; /* Warna emas untuk ikon */
    }

    /* Hover efek untuk link */
    .sb-sidenav-dark .nav-link:hover {
        background-color: #3E6B2F !important; /* Hijau lebih gelap untuk hover */
        color: #FFD700 !important; /* Warna emas untuk teks saat hover */
    }

    /* Warna footer sidebar */
    .sb-sidenav-footer {
        background-color: #3E6B2F !important; /* Hijau lebih gelap */
        color: #F5F5F5 !important; /* Warna putih lembut */
        font-style: italic; /* Tambahkan gaya miring untuk estetika */
    }

    /* Tambahkan border halus untuk memisahkan elemen */
    .sb-sidenav-dark .nav-link {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Tambahkan efek transisi untuk hover */
    .sb-sidenav-dark .nav-link,
    .sb-sidenav-dark .nav-link:hover {
        transition: all 0.3s ease-in-out;
    }
</style>
</style>
         <!-- Side-bar-->
          
         <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Home</div>
                            <a class="nav-link" href="<?= $main_url?>/admin/index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <hr class="mb-0">
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link" href="<?= $main_url ?>/user/add-user.php">
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTambahUser" aria-expanded="false" aria-controls="collapseTambahUser">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                        Tambah Pengguna
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseTambahUser" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= $main_url ?>/admin/tambah_pengguna.php">
                                 <div class="sb-nav-link-icon"><i class="fa-solid fa-user-plus"></i></div>
                                 Tambah users</a>
                            <a class="nav-link" href="<?= $main_url ?>/admin/jadwal_pelajaran.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
                                Tambah Jadwal Pelajaran</a>
                            <a class="nav-link" href="<?= $main_url ?>/admin/tambah_mapel.php">
                                 <div class="sb-nav-link-icon"><i class="fa-solid fa-book-open-reader"></i></div>
                                Tambah Mata Pelajaran</a>
                            <a class="nav-link" href="<?= $main_url ?>/admin/tambah_guru.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                Tambah Guru</a>

                            <a class="nav-link" href="<?= $main_url ?>/admin/tambah_santri.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Tambah Santri</a>

                        </nav>
                    </div>
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/admin/ganti_password.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-key"></i></div>
                                ganti password
                            </a>
                            <hr class="mb-0">
                            <div class="sb-sidenav-menu-heading">Data Pengguna
                            <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dataDropdown">
                            </ul>
                            </div>

                            <a class="nav-link" href="<?= $main_url?>/admin/data_santri.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                                Data Santri
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/admin/data_guru.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></div>
                                Data Guru
                            </a>
                            <a class="nav-link" href="<?= $main_url?>/admin/data_mapel.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-book"></i></div>
                                Data Matapelajaran
                            </a>
                            <hr class="mb-0">
                        </div>
                    </div>
                </nav>
            </div>
            