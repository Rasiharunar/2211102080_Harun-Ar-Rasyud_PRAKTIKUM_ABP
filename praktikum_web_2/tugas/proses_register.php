<?php 
require_once 'config.php';
session_start();


if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nama = clean_input($_POST['nama']);
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);
    
if(empty($nama)||empty($username)||empty($email)||empty($password)||empty($confirm_password)){
    redirect('register.php?error=Semua data harus diisi');

}

if($password !== $confirm_password){
    redirect('register.php?error=Password dan Konfirmasi Password tidak cocok');
}

$check_query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($result) > 0) {
    redirect('register.php?error=Username sudah digunakan');    
}
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert_query = "INSERT INTO users (nama, username, email, password) VALUES ('$nama', '$username', '$email', '$hashed_password')";

if (mysqli_query($conn, $insert_query)) {
    redirect('login.php');
}else{
    redirect('register.php?error=Gagal membuat akun');
}

}else{
    redirect('register.php');
}

?>