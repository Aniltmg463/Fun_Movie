<?php
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Data</title>
  <style>
    .container {
      width: 50%;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px; /* Add some space between the container and the table */
    }

    table td, table th {
      border: 1px solid black;
      padding: 10px;
    }

    .link-buttons {
      display: flex;
      margin-top: 10px;
    }

    .link-buttons a, .delete-button {
      margin-right: 10px; /* Adjust spacing between buttons as needed */
      text-decoration: none;
      padding: 8px 12px;
      border: 1px solid #007bff; /* Button border color */
      border-radius: 5px;
      background-color: #007bff; /* Button background color */
      color: #fff; /* Button text color */
    }

    .link-buttons a:hover, .delete-button:hover {
      background-color: #0056b3; /* Button background color on hover */
      border-color: #0056b3; /* Button border color on hover */
    }
  </style>
</head>
<body>
<div class="container">
  <table border="1" cellspacing="0" cellpadding="10">
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Image</th>
      <th>Action</th> <!-- New column for delete button -->
    </tr>
    <?php
    $i = 1;
    $rows = mysqli_query($con, "SELECT * FROM tb_upload ORDER BY id DESC");
    foreach ($rows as $row) :
      ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $row["name"]; ?></td>
        <td> <img src="img/<?php echo $row["image"]; ?>" width="200" title="<?php echo $row['image']; ?>"> </td>
        <td><a href="delete_image.php?id=<?php echo $row['id']; ?>" class="delete-button">Delete</a></td> <!-- Delete button -->
      </tr>
    <?php endforeach; ?>
  </table>
  <div class="link-buttons">
    <a href="cash_payment.php">Upload Image File</a>
    <a href="index.php">Go To Homepage</a>
  </div>
</div>
</body>
</html>
