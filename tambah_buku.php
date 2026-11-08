<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">Form Tambah Buku Baru</h4>
            </div>
            <div class="card-body">
                <!-- Atribut enctype="multipart/form-data" WAJIB ADA untuk upload file -->
                <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Teknologi, Novel, Sejarah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control" placeholder="Contoh: 2023" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" placeholder="Jumlah stok buku" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sampul Buku (.jpg / .png, Max 2MB)</label>
                        <input type="file" name="sampul" class="form-control" accept=".jpg, .jpeg, .png" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-primary">Simpan Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>