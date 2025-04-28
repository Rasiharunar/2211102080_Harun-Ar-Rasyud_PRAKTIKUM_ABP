<?php 
require_once 'config.php';
 
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    Created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
 
if (mysqli_query($conn, $sql)) {
    echo "Tabel users berhasil dibuat";
} else {
    echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
?>