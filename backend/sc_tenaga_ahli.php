<?php
// Menambahkan Tenaga Ahli
if (isset($_POST['tambah_tenaga_ahli'])) {
    $nama_tenaga_ahli = $_POST['nama_tenaga_ahli'];
    $keahlian = $_POST['keahlian'];
    $id_user = $_SESSION['id'];  // ID user yang sedang login

    $sql_tambah = "INSERT INTO tenaga_ahli (nama_tenaga_ahli, keahlian, id_user, status) 
                   VALUES ('$nama_tenaga_ahli', '$keahlian', '$id_user', 'aktif')";
    if ($conn->query($sql_tambah)) {
        echo "<script>alert('Tenaga Ahli berhasil ditambahkan!');</script>";
    } else {
        echo "<script>alert('Gagal menambahkan Tenaga Ahli.');</script>";
    }
}

// Mengupdate Tenaga Ahli (Ubah Nama & Keahlian)
if (isset($_POST['ubah_tenaga_ahli'])) {
    $id_tenaga_ahli = $_POST['id_tenaga_ahli'];
    $nama_tenaga_ahli = $_POST['nama_tenaga_ahli'];
    $keahlian = $_POST['keahlian'];

    $sql_ubah = "UPDATE tenaga_ahli 
                 SET nama_tenaga_ahli = '$nama_tenaga_ahli', keahlian = '$keahlian' 
                 WHERE id = $id_tenaga_ahli";
    if ($conn->query($sql_ubah)) {
        echo "<script>alert('Tenaga Ahli berhasil diubah!');</script>";
    } else {
        echo "<script>alert('Gagal mengubah Tenaga Ahli.');</script>";
    }
}

// Menghapus Tenaga Ahli
if (isset($_POST['hapus_tenaga_ahli'])) {
    $id_tenaga_ahli = $_POST['id_tenaga_ahli'];

    $sql_hapus = "DELETE FROM tenaga_ahli WHERE id = $id_tenaga_ahli";
    if ($conn->query($sql_hapus)) {
        echo "<script>alert('Tenaga Ahli berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus Tenaga Ahli.');</script>";
    }
}

// Mengubah Status (Aktif/Nonaktif)
if (isset($_POST['ubah_status'])) {
    $id_tenaga_ahli = $_POST['id_tenaga_ahli'];
    $status = $_POST['status']; // 'aktif' or 'nonaktif'

    $sql_status = "UPDATE tenaga_ahli SET status = '$status' WHERE id = $id_tenaga_ahli";
    if ($conn->query($sql_status)) {
        echo "<script>alert('Status Tenaga Ahli berhasil diubah!');</script>";
    } else {
        echo "<script>alert('Gagal mengubah status Tenaga Ahli.');</script>";
    }
}
