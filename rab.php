<?php
session_start();
$title = 'RAB Project';
include 'layout/header.php';
include 'backend/sc_rab.php';

// Pastikan id_proyek ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_proyek = $_GET['id'];

    // Mengambil data proyek berdasarkan id_proyek
    $sql_project = "SELECT * FROM proyek WHERE id = $id_proyek";
    $result_project = $conn->query($sql_project);
    if ($result_project->num_rows > 0) {
        $project = $result_project->fetch_assoc();
    } else {
        echo "Proyek tidak ditemukan.";
        exit;
    }

    // Mengambil data fase berdasarkan id_proyek
    $sql_fase = "SELECT * FROM fase WHERE id_proyek = $id_proyek";
    $result_fase = $conn->query($sql_fase);
} else {
    // Redirect jika id_proyek tidak ada atau tidak valid
    header("Location: project.php");
    exit;
}

$sql_rab = "SELECT proyek.nama_proyek, proyek.rab, SUM(kegiatan.biaya) AS total_biaya
            FROM proyek
            LEFT JOIN fase ON fase.id_proyek = proyek.id
            LEFT JOIN kegiatan ON kegiatan.id_fase = fase.id
            WHERE proyek.id = $id_proyek
            GROUP BY proyek.id";
$result_rab = $conn->query($sql_rab);
$rab = $result_rab->fetch_assoc();
$sisa_rab = $rab['rab'] - $rab['total_biaya'];

$sql_kegiatan = "SELECT kegiatan.nama_kegiatan, fase.nama_fase, kegiatan.biaya 
                 FROM kegiatan
                 JOIN fase ON kegiatan.id_fase = fase.id
                 WHERE fase.id_proyek = $id_proyek
                 ORDER BY fase.id ASC";  // Mengurutkan berdasarkan id fase terkecil
$result_kegiatan = $conn->query($sql_kegiatan);


?>

<div class="container mt-4">
    <h3 class="mb-2">RAB Project: <?= htmlspecialchars($project['nama_proyek']); ?></h3>
    <p class="mb-3">
        <a class="text-decoration-none text-dark" href="index.php">Halaman Utama</a> >
        <a class="text-decoration-none text-dark" href="project.php?id=<?= $id_proyek ?>">Project</a> > RAB
    </p>
    <!-- Tabel Kegiatan -->
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>Nama Fase</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($kegiatan = $result_kegiatan->fetch_assoc()) :
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($kegiatan['nama_kegiatan']); ?></td>
                    <td><?= htmlspecialchars($kegiatan['nama_fase']); ?></td>
                    <td>Rp <?= number_format($kegiatan['biaya'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mx-auto mt-4" style="max-width: 600px;">
        <div>
            <h5>RAB Awal Proyek:</h5>
            <p>Rp <?= number_format($rab['rab'], 0, ',', '.'); ?></p>
        </div>
        <div>
            <h5>Total Biaya Kegiatan:</h5>
            <p>Rp <?= number_format($rab['total_biaya'], 0, ',', '.'); ?></p>
        </div>
        <div>
            <h5>Sisa RAB:</h5>
            <p>Rp <?= number_format($sisa_rab, 0, ',', '.'); ?></p>
        </div>
    </div>

</div>

<?php include 'layout/footer.php'; ?>