<?php
//load config.php
include("config/config.php");
 
//untuk api_key newsapi.org
$api_key="f7f7da1096974592838d7fb60bcdfe0f";
 
//url api untuk ambil berita headline
$url="https://newsapi.org/v2/top-headlines?country=us&category=technology&apiKey=".$api_key;
 
//menyimpan hasil dalam variabel
$data=http_request_get($url);
 
//konversi data json ke array
$hasil=json_decode($data,true);
 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rest Client dengan cURL</title>
    <!-- CSS Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="#">RestClient</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">About</a>
      </li>
    </ul>
  </div>
</nav>
<!-- End Navbar -->

<div class="container" style="margin-top: 80px;">
    <h2 class="mb-4">Rest API dengan PHP</h2>
    <div class="row">

    <!-- Pengecekan apakah data artikel tersedia -->
    <?php if (isset($hasil['articles']) && !empty($hasil['articles'])) : ?>
        
        <?php foreach ($hasil['articles'] as $row) : ?>
            <div class="col-md-3 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    <!-- Gunakan fallback gambar jika gambar dari API bernilai null -->
                    <img src="<?= !empty($row['urlToImage']) ? $row['urlToImage'] : 'https://via.placeholder.com/250x150?text=No+Image' ?>" class="card-img-top" style="height: 160px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <p class="card-text flex-grow-1" style="font-size: 14px;">
                            <i>Oleh <?= htmlspecialchars($row['author'] ?? 'Anonim'); ?></i> ~ <?= htmlspecialchars($row['title'] ?? 'Tanpa Judul'); ?>
                        </p>
                        <!-- Tautan langsung mengarah ke URL berita ($row['url']) -->
                        <a href="<?= $row['url']; ?>" target="_blank" class="btn btn-primary btn-sm mt-auto">Selengkapnya..</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else : ?>
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                Gagal mengambil data dari API. Pastikan API Key valid atau kuota request belum habis.
            </div>
        </div>
    <?php endif; ?>

    </div>
</div>

<!-- JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>