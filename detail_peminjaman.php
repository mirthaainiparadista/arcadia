<?php
include 'navbar.php';
require 'functions.php';
session_start();

// Pastikan pengguna sudah login sebagai admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil kode peminjaman dari parameter URL
if (!isset($_GET['kode']) || empty($_GET['kode'])) {
    header("Location: admin_dashboard.php");
    exit;
}
$kode_pinjam = $_GET['kode'];

// Query untuk mendapatkan informasi pemesanan dan list buku yang dipinjam
$query_pemesanan = "SELECT * FROM peminjaman WHERE kode_pinjam = $kode_pinjam";
$result_pemesanan = mysqli_query($conn, $query_pemesanan);
$row_pemesanan = mysqli_fetch_assoc($result_pemesanan);

$query_detail = "SELECT buku.id_buku, buku.judul_buku, buku.tgl_terbit, buku.nama_pengarang, buku.nama_penerbit FROM detil_peminjaman JOIN buku ON detil_peminjaman.id_buku = buku.id_buku WHERE kode_pinjam = $kode_pinjam";
$result_detail = mysqli_query($conn, $query_detail);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Detail Pemesanan</title>
</head>
<body>
<div class="container mt-5">
    <h1>Detail Pemesanan</h1>
    <h2>Informasi Pemesanan</h2>
    <p>Kode Peminjaman: <?= $row_pemesanan['kode_pinjam']; ?></p>
    <p>Tanggal Pesan: <?= $row_pemesanan['tgl_pesan']; ?></p>
    <p>Tanggal Ambil: <?= $row_pemesanan['tgl_ambil']; ?></p>
    <p>Tanggal Wajib Kembali: <?= $row_pemesanan['tgl_wajibkembali']; ?></p>
    
    <h2>List Buku yang Dipinjam</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Buku</th>
                <th>Judul Buku</th>
                <th>Tanggal Terbit</th>
                <th>Nama Pengarang</th>
                <th>Nama Penerbit</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_detail = mysqli_fetch_assoc($result_detail)) : ?>
                <tr>
                    <td><?= $row_detail['id_buku']; ?></td>
                    <td><?= $row_detail['judul_buku']; ?></td>
                    <td><?= $row_detail['tgl_terbit']; ?></td>
                    <td><?= $row_detail['nama_pengarang']; ?></td>
                    <td><?= $row_detail['nama_penerbit']; ?></td>
                    <td>
                        <form action="hapus_buku.php" method="post">
                            <input type="hidden" name="kode_pinjam" value="<?= $row_pemesanan['kode_pinjam']; ?>">
                            <input type="hidden" name="id_buku" value="<?= $row_detail['id_buku']; ?>">
                            <button type="submit" class="btn btn-danger">Hapus</button>
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
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
