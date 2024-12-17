<?php
// Menambahkan Tenaga Ahli
if (isset($_POST['tambah_tenaga_ahli'])) {
    // Ambil input dari form dan sanitasi
    $nama_tenaga_ahli = mysqli_real_escape_string($conn, $_POST['nama_tenaga_ahli']);
    $keahlian = mysqli_real_escape_string($conn, $_POST['keahlian']);
    $id_user = $_SESSION['id_user']; // Pastikan ini sesuai dengan session yang benar

    // Query untuk menambahkan data tenaga ahli
    $sql_tambah = "INSERT INTO tenaga_ahli (nama_tenaga_ahli, keahlian, id_user, status) 
                   VALUES ('$nama_tenaga_ahli', '$keahlian', '$id_user', 1)"; // Status default 1 (Aktif)

    if ($conn->query($sql_tambah)) {
        echo "<script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Tenaga Ahli berhasil diTambahkan.',
                icon: 'success',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'tenaga_ahli.php';  
            });
        </script>";
        exit;
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Tenaga Ahli gagal diTambahkan.',
                icon: 'error',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'tenaga_ahli.php';  
            });
        </script>";
    }
}


// Mengupdate Tenaga Ahli
if (isset($_POST['ubah_tenaga_ahli'])) {
    $id_tenaga_ahli = $_POST['id_tenaga_ahli'];
    $nama_tenaga_ahli = mysqli_real_escape_string($conn, $_POST['nama_tenaga_ahli']);
    $keahlian = mysqli_real_escape_string($conn, $_POST['keahlian']);
    $status = $_POST['status']; // Ambil status dari form (1 = aktif, 0 = nonaktif)

    // Query Update
    $sql_ubah = "UPDATE tenaga_ahli 
                 SET nama_tenaga_ahli = '$nama_tenaga_ahli', 
                     keahlian = '$keahlian', 
                     status = '$status' 
                 WHERE id = $id_tenaga_ahli";

    // Eksekusi Query
    if ($conn->query($sql_ubah)) {
        echo "<script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Tenaga Ahli berhasil diUbah.',
                icon: 'success',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'tenaga_ahli.php';  
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Tenaga Ahli Gagal diUbah.',
                icon: 'error',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'tenaga_ahli.php';  
            });
        </script>";
    }
}
