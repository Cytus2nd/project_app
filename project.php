<?php
session_start();
$title = 'Daftar Project';
include 'layout/header.php';
include 'backend/sc_project.php';
$sql = "SELECT * FROM proyek";
$result = $conn->query($sql);
?>
<div class="container mt-4">
    <section>
        <h3>Daftar Project</h3>
        <p><a class="text-decoration-none text-dark" href="index.php">Halaman Utama</a> > <a class="text-decoration-none text-dark" href="project.php">Project</a></p>
        <button type="button" class="btn btn-primary mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#modalTambahPr">Tambah Project</button>
        <table class="table table-bordered table-light table-striped" id="tabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Project</th>
                    <th>RAB</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php $no = 1; ?>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_proyek']); ?></td>
                            <td><?= htmlspecialchars($row['rab']); ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_mulai'])); ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_selesai'])); ?></td>
                            <td class="text-center">
                                <a class="btn btn-primary" href="detail_project.php?id=<?= $row['id']; ?>">Detail Project</a>
                                <a href="rab.php?id=<?= $row['id']; ?>" class="btn btn-info mb-1">Lihat RAB</a>
                                <button type="button" class="btn btn-success mb-1" data-bs-toggle="modal" data-bs-target="#modalUbahPr<?= $row['id']; ?>">Ubah Project</button>
                                <button type="button" class="btn btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#modalHapusPr<?= $row['id']; ?>">Hapus Project</button>
                            </td>
                        </tr>

                        <!-- modal ubah -->
                        <div class="modal fade" id="modalUbahPr<?= $row['id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Project</h1>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST">
                                            <input type="hidden" name="id_project" value="<?= $row['id']; ?>">
                                            <div class="mb-3">
                                                <label for="nama_proyek" class="form-label">Nama Project</label>
                                                <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" value="<?= htmlspecialchars($row['nama_proyek']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?= htmlspecialchars($row['deskripsi']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" value="<?= date('Y-m-d', strtotime($row['tanggal_mulai'])); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" value="<?= date('Y-m-d', strtotime($row['tanggal_selesai'])); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="rab_ubah" class="form-label">RAB</label>
                                                <input type="number" class="form-control" id="rab_ubah" name="rab_ubah" required value="<?= htmlspecialchars($row['rab']); ?>">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="modalHapusPr<?= $row['id']; ?>" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data Project</h1>
                                    </div>
                                    <div class="modal-body">
                                        <p>Yakin Hapus Data berikut ini?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form method="POST">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada Project yang tersedia</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPr" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Project Baru</h1>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <input type="hidden" name="id_user" value="1">
                    <div class="mb-3">
                        <label for="nama_proyek">Nama Project</label>
                        <input type="text" name="nama_proyek" id="nama_proyek" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rab_awal" class="form-label">RAB</label>
                        <input type="number" class="form-control" id="rab_awal" name="rab_awal" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php' ?>