<?php
session_start();
$title = 'Profile';
include 'layout/header.php';

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_manajemen_proyek"; // Ganti sesuai database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user']; // Mengambil id_user dari session

// Ambil data pengguna berdasarkan id_user
$sql = "SELECT * FROM users WHERE id_user=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user); // Menggunakan id_user dalam query
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = $_POST['field']; // Menentukan field yang akan diubah
    $value = $_POST['value']; // Nilai baru dari input form

    // Daftar kolom yang diizinkan untuk diubah
    $allowed_fields = ['nama', 'username', 'password'];

    if (in_array($field, $allowed_fields)) {
        if ($field === 'password') {
            // Jika password diubah, kita hash terlebih dahulu
            $value = password_hash($value, PASSWORD_BCRYPT);
        }

        // Query untuk mengupdate field yang dipilih menggunakan id_user
        $sql_update = "UPDATE users SET $field = ? WHERE id_user = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $value, $id_user); // Menggunakan id_user untuk update

        if ($stmt_update->execute()) {
            echo "<script>
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data Berhasil diubah.',
                    icon: 'success',
                    timer: 8000,
                    showConfirmButton: true
                }).then(function() {
                    window.location = 'user.php';  
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Data Gagal diubah.',
                    icon: 'error',
                    timer: 8000,
                    showConfirmButton: true
                }).then(function() {
                    window.location = 'user.php';  
                });
            </script>";
        }
    } else {
        echo "<script>alert('Kolom tidak diizinkan untuk diubah!'); window.location.href = 'user.php';</script>";
    }
}

$conn->close();
?>

<div class="container" style="margin-top: 3rem;">
    <h2 class="text-center">Profil Pengguna</h2>
    <div class="card mt-4">
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Nama</th>
                    <td><?php echo htmlspecialchars($user_data['nama']); ?></td>
                    <td>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNama">Ubah</button>
                    </td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo htmlspecialchars($user_data['username']); ?></td>
                    <td>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUsername">Ubah</button>
                    </td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td>**************</td>
                    <td>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPassword">Ubah</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- Tombol Logout -->
    <a class="btn btn-danger mt-3 btn-block w-100" href="logout.php">Logout</a>

    <!-- Modal untuk Nama -->
    <div class="modal fade" id="modalNama" tabindex="-1" aria-labelledby="modalNamaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNamaLabel">Ubah Nama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="field" value="nama">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="value" class="form-control" id="nama" value="<?php echo htmlspecialchars($user_data['nama']); ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Username -->
    <div class="modal fade" id="modalUsername" tabindex="-1" aria-labelledby="modalUsernameLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsernameLabel">Ubah Username</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="field" value="username">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="value" class="form-control" id="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal untuk Password -->
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPasswordLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="field" value="password">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" name="value" class="form-control" id="password" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'layout/footer.php';
?>