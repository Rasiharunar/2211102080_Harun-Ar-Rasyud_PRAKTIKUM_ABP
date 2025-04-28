<?php 
require_once 'config.php'; 
session_start();

if(!isset($_SESSION['username'])){
    redirect('login.php');
}
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);


$nama_input="";
$umur_input="";
$status_dewasa="";
$pesan_error="";
$show_alert=false;
$alert_message = "";

if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['cek_kedewasaan'])){
    $nama_input = clean_input($_POST['nama']);
        $umur_input = clean_input($_POST['umur']);

        if(empty($nama_input) || empty($umur_input)){
            $pesan_error = "Semua data harus diisi";
        }elseif(!is_numeric($umur_input)){
            $pesan_error = "Umur harus berupa angka";
        }else{
            $umur_input = (int)$umur_input;
            if($umur_input >= 18){
                $status_dewasa = "Dewasa";
            }else{
                $status_dewasa = "Belum Dewasa";
            }
            $show_alert = true;
            $alert_message = "Nama: $nama_input <br>Umur: $umur_input tahun <br>Status: $status_dewasa";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        .profile {
            margin-bottom: 20px;
        }
        .profile p {
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            background: #e74c3c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background: #c0392b;
        }
    </style>
    <script>
        // Function to show alert with result
        function showResult() {
            <?php if($show_alert): ?>
                alert('<?php echo $alert_message; ?>');
            <?php endif; ?>
        }
        
        // Execute when the page loads
        window.onload = function() {
            showResult();
        };
    </script>
</head>
<body>
     <div class="container">
        <h2>Dashboard</h2>
        <div class="profile">
            <h3>Profil Pengguna</h3>
            <p><strong>Nama:</strong> <?php echo $user['nama']; ?></p>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        </div>
        <a href="logout.php" class="btn">Logout</a>
    </div>
    <br>
    <div class="container">
        <h3>Cek Kedewasaan</h3>
        
        <?php if (!empty($pesan_error)): ?>
            <div class="error"><?php echo $pesan_error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama : </label>
                <input type="text" id="nama" name="nama" value="<?php echo $nama_input; ?>" required>
            </div>
            <div class="form-group">
                <label for="umur">Umur : </label>
                <input type="number" id="umur" name="umur" value="<?php echo $umur_input; ?>" required>
            </div>
            <br>
            <button type="submit" name="cek_kedewasaan" class="btn btn-primary">CEK KEDEWASAAN</button>
        </form>
        
        <div class="links">
            <p>Perlu bimbingan kedewasaan? <a href="https://withink.pro">Kunjungi website kami</a></p>
        </div>
    </div>
</body>
</html>