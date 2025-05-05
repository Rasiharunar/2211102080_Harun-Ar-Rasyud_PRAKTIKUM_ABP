<?php 
@include_once("config.php");

$result = mysqli_query($mysql, "SELECT * FROM library ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
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
            max-width: 1200px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4caf50;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }
        th {
            background-color: #4caf50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        img {
            border-radius: 5px;
        }
        a {
            color: #4caf50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Library Collection</h1>
        <button type="button" onclick="location.href='add.php'">Add New Book</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Count</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                $no = 1;
                while($user_data = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<td>". $no . "</td>";
                    $no++;
                    echo "<td><img src='picture/" . $user_data['picture'] . "' width='100'></td>";
                    echo "<td>" . $user_data['name'] . "</td>";
                    echo "<td>" . $user_data['category'] . "</td>";
                    echo "<td>" . $user_data['publisher'] . "</td>";
                    echo "<td>" . $user_data['count'] . "</td>";
                    echo "<td>
                    <a href='edit.php?id=$user_data[id]'>Edit</a> | 
                    <a href='delete.php?id=$user_data[id]' onclick=\"return confirm('Are you sure you want to delete this item?')\">Delete</a>
                    </td></tr>";
                }
            ?>
            </tbody>        
        </table>   
    </div>
</body>
</html>