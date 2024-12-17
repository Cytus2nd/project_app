<?php
session_start();

if (!isset($_SESSION['login'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            document.location.href = 'index.php';
          </script>";
    exit;
}

$id_user = $_SESSION['id_user'];

$title = "Tenaga Ahli";
include 'layout/header.php'; // File untuk CRUD tenaga ahli
include 'backend/sc_tenaga_ahli.php'; // File untuk CRUD tenaga ahli

$sql_tenaga_ahli = "SELECT * FROM tenaga_ahli WHERE id_user = $id_user";
$result_tenaga_ahli = $conn->query($sql_tenaga_ahli);
?>

<div class="container mt-4">
    <h3>Daftar Tenaga Ahli</h3>
    <p><a class="text-decoration-none text-dark" href="dashboard.php">Halaman Utama</a> > <a class="text-decoration-none text-dark">Tenaga Ahli</a></p>

    <button type="button" class="btn btn-primary mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#modalTambahTenagaAhli">Tambah Tenaga Ahli</button>

    <table class="table table-bordered table-light table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tenaga Ahli</th>
                <th>Keahlian</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result_tenaga_ahli->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result_tenaga_ahli->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama_tenaga_ahli']); ?></td>
                        <td><?= htmlspecialchars($row['keahlian']); ?></td>
                        <td>
                            <?php if ($row['status'] == 1): ?>
                                <span class="text-success fw-bold">Aktif</span>
                            <?php else: ?>
                                <span class="text-danger fw-bold">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbahTenagaAhli<?= $row['id']; ?>">Ubah</button>
                        </td>
                    </tr>

                    <!-- Modal Edit Tenaga Ahli -->
                    <div class="modal fade" id="modalUbahTenagaAhli<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalUbahTenagaAhliLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalUbahTenagaAhliLabel">Ubah Tenaga Ahli</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Form Ubah Tenaga Ahli -->
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_tenaga_ahli" value="<?= $row['id']; ?>">

                                        <!-- Nama Tenaga Ahli -->
                                        <div class="mb-3">
                                            <label for="nama_tenaga_ahli<?= $row['id']; ?>" class="form-label">Nama Tenaga Ahli</label>
                                            <input type="text" class="form-control" id="nama_tenaga_ahli<?= $row['id']; ?>"
                                                name="nama_tenaga_ahli" value="<?= htmlspecialchars($row['nama_tenaga_ahli']); ?>" required>
                                        </div>

                                        <!-- Keahlian -->
                                        <div class="mb-3">
                                            <label for="keahlian<?= $row['id']; ?>" class="form-label">Keahlian</label>
                                            <input type="text" class="form-control" id="keahlian<?= $row['id']; ?>"
                                                name="keahlian" value="<?= htmlspecialchars($row['keahlian']); ?>" required>
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3">
                                            <label for="status<?= $row['id']; ?>" class="form-label">Status</label>
                                            <select class="form-control" id="status<?= $row['id']; ?>" name="status" required>
                                                <option value="1" <?= $row['status'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                                                <option value="0" <?= $row['status'] == 0 ? 'selected' : ''; ?>>Nonaktif</option>
                                            </select>
                                        </div>

                                        <!-- Tombol Simpan -->
                                        <button type="submit" class="btn btn-primary" name="ubah_tenaga_ahli">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Saya Belum Memiliki Tenaga Ahli</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Tenaga Ahli -->
<div class="modal fade" id="modalTambahTenagaAhli" tabindex="-1" aria-labelledby="modalTambahTenagaAhliLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahTenagaAhliLabel">Tambah Tenaga Ahli</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Tenaga Ahli -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nama_tenaga_ahli" class="form-label">Nama Tenaga Ahli</label>
                        <input type="text" class="form-control" id="nama_tenaga_ahli" name="nama_tenaga_ahli" placeholder="Masukkan Nama Tenaga Ahli" required>
                    </div>
                    <div class="mb-3">
                        <label for="keahlian" class="form-label">Keahlian</label>
                        <input type="text" class="form-control" id="keahlian" name="keahlian" placeholder="Masukkan Keahlian" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="tambah_tenaga_ahli">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include 'layout/footer.php'; // File untuk CRUD tenaga ahli 
?>