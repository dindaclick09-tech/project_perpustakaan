<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

include "config/koneksi.php";

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Ambil nama file gambar berdasarkan ID sebelum datanya dihapus
    $query_cek = mysqli_query($koneksi, "SELECT sampul FROM buku WHERE id = $id");
    $data = mysqli_fetch_assoc($query_cek);

    if ($data) {
        $sampul = $data['sampul'];

        // Hapus file fisik dari folder uploads (kecuali gambar default)
        if (!empty($sampul) && file_exists('uploads/' . $sampul) && $sampul != 'default.jpg') {
            unlink('uploads/' . $sampul);
        }

        // Hapus data dari database MySQL
        $query_hapus = mysqli_query($koneksi, "DELETE FROM buku WHERE id = $id");

        if ($query_hapus) {
            echo "<script>alert('Data buku berhasil dihapus!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus data dari database!'); window.location='dashboard.php';</script>";
        }
    } else {
        header("location: dashboard.php");
    }
} else {
    header("location: dashboard.php");
}
?>