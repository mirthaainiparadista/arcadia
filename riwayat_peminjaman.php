<?php
include 'navbar.php';
require 'functions.php';
session_start();

// Pastikan pengguna sudah login sebagai peminjam
if (!isset($_SESSION['peminjam_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil riwayat peminjaman pengguna
$peminjam_id = $_SESSION['peminjam_id'];
$query = "SELECT * FROM peminjaman WHERE id_peminjam = $peminjam_id";
$result_peminjaman = mysqli_query($conn, $query);

?>

<div class="container mt-5">
    <h1>Riwayat Peminjaman</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Kode Peminjaman</th>
                <th>Tanggal Pesan</th>
                <th>Tanggal Ambil</th>
                <th>Tanggal Wajib Kembali</th>
                <th>Status Peminjaman</th>
                <th>Detail Buku</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row_peminjaman = mysqli_fetch_assoc($result_peminjaman)) : ?>
                <tr>
                    <td><?= $row_peminjaman['kode_pinjam']; ?></td>
                    <td><?= $row_peminjaman['tgl_pesan']; ?></td>
                    <td><?= $row_peminjaman['tgl_ambil']; ?></td>
                    <td><?= $row_peminjaman['tgl_wajibkembali']; ?></td>
                    <td><?= $row_peminjaman['status_pinjam']; ?></td>
                    <td>
                        <?php
                        // Ambil detail peminjaman berdasarkan kode_pinjam
                        $kode_pinjam = $row_peminjaman['kode_pinjam'];
                        $query_detail = "SELECT buku.judul_buku FROM detil_peminjaman JOIN buku ON detil_peminjaman.id_buku = buku.id_buku WHERE kode_pinjam = $kode_pinjam";
                        $result_detail = mysqli_query($conn, $query_detail);

                        // Tampilkan daftar buku dalam satu peminjaman
                        while ($row_detail = mysqli_fetch_assoc($result_detail)) {
                            echo $row_detail['judul_buku'] . "<br>";
                        }
                        ?>
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
