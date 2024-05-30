<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<!-- Membuat template navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ARCADIA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="homepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="keranjang_buku.php">Keranjang Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
        </li>
      </ul>
      <span class="navbar-text">
      <button type="button" class="btn btn-success"><a href="logout.php" style="color: white;">Logout</a></button>
      </span>
    </div>
  </div>
</nav>
