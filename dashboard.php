<?php
session_start();
// Cek apakah user sudah login atau belum
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

// Panggil file koneksi database
include "config/koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mini Digital Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Mini Digital Library</a>
            <div class="d-flex">
                <span class="navbar-text me-3 text-white">Halo, <strong><?php echo $_SESSION['user']; ?></strong></span>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h5 class="mb-0">Daftar Koleksi Buku</h5>
                <a href="tambah_buku.php" class="btn btn-primary btn-sm">+ Tambah Buku Baru</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark text-center">
                            <thead class="table-dark text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Sampul</th>
                                <th>Judul Buku</th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Tahun</th>
                                <th>Status Stok</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY id DESC");
                            if (mysqli_num_rows($query) > 0) {
                                while ($row = mysqli_fetch_assoc($query)) {
                                    // Logika status ketersediaan buku berdasarkan stok (sesuai modul PDF)
                                    if ($row['stok'] > 0) {
                                        $status = '<span class="badge bg-success">Tersedia (' . $row['stok'] . ')</span>';
                                    } else {
                                        $status = '<span class="badge bg-danger">Dipinjam / Habis</span>';
                                    }
                            ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td class="text-center">
                                            <img src="uploads/<?php echo $row['sampul']; ?>" alt="Sampul" style="width: 50px; height: 70px; object-fit: cover;" class="rounded shadow-sm">
                                        </td>
                                        <td><?php echo htmlspecialchars($row['judul_buku']); ?></td>
                                        <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                                        <td><?php echo htmlspecialchars($row['penulis']); ?></td>
                                        <td class="text-center"><?php echo $row['tahun_terbit']; ?></td>
                                        <td class="text-center"><?php echo $status; ?></td>
                                        <td class="text-center">
                                            <a href="edit_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="hapus_buku.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                                        </td>
                                    </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center text-muted py-4">Belum ada data buku yang tersimpan.</td></tr>';
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