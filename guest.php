<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pondok Inayatullah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-brand img {
      height: 30px;
    }
    .hero {
      background-color: #f8f9fa;
      padding: 80px 20px;
      text-align: center;
    }
    .hero h1 {
      font-weight: bold;
    }
    .highlight {
      color: #198754;
    }
    .card-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 5px 10px;
      color: white;
      border-radius: 5px;
    }
    .card-badge.terjual {
      background-color: red;
    }
    .card-badge.tersedia {
      background-color: green;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="image/logo.png" alt="Logo Ponpes">
      Pondok Pesantren Inayatullah
    </a>
    <div>
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="https://inay.asadth95.web.id/profil/visi-misi/">Visi Dan Misi</a></li>
        <li class="nav-item"><a class="nav-link" href="https://inay.asadth95.web.id/profil/kurikulum/">Kurikulum</a></li>
        <li class="nav-item"><a class="nav-link" href="https://inay.asadth95.web.id/hubungi-kami/kontak/">Kontak</a></li>
      </ul>
    </div>
    <div>
      <a href="login.php" class="btn btn-success me-2">Login</a>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero">
  <div class="container">
    <h1>Pesantren <span class="highlight">Berkualitas</span> dan <span class="highlight">Terjangkau</span></h1>
    <p>Hadiri pendidikan Islam terbaik dengan fasilitas lengkap dan tenaga pendidik berpengalaman.</p>
    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeoOwL7C4nD215qk7ZpNzEGADYo_Kck0HN0gMrRek3nyMlrFA/viewform" class="btn btn-outline-success">Daftar Sekarang</a>
  </div>
</section>

<!-- Section Rumah/Kegiatan Terbaru -->
<section class="py-5">
  <div class="container">
    <h3 class="mb-4">Kegiatan<span class="highlight">Terbaru</span></h3>
    <div class="row g-4">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="card position-relative">
          <img src="image/dokumen1.jpg" class="card-img-top" alt="dokumen 1">
          <div class="card-badge terjual">Selesai</div>
          <div class="card-body">
            <h5 class="card-title">Ujian Hafalan</h5>
            <p class="card-text">Program rutin malam hari bersama Ustadz Abdul Wahid.</p>
          </div>
        </div>
      </div>
      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="card position-relative">
           <img src="image/dokumen2.jpg" alt="acara selapanan">
          <div class="card-badge terjual">Selesai</div>
          <div class="card-body">
            <h5 class="card-title">Acara PraSelapanan</h5>
            <p class="card-text">Selapanan wali santri merupakan kegiatan rutinan yang dilakukan setiap Ahad manis. Adapun kegiatannya yaitu istighosah dan pengajian wali santri,</p>
          </div>
        </div>
      </div>
      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="card position-relative">
          <img src="image/dokumen3.jpg" class="card-img-top" alt="Kegiatan 3">
          <div class="card-badge tersedia">Aktif</div>
          <div class="card-body">
            <h5 class="card-title">Ujian Tertulis</h5>
            <p class="card-text">Ujian tertulis pada pondok pesantren yang dilakukan merupakan bagian penting dalam evaluasi akademik dan pembelajaran. Ujian ini digunakan untuk mengukur pemahaman santri terhadap materi pelajaran yang telah diajarkan</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>
