<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'index.php';
          </script>";
    exit;
}

$title = 'Halaman Utama';
include 'layout/header.php';
?>
<div class="container mt-4">
    <h3>Selamat Datang, <span class="text-primary"><?= htmlspecialchars($_SESSION['username']); ?></span>!</h3>
    <p>Awali Hari dengan Semangat dan Senyum yang manis </p>
    <a href="project.php" class="btn btn-primary btn-block w-100">Lihat Project yang Saya Handle</a>
    <br>
    <hr>
    <img src="assets/img/banner.jpg" class="img-fluid" alt="banner">
    <br>
    <br>
</div>
<?php include 'layout/footer.php' ?>