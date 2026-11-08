<?php
session_start();
include "config/koneksi.php";

$username = $_POST['username'];
$password = md5($_POST['password']); // Menggunakan MD5 menyesuaikan insert SQL di atas
$remember = isset($_POST['remember']) ? $_POST['remember'] : '';

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $_SESSION['user'] = $username;

    // Jika checklist Remember Me dicentang, buat Cookie selama 1 hari
    if ($remember == 'on') {
        setcookie("cookie_user", $username, time() + (86400 * 1), "/");
    }

    header("location: dashboard.php");
} else {
    echo "<script>alert('Username atau Password salah!'); window.location='index.php';</script>";
}
?>