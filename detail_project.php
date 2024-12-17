<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'index.php';
          </script>";
    exit;
}
$title = 'Detail Project';
include 'layout/header.php';
include 'backend/sc_detail.php';

// Cek apakah id_proyek ada dalam URL dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_proyek = $_GET['id'];

    // Mengambil data proyek
    $sql_project = "SELECT * FROM proyek WHERE id = $id_proyek";
    $result_project = $conn->query($sql_project);
    if ($result_project) {
        $project = $result_project->fetch_assoc();
    } else {
        echo "Gagal mengambil data proyek: " . $conn->error;
        exit;
    }

    // Mengambil data fase-fase proyek
    $sql_fase = "SELECT * FROM fase WHERE id_proyek = $id_proyek";
    $result_fase = $conn->query($sql_fase);
} else {
    // Redirect jika id_proyek tidak ada atau tidak valid
    header("Location: project.php");
    exit;
}

?>

<div class="container mt-4">
    <section>
        <h3>Detail Project: <?= htmlspecialchars($project['nama_proyek']); ?></h3>
        <p><a class="text-decoration-none text-dark" href="dashboard.php">Halaman Utama</a> > <a class="text-decoration-none text-dark" href="project.php">Project</a> > Detail Project</p>

        <!-- Form Tambah Fase -->
        <button type="button" class="btn btn-primary mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#modalTambahFase">Tambah Fase</button>

        <!-- Menampilkan Fase -->
        <?php if ($result_fase->num_rows > 0) : ?>
            <table class="table table-bordered table-light table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Fase</th>
                        <th>Kegiatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php while ($fase = $result_fase->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($fase['nama_fase']); ?></td>

                            <!-- Menampilkan Kegiatan yang terkait dengan Fase -->
                            <td class="w-50">
                                <?php
                                $fase_id = $fase['id'];
                                $sql_kegiatan = "SELECT kegiatan.*, tenaga_ahli.nama_tenaga_ahli, tenaga_ahli.keahlian 
                                FROM kegiatan 
                                JOIN tenaga_ahli ON kegiatan.id_tenaga_ahli = tenaga_ahli.id 
                                WHERE kegiatan.id_fase = $fase_id
                                ORDER BY kegiatan.id ASC";
                                $result_kegiatan = $conn->query($sql_kegiatan);
                                $noe = 1;
                                if ($result_kegiatan->num_rows > 0) :
                                    while ($kegiatan = $result_kegiatan->fetch_assoc()) :
                                        echo "<div><a class='btn btn-link text-decoration-none text-dark fw-bold' data-bs-toggle='collapse' href='#collapseKegiatan{$kegiatan['id']}'>Kegiatan " . $noe++ . " - " . htmlspecialchars($kegiatan['nama_kegiatan']) . "</a></div>";
                                        echo "<div class='collapse' id='collapseKegiatan{$kegiatan['id']}'>";
                                        echo "<ul>";
                                        echo "<li><strong>Waktu:</strong> " . date('d/m/Y', strtotime($kegiatan['tanggal_mulai_kegiatan'])) . " sampai " . date('d/m/Y', strtotime($kegiatan['tanggal_selesai_kegiatan'])) . "</li>";
                                        echo "<li><strong>Biaya:</strong> Rp " . number_format($kegiatan['biaya'], 0, ',', '.') . "</li>";
                                        echo "<li><strong>Keterangan:</strong> " . htmlspecialchars($kegiatan['keterangan']) . "</li>";
                                        echo "<li><strong>Tenaga Ahli:</strong> " . htmlspecialchars($kegiatan['nama_tenaga_ahli']) . " - " . htmlspecialchars($kegiatan['keahlian']) . "</li>";
                                        echo "</ul>";
                                        echo "<button type='button' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#modalUbahKegiatan{$kegiatan['id']}'>Ubah Kegiatan</button>";
                                        echo "<button type='button' class='btn btn-danger mx-2' data-bs-toggle='modal' data-bs-target='#modalHapusKegiatan{$kegiatan['id']}'>Hapus Kegiatan</button>";
                                        echo "</div><hr>";

                                        // Modal Ubah Kegiatan
                                        echo "<div class='modal fade' id='modalUbahKegiatan{$kegiatan['id']}' tabindex='-1' aria-labelledby='modalUbahKegiatanLabel{$kegiatan['id']}' aria-hidden='true'>";
                                        echo "<div class='modal-dialog modal-dialog-centered'>";
                                        echo "<div class='modal-content'>";
                                        echo "<div class='modal-header bg-warning text-white'>";
                                        echo "<h1 class='modal-title fs-5' id='modalUbahKegiatanLabel{$kegiatan['id']}'>Ubah Kegiatan: " . htmlspecialchars($kegiatan['nama_kegiatan']) . "</h1>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        echo "<form method='POST'>";
                                        echo "<input type='hidden' name='id_kegiatan' value='{$kegiatan['id']}'>";
                                        echo "<div class='mb-3'><input type='hidden' name='id_proyek' id='id_proyek' class='form-control' value='" . htmlspecialchars($id_proyek) . "'></div>";
                                        echo "<div class='mb-3'><label for='nama_kegiatan'>Nama Kegiatan</label><input type='text' name='nama_kegiatan' id='nama_kegiatan' class='form-control' value='" . htmlspecialchars($kegiatan['nama_kegiatan']) . "' required></div>";
                                        echo "<div class='mb-3'><label for='tanggal_mulai_kegiatan'>Tanggal Mulai Kegiatan</label><input type='date' name='tanggal_mulai_kegiatan' id='tanggal_mulai_kegiatan' class='form-control' value='" . date('Y-m-d', strtotime($kegiatan['tanggal_mulai_kegiatan'])) . "' required></div>";
                                        echo "<div class='mb-3'><label for='tanggal_selesai_kegiatan'>Tanggal Selesai Kegiatan</label><input type='date' name='tanggal_selesai_kegiatan' id='tanggal_selesai_kegiatan' class='form-control' value='" . date('Y-m-d', strtotime($kegiatan['tanggal_selesai_kegiatan'])) . "' required></div>";
                                        echo "<div class='mb-3'><label for='biaya'>Biaya</label><input type='number' name='biaya' id='biaya' class='form-control' value='" . htmlspecialchars($kegiatan['biaya']) . "'></div>";
                                        echo "<div class='mb-3'><label for='keterangan'>Keterangan</label><input type='text' name='keterangan' id='keterangan' class='form-control' value='" . htmlspecialchars($kegiatan['keterangan']) . "'></div>";
                                        echo "<div class='mb-3'><label for='id_tenaga_ahli'>Tenaga Ahli</label><select name='id_tenaga_ahli' id='id_tenaga_ahli' class='form-select'>";
                                        $sql_tenaga_ahli = "SELECT * FROM tenaga_ahli WHERE status = 1";
                                        $result_tenaga_ahli = $conn->query($sql_tenaga_ahli);
                                        while ($tenaga = $result_tenaga_ahli->fetch_assoc()) {
                                            $selected = (isset($kegiatan['id_tenaga_ahli']) && $tenaga['id'] == $kegiatan['id_tenaga_ahli']) ? 'selected' : '';
                                            echo "<option value='" . $tenaga['id'] . "' $selected>" . htmlspecialchars($tenaga['nama_tenaga_ahli']) . " - " . htmlspecialchars($tenaga['keahlian']) . "</option>";
                                        }
                                        echo "</select></div>";
                                        echo "<div class='modal-footer'>";
                                        echo "<button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Kembali</button>";
                                        echo "<button type='submit' name='ubah_kegiatan' class='btn btn-warning'>Simpan Perubahan</button>";
                                        echo "</div>";
                                        echo "</form>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";


                                        // Modal Hapus Kegiatan
                                        echo "<div class='modal fade' id='modalHapusKegiatan{$kegiatan['id']}' tabindex='-1' aria-labelledby='modalHapusKegiatanLabel{$kegiatan['id']}' aria-hidden='true'>";
                                        echo "<div class='modal-dialog modal-dialog-centered'>";
                                        echo "<div class='modal-content'>";
                                        echo "<div class='modal-header bg-danger text-white'>";
                                        echo "<h1 class='modal-title fs-5' id='modalHapusKegiatanLabel{$kegiatan['id']}'>Hapus Kegiatan: " . htmlspecialchars($kegiatan['nama_kegiatan']) . "</h1>";
                                        echo "</div>";
                                        echo "<div class='modal-body'>";
                                        echo "<p>Apakah Anda yakin ingin menghapus kegiatan ini?</p>";
                                        echo "</div>";
                                        echo "<div class='modal-footer'>";
                                        echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>";
                                        echo "<form method='POST' style='display:inline-block;'>";
                                        echo "<input type='hidden' name='id_kegiatan' value='{$kegiatan['id']}'>";
                                        echo "<input type='hidden' name='id_proyek' value='{$id_proyek}'>";
                                        echo "<button type='submit' name='hapus_kegiatan' class='btn btn-danger'>Hapus</button>";
                                        echo "</form>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";
                                        echo "</div>";

                                    endwhile;
                                else :
                                    echo "<p>Tidak ada kegiatan untuk fase ini.</p>";
                                endif;
                                ?>
                            </td>

                            <td class="text-center">
                                <!-- Tombol aksi untuk mengubah dan menghapus fase -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbahFase<?= $fase['id']; ?>">Ubah Fase</button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapusFase<?= $fase['id']; ?>">
                                    Hapus Fase
                                </button>
                                <!-- Modal Hapus Fase -->
                                <div class="modal fade" id="modalHapusFase<?= $fase['id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalHapusFaseLabel<?= $fase['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h1 class="modal-title fs-5" id="modalHapusFaseLabel<?= $fase['id']; ?>">Hapus Data Fase</h1>
                                            </div>
                                            <div class="modal-body">
                                                <p>Apakah Anda yakin ingin menghapus <strong><?= htmlspecialchars($fase['nama_fase']); ?></strong>?</p>
                                                <p><strong>Perhatian:</strong> Fase ini tidak dapat dipulihkan setelah dihapus.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form method="POST">
                                                    <input type="hidden" name="hapus_fase_id" value="<?= $fase['id']; ?>">
                                                    <input type="hidden" name="id_proyek" value="<?= $id_proyek; ?>">
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal Ubah Nama Fase -->
                                <div class="modal fade" id="modalUbahFase<?= $fase['id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalUbahFaseLabel<?= $fase['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-white">
                                                <h1 class="modal-title fs-5" id="modalUbahFaseLabel<?= $fase['id']; ?>">Ubah Nama Fase</h1>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST">
                                                    <input type="hidden" name="fase_id" value="<?= $fase['id']; ?>">
                                                    <input type="hidden" name="id_proyek" value="<?= $id_proyek; ?>">
                                                    <div class="mb-3">
                                                        <label for="nama_fase" class="form-label">Nama Fase</label>
                                                        <input type="text" name="nama_fase" class="form-control" value="<?= htmlspecialchars($fase['nama_fase']); ?>" required>
                                                    </div>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="ubah_fase" class="btn btn-warning">Ubah Fase</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tombol untuk menambah kegiatan pada fase -->
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalTambahKegiatan<?= $fase['id']; ?>">Tambah Kegiatan</button>
                            </td>
                        </tr>

                        <!-- Modal Tambah Kegiatan -->
                        <div class="modal fade" id="modalTambahKegiatan<?= $fase['id']; ?>" tabindex="-1" aria-labelledby="modalTambahKegiatanLabel<?= $fase['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h1 class="modal-title fs-5" id="modalTambahKegiatanLabel<?= $fase['id']; ?>">Tambah Kegiatan ke Fase: <?= htmlspecialchars($fase['nama_fase']); ?></h1>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <input type="hidden" name="id_fase" value="<?= $fase['id']; ?>">
                                            <input type="hidden" name="id_proyek" value="<?= $id_proyek; ?>">

                                            <div class="mb-3">
                                                <label for="nama_kegiatan">Nama Kegiatan</label>
                                                <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tanggal_mulai_kegiatan">Tanggal Mulai Kegiatan</label>
                                                <input type="date" name="tanggal_mulai_kegiatan" id="tanggal_mulai_kegiatan" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="tanggal_selesai_kegiatan">Tanggal Selesai Kegiatan</label>
                                                <input type="date" name="tanggal_selesai_kegiatan" id="tanggal_selesai_kegiatan" class="form-control" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="biaya">Biaya</label>
                                                <input type="number" name="biaya" id="biaya" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="id_tenaga_ahli">Tenaga Ahli</label>
                                                <select name="id_tenaga_ahli" id="id_tenaga_ahli" class="form-select" required>
                                                    <option value="" disabled selected>Pilih Tenaga Ahli</option>
                                                    <?php
                                                    // Ambil hanya tenaga ahli yang aktif
                                                    $sql_tenaga_ahli = "SELECT * FROM tenaga_ahli WHERE status = 1";
                                                    $result_tenaga_ahli = $conn->query($sql_tenaga_ahli);
                                                    while ($tenaga = $result_tenaga_ahli->fetch_assoc()) {
                                                        $selected = (isset($kegiatan['id_tenaga_ahli']) && $tenaga['id'] == $kegiatan['id_tenaga_ahli']) ? 'selected' : '';
                                                        echo "<option value='" . $tenaga['id'] . "' $selected>" . htmlspecialchars($tenaga['nama_tenaga_ahli']) . " - " . htmlspecialchars($tenaga['keahlian']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                                                <button type="submit" name="tambah_kegiatan" class="btn btn-primary">Tambah Kegiatan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Tidak ada fase pada proyek ini.</p>
        <?php endif; ?>
    </section>
</div>

<!-- Modal Tambah Fase -->
<div class="modal fade" id="modalTambahFase" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Fase Baru</h1>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" name="id_proyek" value="<?= $id_proyek; ?>">
                    <div class="mb-3">
                        <label for="nama_fase">Nama Fase</label>
                        <input type="text" name="nama_fase" id="nama_fase" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" name="tambah_fase" class="btn btn-primary">Tambah Fase</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Fase -->
<div class="modal fade" id="modalHapusFase<?= $fase['id']; ?>" tabindex="-1" aria-labelledby="modalHapusFaseLabel<?= $fase['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHapusFaseLabel<?= $fase['id']; ?>">Konfirmasi Hapus Fase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus fase <strong><?= htmlspecialchars($fase['nama_fase']); ?></strong>? <br>
                Fase ini <strong>tidak dapat dipulihkan</strong> setelah dihapus.
            </div>
            <div class="modal-footer">
                <!-- Form untuk hapus fase setelah konfirmasi -->
                <form method="POST">
                    <input type="hidden" name="hapus_fase_id" value="<?= $fase['id']; ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Fase</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>