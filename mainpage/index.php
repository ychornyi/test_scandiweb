<!DOCTYPE html>
<html>

<head>
    <?php include '../urls.php'; ?>
    <title>MainPage</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mainpage.css">
    <?php
    $database = new mysqli("localhost", "root", "", "project");
    if ($database->connect_error) {
        die('Connect Error (' . $database->connect_errno . ') ' . $database->connect_error);
    }
    $indexestable = "SELECT * FROM indexes order by id desc";
    $indexesoutoftable = $database->prepare($indexestable);
    $indexesoutoftable->execute();
    $array = [];

    class DVD
    {
        public static $counter = 0;
        public $id = null, $sku = null, $name = null, $price = null, $mb = null;
        function __construct($id, $sku, $name, $price, $mb)
        {
            self::$counter++;
            $this->id = $id;
            $this->sku = $sku;
            $this->name = $name;
            $this->price = $price;
            $this->mb = $mb;
        }
    }
    class Book
    {
        public static $counter = 0;
        public $id = null, $sku = null, $name = null, $price = null, $weight = null;
        function __construct($id, $sku, $name, $price, $weight)
        {
            self::$counter++;
            $this->id = $id;
            $this->sku = $sku;
            $this->name = $name;
            $this->price = $price;
            $this->weight = $weight;
        }
    }
    class Furniture
    {
        public static $counter = 0;
        public $id = null, $sku = null, $name = null, $price = null, $height = null, $width = null, $length = null;
        function __construct($id, $sku, $name, $price, $height, $width, $length)
        {
            self::$counter++;
            $this->id = $id;
            $this->sku = $sku;
            $this->name = $name;
            $this->price = $price;
            $this->height = $height;
            $this->width = $width;
            $this->length = $length;
        }
    }
    $i = 0;
    foreach ($indexesoutoftable->get_result() as $row) {
        $i++;
        $id = $row['id'];
        switch ($row['type']) {
            case 'DVD':
                $sql = "SELECT * FROM dvds where id = " . " " . $id . " " . "limit 1";
                $result = $database->query($sql)->fetch_assoc();
                ${"element" . "$i"} = new DVD($id, $result['sku'], $result['name'], $result['price'], $result['mb']);
                $array[] = ${"element" . "$i"};
                break;
            case 'Book':
                $sql = "SELECT * FROM books where id = " . " " . $id . " " . "limit 1";
                $result = $database->query($sql)->fetch_assoc();
                ${"element" . "$i"} = new Book($id, $result['sku'], $result['name'], $result['price'], $result['weight']);
                $array[] = ${"element" . "$i"};
                break;
            default:
                $sql = "SELECT * FROM furniture where id = " . " " . $id . " " . "limit 1";
                $result = $database->query($sql)->fetch_assoc();
                ${"element" . "$i"} = new Furniture($id, $result['sku'], $result['name'], $result['price'], $result['height'], $result['width'], $result['length']);
                $array[] = ${"element" . "$i"};
        }
    }
    $counter = DVD::$counter + Book::$counter + Furniture::$counter;
    $database->close();
    ?>
</head>

<body>
    <form method="POST" action="<?php echo $deletescripturl ?>">
        <button type="button" onclick="gotoaddpage()" class="button">Add</button>
        <button type="submit" class="button">MASS DELETE</button>
        <script>
            function gotoaddpage() {
                location.href = "<?php echo $addpageurl ?>";
            }
        </script>
        <div class="w3-container">
            <?php
            for ($i = 0; $i < $counter; $i++) {
                $tempArrayOfi = $array[$i];
                switch (get_class($tempArrayOfi)) {
                    case 'DVD': ?>
                        <div class="uiblock">
                            <input type="checkbox" class="delete-checkbox" name="<?php echo "box" . $tempArrayOfi->id ?>">
                            <br><?php echo $tempArrayOfi->sku; ?></br>
                            <br><?php echo $tempArrayOfi->name; ?></br>
                            <br><?php echo $tempArrayOfi->price; ?> $</br>
                            <br>Size: <?php echo $tempArrayOfi->mb; ?> MB</br>
                        </div> <?php
                        break;
                    case 'Book': ?>
                        <div class="uiblock">
                            <input type="checkbox" class="delete-checkbox" name="<?php echo "box" . $tempArrayOfi->id ?>">
                            <br><?php echo $tempArrayOfi->sku; ?></br>
                            <br><?php echo $tempArrayOfi->name; ?></br>
                            <br><?php echo $tempArrayOfi->price; ?> $</br>
                            <br>Weight: <?php echo $tempArrayOfi->weight; ?> KG</br>
                        </div> <?php
                        break;
                    default: ?>
                        <div class="uiblock">
                            <input type="checkbox" class="delete-checkbox" name="<?php echo "box" . $tempArrayOfi->id ?>">
                            <br><?php echo $tempArrayOfi->sku; ?></br>
                            <br><?php echo $tempArrayOfi->name; ?></br>
                            <br><?php echo $tempArrayOfi->price; ?> $</br>
                            <br>Dimension: <?php echo $tempArrayOfi->height . " x " . $tempArrayOfi->width . " x    " . $tempArrayOfi->length; ?> CM</br>
                        </div> <?php
                        }
                    }
                                ?>
        </div>
    </form>
</body>

</html>