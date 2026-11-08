<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

include "config/koneksi.php";

if (isset($_POST['update'])) {
    $id           = (int)$_POST['id'];
    $judul_buku   = mysqli_real_escape_string($koneksi, $_POST['judul_buku']);
    $kategori     = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $penulis      = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $tahun_terbit = (int)$_POST['tahun_terbit'];
    $stok         = (int)$_POST['stok'];
    $sampul_lama  = $_POST['sampul_lama'];

    // Cek apakah user mengunggah file gambar baru
    if ($_FILES['sampul']['error'] === 4) {
        // Jika tidak upload gambar baru, gunakan gambar lama
        $nama_file_baru = $sampul_lama;
    } else {
        // Jika ada upload gambar baru
        $nama_file   = $_FILES['sampul']['name'];
        $ukuran_file = $_FILES['sampul']['size'];
        $tmp_file    = $_FILES['sampul']['tmp_name'];
        
        $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png'];
        $x = explode('.', $nama_file);
        $ekstensi = strtolower(end($x));
        $max_size = 2 * 1024 * 1024; // 2MB

        if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            if ($ukuran_file <= $max_size) {
                $nama_file_baru = uniqid() . '-' . $nama_file;
                $tujuan = 'uploads/' . $nama_file_baru;

                if (move_uploaded_file($tmp_file, $tujuan)) {
                    // Hapus file gambar lama dari folder uploads (jika bukan file default)
                    if (file_exists('uploads/' . $sampul_lama) && $sampul_lama != 'default.jpg') {
                        unlink('uploads/' . $sampul_lama);
                    }
                } else {
                    echo "<script>alert('Gagal mengunggah file baru!'); window.location='edit_buku.php?id=$id';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location='edit_buku.php?id=$id';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Ekstensi file tidak diizinkan! Harap format .jpg atau .png.'); window.location='edit_buku.php?id=$id';</script>";
            exit();
        }
    }

    // Query Update Database
    $query = "UPDATE buku SET 
                judul_buku = '$judul_buku', 
                kategori = '$kategori', 
                penulis = '$penulis', 
                tahun_terbit = '$tahun_terbit', 
                stok = '$stok', 
                sampul = '$nama_file_baru' 
              WHERE id = $id";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data buku berhasil diperbarui!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui database!'); window.location='edit_buku.php?id=$id';</script>";
    }
}
?>