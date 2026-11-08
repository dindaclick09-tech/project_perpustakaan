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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #dfd5dc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .main-card {
            background-color: #f7f2ef;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .card-header-custom {
            background-color: #efe7ec;
            color: #4a3b4c;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            padding: 20px;
            border-bottom: none;
        }
        .btn-custom {
            background-color: #8c708f;
            color: white;
            border: none;
            border-radius: 10px;
        }
        .btn-custom:hover {
            background-color: #785a7b;
            color: white;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #e0d2dc;
            padding: 10px 15px;
        }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5" style="max-width: 650px;">
        <div class="main-card shadow p-4 p-md-5">
            <div class="card-header-custom mb-4 text-center">
                <h4 class="fw-bold mb-0"><i class="bi bi-plus-circle-fill"></i> Form Tambah Buku Baru</h4>
            </div>
            <div>
                <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Judul Buku</label>
                        <input type="text" name="judul_buku" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Teknologi, Novel, Sejarah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Penulis</label>
                        <input type="text" name="penulis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" class="form-control" placeholder="Contoh: 2023" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">Stok</label>
                        <input type="number" name="stok" class="form-control" placeholder="Jumlah stok buku" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary">Sampul Buku (.jpg / .png, Max 2MB)</label>
                        <input type="file" name="sampul" class="form-control" accept=".jpg, .jpeg, .png" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="dashboard.php" class="btn btn-secondary px-4 py-2 rounded-3">Kembali</a>
                        <button type="submit" name="simpan" class="btn btn-custom px-4 py-2 shadow-sm">Simpan Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>