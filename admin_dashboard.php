<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dashboard Admin</title>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ARCADIA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
      </ul>
      <span class="navbar-text">
        <button type="button" class="btn btn-success"><a href="logout.php" style="color: white;">Logout</a></button>
      </span>
    </div>
  </div>
</nav>

<?php
require 'functions.php';
session_start();

// Pastikan pengguna sudah login sebagai admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil semua pemesanan
$query_pemesanan = "SELECT * FROM peminjaman";
$result_pemesanan = mysqli_query($conn, $query_pemesanan);

?>

<div class="container mt-5">
    <h1>DASHBOARD ADMIN</h1>
    <h2>Semua Pemesanan</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Peminjaman</th>
                <th>Tanggal Pesan</th>
                <th>Tanggal Ambil</th>
                <th>Tanggal Wajib Kembali</th>
                <th>Status Peminjaman</th>
                <th>Detail</th>
                <th>Ubah Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_pemesanan = mysqli_fetch_assoc($result_pemesanan)) : ?>
                <tr>
                    <td><?= $row_pemesanan['kode_pinjam']; ?></td>
                    <td><?= $row_pemesanan['tgl_pesan']; ?></td>
                    <td><?= $row_pemesanan['tgl_ambil']; ?></td>
                    <td><?= $row_pemesanan['tgl_wajibkembali']; ?></td>
                    <td>
                        <?php 
                        // Tampilkan status saat ini
                        if ($row_pemesanan['status_pinjam'] == 'P') {
                            echo 'Diproses';
                        } elseif ($row_pemesanan['status_pinjam'] == 'D') {
                            echo 'Disetujui';
                        } elseif ($row_pemesanan['status_pinjam'] == 'T') {
                            echo 'Ditolak';
                        } else {
                            echo 'Status tidak valid';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="detail_peminjaman.php?kode=<?= $row_pemesanan['kode_pinjam']; ?>" class="btn btn-primary">Detail</a>
                    </td>
                    <td>
                        <form action="ubah_status.php" method="post">
                            <input type="hidden" name="kode_pinjam" value="<?= $row_pemesanan['kode_pinjam']; ?>">
                            <select name="status">
                                <option value="P" <?php if($row_pemesanan['status_pinjam'] == 'P') echo 'selected'; ?>>Diproses</option>
                                <option value="D" <?php if($row_pemesanan['status_pinjam'] == 'D') echo 'selected'; ?>>Disetujui</option>
                                <option value="T" <?php if($row_pemesanan['status_pinjam'] == 'T') echo 'selected'; ?>>Ditolak</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Ubah Status</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js
