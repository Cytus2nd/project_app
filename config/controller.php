<?php
function select($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function create_project($post)
{
    global $conn;
    if (isset($post['nama_proyek'], $post['deskripsi'], $post['tanggal_mulai'], $post['tanggal_selesai'], $post['id_user'], $post['rab_awal'])) {
        $nama_proyek = $post['nama_proyek'];
        $deskripsi = $post['deskripsi'];
        $tanggal_mulai = $post['tanggal_mulai'];
        $tanggal_selesai = $post['tanggal_selesai'];
        $id_user = $post['id_user'];
        $rab = $post['rab_awal'];

        if ($tanggal_selesai < $tanggal_mulai) {
            return -1;
        }

        $nama_proyek = $conn->real_escape_string($nama_proyek);
        $deskripsi = $conn->real_escape_string($deskripsi);
        $tanggal_mulai = $conn->real_escape_string($tanggal_mulai);
        $tanggal_selesai = $conn->real_escape_string($tanggal_selesai);
        $id_user = $conn->real_escape_string($id_user);

        $query = "INSERT INTO proyek (nama_proyek, deskripsi, tanggal_mulai, tanggal_selesai, id_user, rab)
                  VALUES ('$nama_proyek', '$deskripsi', '$tanggal_mulai', '$tanggal_selesai', '$id_user', '$rab')";

        if ($conn->query($query)) {
            return $conn->insert_id;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function delete_project($id)
{
    global $conn;

    // Cek apakah proyek memiliki fase terkait
    $sql_check_fase = "SELECT * FROM fase WHERE id_proyek = $id";
    $result_check_fase = mysqli_query($conn, $sql_check_fase);

    // Jika ada fase terkait, proyek tidak dapat dihapus
    if (mysqli_num_rows($result_check_fase) > 0) {
        return "Proyek ini tidak dapat dihapus karena memiliki fase terkait.";
    } else {
        // Jika tidak ada fase terkait, hapus proyek
        $query = "DELETE FROM proyek WHERE id = $id";
        mysqli_query($conn, $query);

        // Mengembalikan hasil penghapusan
        return mysqli_affected_rows($conn) > 0 ? "Proyek berhasil dihapus." : "Gagal menghapus proyek.";
    }
}


function update_project($post)
{
    global $conn;
    if (isset($post['id_project'], $post['nama_proyek'], $post['deskripsi'], $post['tanggal_mulai'], $post['tanggal_selesai'], $post['rab_ubah'])) {
        $id_project = $post['id_project'];
        $nama_proyek = $post['nama_proyek'];
        $deskripsi = $post['deskripsi'];
        $tanggal_mulai = $post['tanggal_mulai'];
        $tanggal_selesai = $post['tanggal_selesai'];
        $rab = $post['rab_ubah'];

        if ($tanggal_selesai < $tanggal_mulai) {
            return -1;
        }

        $nama_proyek = $conn->real_escape_string($nama_proyek);
        $deskripsi = $conn->real_escape_string($deskripsi);
        $tanggal_mulai = $conn->real_escape_string($tanggal_mulai);
        $tanggal_selesai = $conn->real_escape_string($tanggal_selesai);

        $query = "UPDATE proyek
                  SET nama_proyek = '$nama_proyek', deskripsi = '$deskripsi', tanggal_mulai = '$tanggal_mulai', tanggal_selesai = '$tanggal_selesai', rab = '$rab'
                  WHERE id = '$id_project'";

        if ($conn->query($query)) {
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

// Fungsi untuk menghapus fase
function hapusFase($fase_id)
{
    global $conn;

    // Cek apakah fase memiliki kegiatan terkait
    $sql_check_kegiatan = "SELECT * FROM kegiatan WHERE id_fase = $fase_id";
    $result_check_kegiatan = $conn->query($sql_check_kegiatan);

    // Jika ada kegiatan, fase tidak dapat dihapus
    if ($result_check_kegiatan->num_rows > 0) {
        return "Fase tidak dapat dihapus karena memiliki kegiatan terkait.";
    } else {
        // Jika tidak ada kegiatan terkait, hapus fase
        $sql_hapus_fase = "DELETE FROM fase WHERE id = $fase_id";
        if ($conn->query($sql_hapus_fase)) {
            return "Fase berhasil dihapus.";
        } else {
            return "Gagal menghapus fase: " . $conn->error;
        }
    }
}
