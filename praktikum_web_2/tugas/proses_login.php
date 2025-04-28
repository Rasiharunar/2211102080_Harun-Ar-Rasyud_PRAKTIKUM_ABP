<?php 
    require_once 'config.php';

    session_start();

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = clean_input($_POST['username']);
        $password = clean_input($_POST['password']);
         if (empty($username) || empty($password)) {
        redirect('login.php?error=Username dan password harus diisi');
    }
    
     $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1){
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])){
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            redirect('dashboard.php');
        } else {
            redirect('login.php?error=Username atau password salah');
        }
    }else{
        redirect('login.php?error=Username atau password tidak terdaftar');
    }

}else{
    redirect('login.php');
}
?>