<?php
// Include file koneksi ke database
require 'functions.php';
session_start();

// Pastikan pengguna sudah login sebagai admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Pastikan request datang dari metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data kode_pinjam dan id_buku dari formulir
    $kode_pinjam = $_POST['kode_pinjam'];
    $id_buku = $_POST['id_buku'];

    // Query untuk menghapus data buku dari tabel detil_peminjaman
    $query_hapus = "DELETE FROM detil_peminjaman WHERE kode_pinjam = '$kode_pinjam' AND id_buku = '$id_buku'";
    
    // Jalankan query
    if (mysqli_query($conn, $query_hapus)) {
        // Jika penghapusan berhasil, redirect kembali ke halaman detail_peminjaman.php
        header("Location: detail_peminjaman.php?kode=$kode_pinjam");
        exit;
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika request bukan dari metode POST, redirect ke halaman yang sesuai
    header("Location: admin_dashboard.php");
    exit;
}
?>
