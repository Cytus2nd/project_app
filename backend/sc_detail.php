<?php
if (isset($_POST['tambah_fase'])) {
    $id_proyek = $_POST['id_proyek'];
    $nama_fase = $_POST['nama_fase'];

    // Sanitasi input
    $nama_fase = $conn->real_escape_string($nama_fase);

    // Query untuk menambahkan fase
    $query = "INSERT INTO fase (id_proyek, nama_fase) VALUES ('$id_proyek', '$nama_fase')";

    // Eksekusi query
    if ($conn->query($query)) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Fase berhasil ditambahkan!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'detail_project.php?id=$id_proyek';  // Arahkan kembali ke halaman detail proyek
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Fase gagal ditambahkan!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}

// Jika ada data yang dikirim untuk menambah kegiatan
if (isset($_POST['tambah_kegiatan'])) {
    $id_fase = $_POST['id_fase'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal_mulai_kegiatan = $_POST['tanggal_mulai_kegiatan'];
    $tanggal_selesai_kegiatan = $_POST['tanggal_selesai_kegiatan'];
    $biaya = $_POST['biaya'];
    $keterangan = $_POST['keterangan'];
    $id_tenaga_ahli = $_POST['id_tenaga_ahli'];
    $id_proyek = $_POST['id_proyek'];

    // Sanitasi input
    $nama_kegiatan = $conn->real_escape_string($nama_kegiatan);
    $tanggal_mulai_kegiatan = $conn->real_escape_string($tanggal_mulai_kegiatan);
    $tanggal_selesai_kegiatan = $conn->real_escape_string($tanggal_selesai_kegiatan);
    $biaya = $conn->real_escape_string($biaya);
    $keterangan = $conn->real_escape_string($keterangan);
    $id_tenaga_ahli = $conn->real_escape_string($id_tenaga_ahli);

    // Query untuk menambahkan kegiatan
    $query = "INSERT INTO kegiatan (id_fase, nama_kegiatan, tanggal_mulai_kegiatan, tanggal_selesai_kegiatan, biaya, keterangan, id_tenaga_ahli)
              VALUES ('$id_fase', '$nama_kegiatan', '$tanggal_mulai_kegiatan', '$tanggal_selesai_kegiatan', '$biaya', '$keterangan', '$id_tenaga_ahli')";

    // Eksekusi query
    if ($conn->query($query)) {
        echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Kegiatan berhasil ditambahkan!',
                    icon: 'success',
                    timer: 8000,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location = 'detail_project.php?id=$id_proyek';  // Arahkan kembali ke halaman detail proyek
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Kegiatan gagal ditambahkan!',
                    icon: 'error',
                    timer: 8000,
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}

if (isset($_POST['ubah_kegiatan'])) {
    $id_kegiatan = $_POST['id_kegiatan'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $tanggal_mulai_kegiatan = $_POST['tanggal_mulai_kegiatan'];
    $tanggal_selesai_kegiatan = $_POST['tanggal_selesai_kegiatan'];
    $biaya = $_POST['biaya'];
    $keterangan = $_POST['keterangan'];
    $id_tenaga_ahli = $_POST['id_tenaga_ahli'];
    $id_proyek = $_POST['id_proyek'];

    $sql_update = "UPDATE kegiatan SET
                    nama_kegiatan = '$nama_kegiatan',
                    tanggal_mulai_kegiatan = '$tanggal_mulai_kegiatan',
                    tanggal_selesai_kegiatan = '$tanggal_selesai_kegiatan',
                    biaya = '$biaya',
                    keterangan = '$keterangan',
                    id_tenaga_ahli = '$id_tenaga_ahli'
                    WHERE id = $id_kegiatan";

    if ($conn->query($sql_update)) {
        echo "<script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Kegiatan berhasil diubah!',
                icon: 'success',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'detail_project.php?id=$id_proyek';  // Arahkan kembali ke halaman detail proyek
            });
          </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Kegiatan gagal ditambahkan!',
                icon: 'error',
                timer: 8000,
                confirmButtonText: 'OK'
            });
          </script>";
    }
}

// Menangani proses hapus kegiatan
if (isset($_POST['hapus_kegiatan']) && isset($_POST['id_kegiatan'])) {
    $id_kegiatan = $_POST['id_kegiatan'];
    $id_proyek = $_POST['id_proyek'];

    // Hapus kegiatan dari database
    $sql_hapus_kegiatan = "DELETE FROM kegiatan WHERE id = $id_kegiatan";
    if ($conn->query($sql_hapus_kegiatan) === TRUE) {
        echo "<script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Kegiatan berhasil dihapus!',
                icon: 'success',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'detail_project.php?id=$id_proyek';  // Arahkan kembali ke halaman detail proyek
            });
          </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Kegiatan gagal dihapus!',
                icon: 'error',
                timer: 8000,
                confirmButtonText: 'OK'
            });
          </script>";
    }
}

// Menangani aksi hapus fase
if (isset($_POST['hapus_fase_id'])) {
    $fase_id = $_POST['hapus_fase_id'];
    $id_proyek = $_POST['id_proyek'];
    $result_message = hapusFase($fase_id);
    echo "<script>
            Swal.fire({
                title: '" . ($result_message === 'Fase berhasil dihapus.' ? 'Sukses!' : 'Gagal!') . "',
                text: '$result_message',
                icon: '" . ($result_message === 'Fase berhasil dihapus.' ? 'success' : 'error') . "',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'detail_project.php?id=$id_proyek';  
            });
          </script>";
}

if (isset($_POST['ubah_fase'])) {
    $fase_id = $_POST['fase_id'];
    $nama_fase = $_POST['nama_fase'];
    $id_proyek = $_POST['id_proyek'];

    $sql_ubah_fase = "UPDATE fase SET nama_fase = '$nama_fase' WHERE id = $fase_id";
    if ($conn->query($sql_ubah_fase) === TRUE) {
        echo "<script>
            Swal.fire({
                title: 'Sukses!',
                text: 'Nama fase berhasil diubah.',
                icon: 'success',
                timer: 8000,
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'detail_project.php?id=$id_proyek';  
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan dalam mengubah nama fase.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'detail_project.php?id=$id_proyek';  
            });
        </script>";
    }
}
