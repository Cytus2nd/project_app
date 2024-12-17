<?php
session_start();
include 'config/app.php';
$title = 'Register';

if (isset($_POST['register'])) {
    // Ambil inputan user
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validasi username unik
    $check_username = mysqli_query($conn, "SELECT username FROM users WHERE username='$username'");
    if (mysqli_num_rows($check_username) > 0) {
        echo "<script>
                alert('Username sudah digunakan!');
                document.location.href = 'register.php';
              </script>";
        exit;
    } elseif ($password != $confirm_password) {
        echo "<script>
                alert('Password tidak cocok!');
                document.location.href = 'register.php';
              </script>";
        exit;
    } else {
        // Hash password
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Insert ke database
        $insert = mysqli_query($conn, "INSERT INTO users (nama, username, password, created_at) VALUES ('$nama', '$username', '$password_hashed', NOW())");

        if ($insert) {
            echo "<script>
                    alert('Pendaftaran berhasil! Silahkan login.');
                    document.location.href = 'index.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Gagal mendaftar, coba lagi!');
                    document.location.href = 'register.php';
                  </script>";
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project APP | <?= $title ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="app/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Theme style -->
    <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
    <!-- sweet alert 2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- css -->
    <link rel="stylesheet" href="./assets/css/login.css">
    <!-- icon -->
    <link rel="icon" href="./assets/img/logo.png" type="image/x-icon">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="login-logo">
                        <img src="./assets/img/logo.png" alt="" width="100px" class="img-fluid mt-2">
                        <p><b class="fs-3 fw-bold">Registrasi Akun</b></p>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukkan Username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required minlength="8">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password" required minlength="8">
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="register" class="btn btn-primary">Daftar</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            Sudah punya akun? <a href="index.php" class="text-primary">Login disini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="app/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="app/dist/js/adminlte.min.js"></script>
    <!-- sweet alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>