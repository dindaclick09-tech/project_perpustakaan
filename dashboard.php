<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
include "config/koneksi.php";

// Logika Pencarian Buku
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = mysqli_real_escape_string($koneksi, $_GET['cari']);
    $query = mysqli_query($koneksi, "SELECT * FROM buku WHERE judul_buku LIKE '%$keyword%' OR penulis LIKE '%$keyword%' OR kategori LIKE '%$keyword%' ORDER BY id DESC");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mini Digital Library</title>
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
        .navbar-custom {
            background-color: #efe7ec;
            border-radius: 15px;
            padding: 15px 20px;
        }
        .table thead th {
            background-color: #efe7ec !important;
            color: #4a3b4c;
            border: none;
        }
        .btn-custom {
            background-color: #8c708f;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #785a7b;
            color: white;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #e0d2dc;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="main-card p-4 p-md-5">
            
            <!-- Navbar Atas -->
            <div class="navbar-custom d-flex justify-content-between align-items-center mb-4 shadow-sm">
                <div>
                    <h4 class="fw-bold mb-0 text-dark"><i class="bi bi-book-half"></i> Mini Digital Library</h4>
                    <small class="text-muted">Halo, <strong><?php echo $_SESSION['user']; ?></strong></small>
                </div>
                <div>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>

            <!-- Konten Daftar Buku & Kolom Pencarian -->
            <div class="card border-0 shadow-sm rounded-4 p-4" style="background-color: #ffffff;">
                
                <!-- Baris Atas: Judul, Search Bar, & Tombol Tambah -->
                <div class="row align-items-center mb-4 g-3">
                    <div class="col-md-4">
                        <h5 class="fw-bold mb-0" style="color: #4a3b4c;">Daftar Koleksi Buku</h5>
                    </div>
                    
                    <!-- Form Kolom Pencarian -->
                    <div class="col-md-5">
                        <form action="" method="GET" class="d-flex gap-2">
                            <input type="text" name="cari" class="form-control form-control-sm" placeholder="Cari judul, penulis, atau kategori..." value="<?php echo htmlspecialchars($keyword); ?>">
                            <button type="submit" class="btn btn-custom btn-sm px-3"><i class="bi bi-search"></i></button>
                            <?php if (!empty($keyword)) { ?>
                                <a href="dashboard.php" class="btn btn-secondary btn-sm" title="Reset Pencarian"><i class="bi bi-arrow-counterclockwise"></i></a>
                            <?php } ?>
                        </form>
                    </div>

                    <!-- Tombol Tambah Buku -->
                    <div class="col-md-3 text-md-end">
                        <a href="tambah_buku.php" class="btn btn-custom btn-sm shadow-sm w-100"><i class="bi bi-plus-lg"></i> Tambah Buku Baru</a>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="12%">Sampul</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Status Stok</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    if ($row['stok'] > 0) {
                                        $status = '<span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Tersedia (' . $row['stok'] . ')</span>';
                                    } else {
                                        $status = '<span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">Habis</span>';
                                    }
                            ?>
                                    <tr>
                                        <td class="text-center fw-medium"><?php echo $no++; ?></td>
                                        <td>
                                            <img src="uploads/<?php echo $row['sampul']; ?>" alt="Sampul" style="width: 45px; height: 60px; object-fit: cover;" class="rounded shadow-sm">
                                        </td>
                                        <td class="fw-medium"><?php echo htmlspecialchars($row['judul_buku']); ?></td>
                                        <td class="text-muted"><?php echo htmlspecialchars($row['kategori']); ?></td>
                                        <td><?php echo htmlspecialchars($row['penulis']); ?></td>
                                        <td class="text-center"><?php echo $row['tahun_terbit']; ?></td>
                                        <td class="text-center"><?php echo $status; ?></td>
                                        <td class="text-center">
                                            <a href="edit_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm text-warning border" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="hapus_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-light btn-sm text-danger border" onclick="return confirm('Yakin ingin menghapus buku ini?')" title="Hapus"><i class="bi bi-trash-fill"></i></a>
                                        </td>
                                    </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-muted py-5">Tidak ada data buku yang ditemukan.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>