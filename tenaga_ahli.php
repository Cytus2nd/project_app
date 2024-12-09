<?php
session_start();
$title = "Tenaga Ahli";
include 'layout/header.php'; // File untuk CRUD tenaga ahli
include 'backend/sc_tenaga_ahli.php'; // File untuk CRUD tenaga ahli

// Mengambil ID user yang sedang login
// $id_user = $_SESSION['id'];

// Mengambil data tenaga ahli yang hanya dibuat oleh user yang sedang login
$sql_tenaga_ahli = "SELECT * FROM tenaga_ahli";
// WHERE id_user = $id_user
$result_tenaga_ahli = $conn->query($sql_tenaga_ahli);
?>

<div class="container mt-4">
    <h3>Daftar Tenaga Ahli</h3>
    <!-- Tombol untuk menambahkan tenaga ahli -->
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
            <?php $no = 1; ?>
            <?php while ($row = $result_tenaga_ahli->fetch_assoc()) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_tenaga_ahli']); ?></td>
                    <td><?= htmlspecialchars($row['keahlian']); ?></td>
                    <td>
                        <!-- Toggle Button for Status -->
                        <button class="btn btn-sm <?= $row['status'] == 'aktif' ? 'btn-success' : 'btn-secondary' ?>"
                            data-bs-toggle="modal" data-bs-target="#modalUbahStatus<?= $row['id']; ?>">
                            <?= $row['status'] == 'aktif' ? 'Aktif' : 'Nonaktif'; ?>
                        </button>
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbahTenagaAhli<?= $row['id']; ?>">Ubah</button>

                        <!-- Delete Button -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapusTenagaAhli<?= $row['id']; ?>">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Ubah Tenaga Ahli -->
                <div class="modal fade" id="modalUbahTenagaAhli<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalUbahTenagaAhliLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalUbahTenagaAhliLabel">Ubah Tenaga Ahli</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="nama_tenaga_ahli" class="form-label">Nama Tenaga Ahli</label>
                                        <input type="text" class="form-control" id="nama_tenaga_ahli" name="nama_tenaga_ahli" value="<?= $row['nama_tenaga_ahli']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keahlian" class="form-label">Keahlian</label>
                                        <input type="text" class="form-control" id="keahlian" name="keahlian" value="<?= $row['keahlian']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="nonaktif" <?= $row['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Tenaga Ahli -->
                <div class="modal fade" id="modalHapusTenagaAhli<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalHapusTenagaAhliLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalHapusTenagaAhliLabel">Hapus Tenaga Ahli</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Yakin ingin menghapus tenaga ahli ini?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="hapus_tenaga_ahli">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Ubah Status -->
                <div class="modal fade" id="modalUbahStatus<?= $row['id']; ?>" tabindex="-1" aria-labelledby="modalUbahStatusLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalUbahStatusLabel">Ubah Status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="aktif" <?= $row['status'] == 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="nonaktif" <?= $row['status'] == 'nonaktif' ? 'selected' : ''; ?>>Nonaktif</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
include 'layout/footer.php'; // File untuk CRUD tenaga ahli 
?>