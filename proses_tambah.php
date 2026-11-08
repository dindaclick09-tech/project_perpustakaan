<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}

include "config/koneksi.php";

if (isset($_POST['simpan'])) {
    $judul_buku   = mysqli_real_escape_string($koneksi, $_POST['judul_buku']);
    $kategori     = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $penulis      = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $tahun_terbit = (int)$_POST['tahun_terbit'];
    $stok         = (int)$_POST['stok'];

    // Konfigurasi File Upload
    $nama_file    = $_FILES['sampul']['name'];
    $ukuran_file  = $_FILES['sampul']['size'];
    $tmp_file     = $_FILES['sampul']['tmp_name'];
    
    // Validasi Ekstensi File
    $ekstensi_diperbolehkan = ['jpg', 'jpeg', 'png'];
    $x = explode('.', $nama_file);
    $ekstensi = strtolower(end($x));

    // Validasi Ukuran File (Maksimal 2MB sesuai ketentuan PDF)
    $max_size = 2 * 1024 * 1024; 

    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        if ($ukuran_file <= $max_size) {
            // Berikan nama unik pada file agar tidak saling menimpa jika nama file sama
            $nama_file_baru = uniqid() . '-' . $nama_file;
            $tujuan = 'uploads/' . $nama_file_baru;

            if (move_uploaded_file($tmp_file, $tujuan)) {
                // Query Insert ke Database
                $query = "INSERT INTO buku (judul_buku, kategori, penulis, tahun_terbit, stok, sampul) 
                          VALUES ('$judul_buku', '$kategori', '$penulis', '$tahun_terbit', '$stok', '$nama_file_baru')";
                
                $result = mysqli_query($koneksi, $query);

                if ($result) {
                    echo "<script>alert('Data buku berhasil ditambahkan!'); window.location='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Gagal menyimpan ke database!'); window.location='tambah_buku.php';</script>";
                }
            } else {
                echo "<script>alert('Gagal mengunggah file gambar!'); window.location='tambah_buku.php';</script>";
            }
        } else {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.'); window.location='tambah_buku.php';</script>";
        }
    } else {
        echo "<script>alert('Ekstensi file tidak diizinkan! Harap unggah file .jpg atau .png.'); window.location='tambah_buku.php';</script>";
    }
}
?>