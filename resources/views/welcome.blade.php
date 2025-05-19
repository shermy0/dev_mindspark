@extends('navbar')

@section('konten')
<!DOCTYPE html>
<html lang="en">
<body class="index-page">

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div class="company-badge mb-4">
                <i class="bi bi-gear-fill me-2"></i>
                Bekerja untuk kesuksesan anda
              </div>

              <h1 class="mb-4">
                Selamat Datang di <br>
                <span class="accent-text">MindSpark</span>
              </h1>

              <p class="mb-4 mb-md-5">
                Jelajahi koleksi buku, jurnal, dan artikel dari berbagai bidang sains.
              </p>

              <div class="hero-buttons">
              @auth
                  <a href="{{ route('kategori') }}" class="btn btn-primary me-0 me-sm-2 mx-1">Mulai</a>
              @else
                  <a href="{{ route('login') }}" class="btn btn-primary me-0 me-sm-2 mx-1">Mulai</a>
              @endauth
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn btn-link mt-2 mt-sm-0 glightbox">
                  <i class="bi bi-play-circle me-1"></i>
                  Putar Video
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="assets/img/book-hero.png" alt="Hero Image" class="img-fluid">

            </div>
          </div>
        </div>

        <div class="row stats-row gy-4 mt-5" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-journal-richtext"></i>
              </div>
              <div class="stat-content">
                <h4>{{ $bookCount }}+</h4>
                <p class="mb-0">Buku Tersedia</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-collection"></i>
              </div>
              <div class="stat-content">
                <h4>{{ $categoriesCount }}+</h4>
                <p class="mb-0">Jumlah Kategori</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-award"></i>
              </div>
              <div class="stat-content">
                <h4>{{ $reviewCount }}+</h4>
                <p class="mb-0">Jumlah Ulasan dan Rating</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="bi bi-people"></i>
              </div>
              <div class="stat-content">
                <h4>{{ $userCount }}+</h4>
                <p class="mb-0">Jumlah Pengguna</p>
              </div>
            </div>
          </div>
        </div>
      </div><br>

      <h2 class="text-center mb-4">Preview Buku Terpopuler</h2>
        <div class="row">

        </div>

    </section>
 </main>

 <footer class="custom-footer">
    <div>
        <p class="footer-text">
            &copy; {{ date('Y') }} MindSpark. All rights reserved.
        </p>
        <div class="footer-social">
            <a href="#" class="footer-link"><i class="bi bi-facebook"></i></a>
            <a href="#" class="footer-link"><i class="bi bi-twitter"></i></a>
            <a href="#" class="footer-link"><i class="bi bi-instagram"></i></a>
            <a href="#" class="footer-link"><i class="bi bi-linkedin"></i></a>
        </div>
    </div>
</footer>

</body>
</html>
@endsection