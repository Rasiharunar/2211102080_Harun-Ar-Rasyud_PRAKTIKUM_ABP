<?php
// Include database connection file
include_once("config.php");

// Check if form is submitted for update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $publisher = $_POST['publisher'];
    $count = $_POST['count'];

    // Ambil gambar lama dari input hidden
    $old_picture = $_POST['old_picture'];

    // Periksa apakah pengguna mengunggah gambar baru
    if ($_FILES['picture']['name']) {
        $picture = $_FILES['picture']['name'];
        $target_dir = "picture/";
        $target_file = $target_dir . basename($_FILES["picture"]["name"]);

        // Pindahkan gambar baru ke folder
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
    } else {
        // Jika tidak ada gambar baru, gunakan gambar lama
        $picture = $old_picture;
    }

    // Update data ke database
    $result = mysqli_query($mysql, "UPDATE library SET picture='$picture', name='$name', category='$category', publisher='$publisher', count='$count' WHERE id=$id");

    // Redirect ke homepage setelah update
    header("Location: index.php");
}

// Ambil data berdasarkan ID
$id = $_GET['id'];
$result = mysqli_query($mysql, "SELECT * FROM library WHERE id=$id");

while ($user_data = mysqli_fetch_array($result)) {
    $picture = $user_data['picture'];
    $name = $user_data['name'];
    $category = $user_data['category'];
    $publisher = $user_data['publisher'];
    $count = $user_data['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Data</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background: linear-gradient(to right, #f0f4c3, #c5e1a5);
      color: #333;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 30px 30px 40px 30px;
    }
    h1 {
      text-align: center;
      color: #4caf50;
      margin-bottom: 30px;
    }
    a.home-btn {
      display: inline-block;
      margin-bottom: 20px;
      background-color: #8bc34a;
      color: white;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 700;
      transition: background-color 0.3s;
    }
    a.home-btn:hover {
      background-color: #7cb342;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
    }
    label {
      font-weight: 700;
      margin-bottom: 6px;
      color: #4caf50;
      user-select: none;
    }
    input[type="text"],
    input[type="number"],
    input[type="file"] {
      padding: 10px 12px;
      font-size: 16px;
      border: 2px solid #c5e1a5;
      border-radius: 6px;
      transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="file"]:focus {
      border-color: #4caf50;
      outline: none;
      box-shadow: 0 0 8px #a5d6a7cc;
    }
    img.preview {
      border-radius: 8px;
      max-width: 150px;
      align-self: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    button {
      background-color: #4caf50;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 12px 20px;
      font-size: 18px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-weight: 700;
      user-select: none;
    }
    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Edit Book</h1>
    <a href="index.php" class="home-btn">Home</a>

    <form name="update_user" method="post" action="edit.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?php echo $id; ?>" />
      <input type="hidden" name="old_picture" value="<?php echo $picture; ?>" />

      <div class="form-group">
        <label>Current Picture</label>
        <img src="picture/<?php echo $picture; ?>" alt="Current Picture" class="preview" />
      </div>

      <div class="form-group">
        <label>Change Picture</label>
        <input type="file" name="picture" />
      </div>

      <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required />
      </div>

      <div class="form-group">
        <label>Category</label>
        <input type="text" name="category" value="<?php echo htmlspecialchars($category); ?>" required />
      </div>

      <div class="form-group">
        <label>Publisher</label>
        <input type="text" name="publisher" value="<?php echo htmlspecialchars($publisher); ?>" required />
      </div>

      <div class="form-group">
        <label>Count</label>
        <input type="number" name="count" value="<?php echo htmlspecialchars($count); ?>" required min="0" />
      </div>

      <button type="submit" name="update">Update</button>
    </form>
  </div>
</body>
</html>
