<?php 

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'praktikum_web_2';

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

// Fungsi untuk mengecek apakah user sudah login
function is_logged_in() {
    session_start();
    if (isset($_SESSION['username'])) {
        return true;
    }
    return false;
}

// Fungsi untuk redirect
function redirect($url) {
    header("Location: $url");
    exit();
}
?>