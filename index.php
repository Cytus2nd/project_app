<?php
session_start();
include 'config/app.php';
$title = 'Login';

if (isset($_POST['login'])) {
    // Ambil inputan user
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek username
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($result) == 1) {
        // Ambil hasil query
        $hasil = mysqli_fetch_assoc($result);

        // Cek password
        if (password_verify($password, $hasil['password'])) {
            // Set sessions
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $hasil['id_user'];
            $_SESSION['nama'] = $hasil['nama'];
            $_SESSION['username'] = $hasil['username'];

            // Jika login berhasil, arahkan ke dashboard
            header('location: dashboard.php');
            exit;
        } else {
            $error = true; // Password salah
        }
    } else {
        $error = true; // Username tidak ditemukan
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

<body class="hold-transition login-page">
    <div class="login-box bg-light rounded-lg shadow-lg">
        <div class="login-logo">
            <img src="./assets/img/logo.png" alt="" width="150px" class="img-fluid mt-2">
            <p><b class="fw-bold">PR - Project APP</b></p>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body rounded-lg login-card-body">
                <p class="login-box-msg">Harap Masuk Terlebih Dahulu</p>

                <form action="" method="POST">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger text-center">
                            <b>Kredensial Anda Salah</b>
                        </div>
                    <?php endif; ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Masukkan Username..." name="username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Masukkan Password..." name="password" required minlength="8">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 text-bold">
                        <a href="register.php" class="text-danger text-decoration-underline">Tidak ada Akun? Daftar Sekarang</a>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <!-- /.col -->
            </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
    </div>
    <!-- /.login-box -->

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