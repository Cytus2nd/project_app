<?php
if (isset($_POST["tambah"])) {
    $result = create_project($_POST);
    if ($result > 0) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Project Berhasil ditambahkan!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'project.php';
                });
              </script>";
    } else if ($result == -1) {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Tanggal Mulai / Tanggal Selesai Invalid!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'project.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Oops...',
                    text: 'Data Project Gagal Ditambahkan',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'project.php';
                });
              </script>";
    }
}

if (isset($_POST['id'])) {
    $id_proyek = $_POST['id'];
    $result_message = delete_project($id_proyek);

    echo "<script>
            Swal.fire({
                title: 'Status Penghapusan Proyek',
                text: '$result_message',
                icon: '" . ($result_message === 'Proyek berhasil dihapus.' ? 'success' : 'error') . "',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'project.php';  
            });
          </script>";
}

if (isset($_POST['ubah'])) {
    $result = update_project($_POST);

    if ($result == 1) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Project berhasil diubah!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'project.php'; 
                });
              </script>";
    } elseif ($result == -1) {
        echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Tanggal Selesai / Tanggal Mulai Invalid',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'project.php'; 
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Project gagal diubah!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'project.php'; 
                });
              </script>";
    }
}
