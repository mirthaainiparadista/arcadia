<?php
require 'functions.php';
session_start();

// Pastikan pengguna sudah login sebagai admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui formulir
    $kode_pinjam = $_POST['kode_pinjam'];
    $status = $_POST['status'];

    // Update status peminjaman di database
    $query = "UPDATE peminjaman SET status_pinjam = '$status' WHERE kode_pinjam = $kode_pinjam";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect kembali ke halaman dashboard admin setelah berhasil mengubah status
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Jika terjadi kesalahan saat mengubah status, tampilkan pesan error
        echo "Error: " . mysqli_error($conn);
    }
}
?>
