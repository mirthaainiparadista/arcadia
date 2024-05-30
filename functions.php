<?php 
// koneksi database
$conn = mysqli_connect("localhost", "root", "", "arcadia");

function query($query){
    // melakukan query
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows=[];
    while($row=mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;

}

function tambah($data){
    global $conn;
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $gambar = upload();
    if(!$gambar){
        return false;
    }

    $query = "INSERT INTO mahasiswa
                VALUES
                ('$nim', '$nama', '$gambar')";
                
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
} 

function hapus($nim){
    global $conn;
    
    $query = "DELETE FROM mahasiswa WHERE nim = $nim";
                
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
} 

function ubah($data){
    global $conn;
    $nim = htmlspecialchars($data["nim"]);
    $nama = htmlspecialchars($data["nama"]);
    $gambarLama = htmlspecialchars($data["gambarLama"]);

    if($_FILES["gambar"===4]){
        $gambar=$gambarLama;
    }else{
        $gambar = upload();
    }

    if(!$gambar){
        return false;
    }

    $query = "UPDATE mahasiswa SET
                nim='$nim', nama='$nama', gambar='$gambar'
                WHERE nim=$nim
                ";
                
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
} 

function upload(){
    $namaFile = $_FILES["gambar"]["name"];
    $ukuranFile = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tempName = $_FILES["gambar"]["tmp_name"];

    if($error===4){
        echo "
        <script>
            alert('Upload File Dulu');
        </script>
        ";
        return false;
    }

    $ekstensiFile=['jpg', 'jpeg', 'png'];
    $ekstensiGambar= explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if(!in_array($ekstensiGambar, $ekstensiFile)){
        echo "
        <script>
            alert('File Bukan Gambar');
        </script>
        ";
        return false;
    }


    if($ukuranFile>2000000){
        echo "
        <script>
            alert('Gambar terlalu besar');
        </script>
        ";
        return false;
    }
    
    $namaGambar= uniqid();
    $namaGambar .= ".";
    $namaGambar .= $ekstensiGambar;
    move_uploaded_file($tempName,'img/'.$namaGambar);
    return $namaGambar;
}

function registrasi($data){
    global $conn;
    $nama_peminjam = strtolower(stripslashes($data["nama_peminjam"]));
    $tgl_daftar = $data["tgl_daftar"];
    $user_peminjam = isset($_POST["user_peminjam"]) ? strtolower(stripslashes($_POST["user_peminjam"])) : "";

    $pass_peminjam = mysqli_real_escape_string($conn, $data["pass_peminjam"]);
    $pass_peminjam2 = mysqli_real_escape_string($conn, $data["pass_peminjam2"]);
    $foto_peminjam = strtolower(stripslashes($data["foto"]));
    $status_peminjam = $data["status_peminjam"];

    // cek user_peminjam
    $result = mysqli_query($conn, "SELECT user_peminjam FROM peminjam WHERE user_peminjam = '$user_peminjam'");
    if (mysqli_fetch_assoc($result)) {
        echo "
        <script>
        alert('user_peminjam sudah terdaftar');
        </script>
        ";
        return false;
    }

    // cek konfirmasi pass_peminjam
    if($pass_peminjam !== $pass_peminjam2){
        echo "
        <script>
        alert('Konfirmasi pass_peminjam tidak sesuai');
        </script>
        ";
        return false;
    }

    // enkripsi pass_peminjam
    $pass_peminjam = password_hash($pass_peminjam, PASSWORD_DEFAULT);

    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO peminjam (nama_peminjam, tgl_daftar, user_peminjam, pass_peminjam, foto_peminjam, status_peminjam) VALUES ('$nama_peminjam', '$tgl_daftar', '$user_peminjam', '$pass_peminjam', '$foto_peminjam', '$status_peminjam')");

    return mysqli_affected_rows($conn);
}


?>