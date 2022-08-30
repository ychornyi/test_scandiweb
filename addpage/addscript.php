<!DOCTYPE html>
<html>

<head>
  <?php include '../urls.php'; ?>
  <title>---</title>
  <meta charset="utf-8" http-equiv="Refresh" content="0; url=<?php echo $mainpageurl ?>" />
</head>

<body>
  <?php
  //mysql connection
  $database = new mysqli("localhost", "root", "", "project");
  if ($database->connect_error) {
      die('Connect Error (' . $database->connect_errno . ') ' . $database->connect_error);
  }
  //getting all values 
  $sku = $_POST["SKU"];
  $name = $_POST["Name"];
  $price = floatval($_POST["Price"]);
  $producttype = $_POST["type"];
  $inserttype = "INSERT INTO indexes(type) values ('$producttype')";
  $database->query($inserttype);
  $getidrequest = "select id from indexes order by id desc limit 1";
  $id = $database->query($getidrequest)->fetch_assoc()['id'];
  switch ($producttype) {
    case 'DVD':
      $MB = $_POST["MB"];
      $ins = "INSERT INTO dvds (id, sku, name, price, MB) VALUES ($id, '$sku', '$name', '$price', '$MB')";
      break;
    case 'Book':
      $Weight = $_POST["Weight"];
      $ins = "INSERT INTO books (id, sku, name, price, weight) VALUES ($id, '$sku', '$name', $price, '$Weight')";
      break;
    default:
      $Height = $_POST["Height"];
      $Width = $_POST["Width"];
      $Length = $_POST["Length"];
      $ins = "INSERT INTO furniture (id, sku, name, price, height, width, length) VALUES ($id, '$sku', '$name', $price, '$Height', '$Width', '$Length')";
  }
  //adding values to db
  $database->query($ins);
  $database->close();
  ?>
</body>

</html>