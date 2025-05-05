<?php
include_once("config.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $publisher = $_POST['publisher'];
    $count = $_POST['count'];

    $target_dir = "picture/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);

    $picture = $_FILES['picture']['name'];
    $result = mysqli_query($mysql, "INSERT INTO library(picture, name, category, publisher, count) VALUES('$picture', '$name', '$category', '$publisher', '$count')");

    // Redirect to index.php after successfully adding data
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            padding: 30px;
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
        <h1>Add New Book</h1>
        <a href="index.php" class="home-btn">Home</a>

        <form action="add.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="picture">Picture</label>
                <input type="file" class="form-control-file" id="picture" name="picture" required>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Category</label>
                <input type="text" class="form-control" name="category" required>
            </div>
            <div class="form-group">
                <label>Publisher</label>
                <input type="text" class="form-control" name="publisher" required>
            </div>
            <div class="form-group">
                <label>Count</label>
                <input type="number" class="form-control" name="count" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Add New Book</button>
        </form>
    </div>
</body>
</html>