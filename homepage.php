<?php
include 'navbar.php';
require 'functions.php';
session_start();

// Mengambil data buku dari database
$buku = query("SELECT * FROM buku");

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Tambahkan buku ke keranjang
if (isset($_POST['add_to_cart'])) {
    $id_buku = $_POST['id_buku'];
    if (!in_array($id_buku, $_SESSION['keranjang'])) {
        $_SESSION['keranjang'][] = $id_buku;
    }
}
?>
<div class="container mt-5">
    <div class="row">
        <?php foreach ($buku as $item) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['judul_buku']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Pengarang: <?php echo $item['nama_pengarang']; ?></h6>
                        <p class="card-text">
                            <strong>Tanggal Terbit:</strong> <?php echo $item['tgl_terbit']; ?><br>
                            <strong>Penerbit:</strong> <?php echo $item['nama_penerbit']; ?>
                        </p>
                        <form action="" method="post">
                            <input type="hidden" name="id_buku" value="<?php echo $item['id_buku']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Pinjam</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="keranjang.php" class="btn btn-success">Lihat Keranjang</a>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
