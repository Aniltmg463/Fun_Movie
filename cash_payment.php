<?php
// Include your database connection file (connect.php)
include('connect.php');

if(isset($_POST["submit"])){
    $name = $_POST["name"];
    if($_FILES["image"]["error"] == 4){
      echo
      "<script> alert('Image Does Not Exist'); </script>"
      ;
    }
    else{
      $fileName = $_FILES["image"]["name"];
      $fileSize = $_FILES["image"]["size"];
      $tmpName = $_FILES["image"]["tmp_name"];
  
      $validImageExtension = ['jpg', 'jpeg', 'png'];
      $imageExtension = explode('.', $fileName);
      $imageExtension = strtolower(end($imageExtension));
      if ( !in_array($imageExtension, $validImageExtension) ){
        echo
        "
        <script>
          alert('Invalid Image Extension');
        </script>
        ";
      }
      else if($fileSize > 1000000){
        echo
        "
        <script>
          alert('Image Size Is Too Large');
        </script>
        ";
      }
      else{
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;
  
        move_uploaded_file($tmpName, 'img/' . $newImageName);
        $query = "INSERT INTO tb_upload VALUES('', '$name', '$newImageName')";
        mysqli_query($con, $query);
        echo
        "
        <script>
          alert('Successfully Added');
          document.location.href = 'data.php';
        </script>
        ";
      }
    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Upload Image File</title>

      <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      width: 50%;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh; /* Makes the container take up the full height of the viewport */
}


    form {
      margin-bottom: 20px;
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 5px;
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="file"],
    button[type="submit"] {
      margin-bottom: 10px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 3px;
      width: 100%;
      box-sizing: border-box;
    }

    button[type="submit"] {
      background-color: #4caf50;
      color: #fff;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    a {
      display: inline-block;
      text-decoration: none;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border-radius: 3px;
    }

    a:hover {
      background-color: #0056b3;
    }
  </style>


    </head>
    <body>

    <div class="container">
      <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
        <label for="name">Name : </label>
        <input type="text" name="name" id = "name" required value=""> <br>
        <label for="image">Image : </label>
        <input type="file" name="image" id = "image" accept=".jpg, .jpeg, .png" value=""> <br> <br>
        <button type = "submit" name = "submit">Submit</button>
      </form>
      <br>
      <a href="data.php">Data</a>
      </div>
    </body>

  </html>
  