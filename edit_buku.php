<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

include "config/koneksi.php";

// Ambil ID dari URL (metode GET)
if (!isset($_GET['id'])) {
    header("location: dashboard.php");
    exit();
}

$id = (int)$_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE id = $id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data buku tidak ditemukan!'); window.location='dashboard.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Form Edit Data Buku</h4>
            </div>
            <div class="card-body">
                <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
                    <!-- Kirim ID secara tersembunyi (hidden) -->
                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                    <input type="hidden" name="sampul_lama" value="<?php echo $data['sampul']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku" class="form-control" value="<?php echo htmlspecialchars($data['judul_buku']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="<?php echo htmlspecialchars($data['kategori']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="<?php echo htmlspecialchars($data['penulis']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control" value="<?php echo $data['tahun_terbit']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="<?php echo $data['stok']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampul Buku Saat Ini:</label><br>
                        <img src="uploads/<?php echo $data['sampul']; ?>" alt="Sampul" style="width: 70px; height: 90px; object-fit: cover;" class="rounded shadow-sm mb-2"><br>
                        <small class="text-muted">Abaikan jika tidak ingin mengganti gambar sampul.</small>
                        <input type="file" name="sampul" class="form-control mt-2" accept=".jpg, .jpeg, .png">
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="update" class="btn btn-warning">Update Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>