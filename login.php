<?php
include 'navbar_landing.php';
require 'functions.php';
session_start();

$error = false; // Inisialisasi variabel error

// cek apakah tombol submit pernah dipencet
if (isset($_POST["login"])) {
    // cek username & password
    $user_peminjam = $_POST["user_peminjam"];
    $pass_peminjam = $_POST["pass_peminjam"];

    // Periksa di tabel peminjam
    $result_peminjam = mysqli_query($conn, "SELECT * FROM peminjam WHERE user_peminjam = '$user_peminjam'");

    if ( mysqli_num_rows($result_peminjam) == 1){

        $row = mysqli_fetch_assoc($result_peminjam);
        if (password_verify($pass_peminjam, $row["pass_peminjam"])){
            $_SESSION['peminjam_id'] = $row['id_peminjam'];
            header("Location: homepage.php");
            exit;
        }
    }
    $error = true;

    // Periksa di tabel admin
    $result_admin = mysqli_query($conn, "SELECT * FROM admin WHERE user_admin = '$user_peminjam'");

    if (mysqli_num_rows($result_admin) == 1) {
        $row_admin = mysqli_fetch_assoc($result_admin);
        if ($pass_peminjam == $row_admin["pass_admin"]) { // Periksa password plaintext
            $_SESSION['admin_id'] = $row_admin['id_admin'];
            header("Location: admin_dashboard.php");
            exit;
        }
    }

    $error = true; // Set error menjadi true jika username atau password salah
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Login</h1>
            <?php if ($error) : ?>
                <p style="color: red;">Username atau password salah</p>
            <?php endif; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="user_peminjam">User Peminjam:</label>
                    <input type="text" class="form-control" id="user_peminjam" name="user_peminjam" required>
                </div>
                <div class="form-group">
                    <label for="pass_peminjam">Password:</label>
                    <input type="password" class="form-control" id="pass_peminjam" name="pass_peminjam" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" name="login">Login</button>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
