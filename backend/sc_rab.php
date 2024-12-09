<?php
// Misalnya setelah mengupdate biaya kegiatan
if (isset($_POST['update_biaya'])) {
    $kegiatan_id = $_POST['kegiatan_id'];
    $biaya_baru = $_POST['biaya'];

    // Update biaya kegiatan
    $sql_update_biaya = "UPDATE kegiatan SET biaya = $biaya_baru WHERE id = $kegiatan_id";
    $conn->query($sql_update_biaya);

    // Update total RAB proyek
    $sql_total_biaya = "SELECT SUM(biaya) AS total_biaya FROM kegiatan WHERE id_proyek = $id_proyek";
    $result_biaya = $conn->query($sql_total_biaya);
    $row_biaya = $result_biaya->fetch_assoc();
    $total_biaya = $row_biaya['total_biaya'];

    $sql_update_rab = "UPDATE proyek SET rab = rab - $total_biaya WHERE id = $id_proyek";
    $conn->query($sql_update_rab);
}
