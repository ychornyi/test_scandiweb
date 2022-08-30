<!DOCTYPE html>
<html>

<head>
    <?php include '../urls.php'; ?>
    <title>Add Product</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="addpage.css">
    <?php
    //mysql connection
    $database = new mysqli("localhost", "root", "", "project");
    if ($database->connect_error) {
        die('Connect Error (' . $database->connect_errno . ') ' . $database->connect_error);
    }
    //sku_array and sku_array_len creation
    $array = [];
    $array1 = [];
    $array2 = [];
    $array3 = [];
    $stmt = $database->prepare("SELECT sku FROM dvds");
    $stmt->execute();
    foreach ($stmt->get_result() as $row) {
        $array1[] = $row['sku'];
    }
    $stmt = $database->prepare("SELECT sku FROM books");
    $stmt->execute();
    foreach ($stmt->get_result() as $row) {
        $array2[] = $row['sku'];
    }
    $stmt = $database->prepare("SELECT sku FROM furniture");
    $stmt->execute();
    foreach ($stmt->get_result() as $row) {
        $array3[] = $row['sku'];
    }
    $array = array_merge($array1, $array2, $array3);
    $arraylen = count($array);
    ?>
    <script>
        //checking if SKU already exists in array
        function check() {
            var x = <?php echo json_encode($array); ?>;
            var checkerx = 0;
            for (i = 0; i < "<?php echo $arraylen ?>"; i++) {
                if ((document.getElementById("sku").value) == x[i]) {
                    checkerx += 1;
                }
            }
            if (checkerx > 0) {
                document.getElementById("sku").setCustomValidity('This SKU already exists!');
            } else {
                document.getElementById("sku").setCustomValidity('');
            }
        }
    </script>
</head>

<body>
    <form action="<?php echo $addscripturl ?>" method="POST" id="#product_form">
        <h2>Product Add</h2>
        <input id="submitbutton" type="submit" value="Save"></input>
        <button id="cancelbutton" onclick="gotomainpage()" type="button">Cancel</button>
        <script>
            function gotomainpage() {
                location.href = "<?php echo $mainpageurl ?>";
            }
        </script>
        <p>SKU <input id="sku" onchange="check()" required autocomplete="off" type="text" name="SKU" pattern="^[^\s]+(\s.*)?$" /></p>
        <p>Name <input id="name" required autocomplete="off" type="text" name="Name" pattern="^[^\s]+(\s.*)?$" /></p>
        <p>Price($) <input id="price" required autocomplete="off" type="text" name="Price" pattern="[0-9]{1,9}" /></p>
        <label for="productType">Type Switcher:</label>
        <select required name="type" id="productType">
            <option>DVD</option>
            <option>Book</option>
            <option>Furniture</option>
        </select>
        <script src="onchange.js" type="text/javascript"></script>
        <p>Size(MB)<input id="size" required autocomplete="off" type="text" name="MB" pattern="[0-9]{1,9}"></p>
        <p hidden>Weight(KG)<input id="weight" autocomplete="off" type="text" name="Weight" pattern="[0-9]{1,9}"></p>
        <p hidden>Height(CM)<input id="height" autocomplete="off" type="text" name="Height" pattern="[0-9]{1,9}"></p>
        <p hidden>Width(CM)<input id="width" autocomplete="off" type="text" name="Width" pattern="[0-9]{1,9}"></p>
        <p hidden>Length(CM)<input id="length" autocomplete="off" type="text" name="Length" pattern="[0-9]{1,9}"></p>
    </form>
</body>

</html>