<?php
include 'navbar.php';
require 'functions.php';
session_start();

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Menghapus buku dari keranjang
if (isset($_POST['hapus_buku'])) {
    $id_buku = $_POST['id_buku'];
    if (($key = array_search($id_buku, $_SESSION['keranjang'])) !== false) {
        unset($_SESSION['keranjang'][$key]);
    }
}

// Mengambil data buku yang ada di keranjang
$keranjang = $_SESSION['keranjang'];
$buku_keranjang = [];
if (!empty($keranjang)) {
    $id_buku_list = implode(',', $keranjang);
    $buku_keranjang = query("SELECT * FROM buku WHERE id_buku IN ($id_buku_list)");
}

// Proses form peminjaman
if (isset($_POST['submit_peminjaman'])) {
    $id_admin = 1; // Misalkan id_admin adalah 1, bisa diambil dari session atau input lainnya
    $id_peminjam = $_SESSION['peminjam_id'];
    $tgl_pesan = date('Y-m-d');
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_wajibkembali = $_POST['tgl_wajibkembali'];
    $status_pinjam = 'P'; // Status P untuk Diproses

    // Insert data peminjaman ke tabel peminjaman
    $query_peminjaman = "INSERT INTO peminjaman (id_admin, id_peminjam, tgl_pesan, tgl_ambil, tgl_wajibkembali, status_pinjam) 
                         VALUES ('$id_admin', '$id_peminjam', '$tgl_pesan', '$tgl_ambil', '$tgl_wajibkembali', '$status_pinjam')";
    mysqli_query($conn, $query_peminjaman);
    $kode_pinjam = mysqli_insert_id($conn);

    // Insert data buku ke tabel detil_peminjaman
    foreach ($keranjang as $id_buku) {
        $query_detil = "INSERT INTO detil_peminjaman (kode_pinjam, id_buku) VALUES ('$kode_pinjam', '$id_buku')";
        mysqli_query($conn, $query_detil);
    }

    // Kosongkan keranjang setelah peminjaman berhasil
    $_SESSION['keranjang'] = [];
    header("Location: riwayat_peminjaman.php");
    exit;
}
?>
<div class="container mt-5">
    <h2>Keranjang Buku</h2>
    <?php if (!empty($buku_keranjang)) : ?>
        <div class="row">
            <?php foreach ($buku_keranjang as $item) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['judul_buku']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Pengarang: <?php echo $item['nama_pengarang']; ?></h6>
                            <p class="card-text">
                                <strong>Tanggal Terbit:</strong> <?php echo $item['tgl_terbit']; ?><br>
                                <strong>Penerbit:</strong> <?php echo $item['nama_penerbit']; ?>
                            </p>
                            <form method="post" action="">
                                <input type="hidden" name="id_buku" value="<?php echo $item['id_buku']; ?>">
                                <button type="submit" name="hapus_buku" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="tgl_ambil">Tanggal Ambil:</label>
                <input type="date" class="form-control" id="tgl_ambil" name="tgl_ambil" required>
            </div>
            <div class="form-group">
                <label for="tgl_wajibkembali">Tanggal Wajib Kembali:</label>
                <input type="date" class="form-control" id="tgl_wajibkembali" name="tgl_wajibkembali" required>
            </div>
            <br>
            <button type="submit" name="submit_peminjaman" class="btn btn-primary">Proses Peminjaman</button>
        </form>
    <?php else : ?>
        <p>Keranjang Anda kosong. <a href="homepage.php">Kembali ke halaman buku</a></p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
// Fungsi untuk mengisi otomatis tanggal wajib kembali
function isiTanggalWajibKembali() {
    // Ambil tanggal ambil dari input
    var tglAmbil = new Date(document.getElementById("tgl_ambil").value);
    // Tambahkan 14 hari (2 minggu)
    tglAmbil.setDate(tglAmbil.getDate() + 14);
    // Format tanggal menjadi YYYY-MM-DD
    var formattedDate = tglAmbil.toISOString().slice(0, 10);
    // Isi nilai input tanggal wajib kembali dengan hasil perhitungan
    document.getElementById("tgl_wajibkembali").value = formattedDate;
}

// Panggil fungsi saat halaman dimuat
document.addEventListener("DOMContentLoaded", function() {
    isiTanggalWajibKembali();
});

// Panggil fungsi saat input tanggal ambil berubah
document.getElementById("tgl_ambil").addEventListener("change", function() {
    isiTanggalWajibKembali();
});
</script>
</body>
</html>
