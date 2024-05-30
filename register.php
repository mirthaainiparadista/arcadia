<?php
include 'navbar_landing.php';
require 'functions.php';
// cek apakah tombol submit pernah dipencet
if (isset($_POST["registrasi"])) {
    // cek username & password
    if (registrasi($_POST) > 0){
        echo "
        <script>
        alert('Register berhasil');
        document.location.href = 'login.php';
        </script>
        ";
    } else{
        echo mysqli_error($conn);
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h1 class="mb-4">Registrasi</h1>
        <!-- <?php if(isset($error)) :?>
        <p style="color: red;">username / password salah</p>
        <?php  endif; ?> -->
        <form action="" method="post">
          <div class="form-group">
            <label for="nama_peminjam">Nama Peminjam:</label>
            <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" required>
          </div>
          <div class="form-group">
            <label for="user_peminjam">User Peminjam:</label>
            <input type="text" class="form-control" id="user_peminjam" name="user_peminjam" required>
          </div>
          <div class="form-group">
            <label for="pass_peminjam">Password:</label>
            <input type="password" class="form-control" id="pass_peminjam" name="pass_peminjam" required>
          </div>
          <div class="form-group">
            <label for="pass_peminjam2">Konfirmasi Password:</label>
            <input type="password" class="form-control" id="pass_peminjam2" name="pass_peminjam2" required>
          </div>
          <div class="form-group">
            <label for="foto">Foto:</label>
            <input type="text" class="form-control" id="foto" name="foto" required>
          </div>
          <input type="hidden" name="tgl_daftar" value="<?php echo date('Y-m-d'); ?>">
          <input type="hidden" name="status_peminjam" value="False">
          <br>
          <button type="submit" class="btn btn-primary" name="registrasi">Registrasi</button>
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
