<!DOCTYPE html>
<html>

<head>
    <?php include '../urls.php'; ?>
    <title>---</title>
    <meta charset="utf-8" http-equiv="Refresh" content="0; url=<?php echo $mainpageurl ?>" />
</head>

<body>
    <?php
     $database = new mysqli("localhost", "root", "", "project");
     if ($database->connect_error) {
         die('Connect Error (' . $database->connect_errno . ') ' . $database->connect_error);
     }
    $indexestable = "SELECT * FROM indexes order by id desc limit 1";
    $x = $database->query($indexestable)->fetch_array()[0];
    for ($i = 1; $i <= $x; $i++) {
        if (isset($_POST["box" . "$i"])) {
            $indexDrop = "DELETE FROM indexes WHERE id = $i";
            $database->query($indexDrop);
        }
    }
    $database->close();
    ?>
</body>

</html>