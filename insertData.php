<?php
header('content-type: text');
$menu = file_get_contents('menu.json');

$data = json_decode($menu, true);

$connection = new mysqli('localhost','root', '1234','menu');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "INSERT INTO `items` 
(`id`, `name`, `image`, `price`, `images`, `desc`, `is_variable`, `variables`, `category`, `sub_category`, `precache`)
 VALUES ('b', 'a', 'a', '11', 'a', 'a', '1', 'aa', 'a', 'a', 'a');";

 foreach($data as $key => $value) {
    $id = $value['id'];
    $name = $value['name'];
    $image = $value['image'];
    $price = $value['price'] ? "'$value[price]'" : 'null';
    $images = $value['images'] ? "'".json_encode($value['images'],JSON_UNESCAPED_UNICODE)."'" : 'null';
    $desc = $value['desc'];
    $is_variable = $value['isVariable'] ?? '0';
    $variables = $value['variables'] ? "'".json_encode($value['variables'],JSON_UNESCAPED_UNICODE)."'" : "''";
    $category = $value['category'];
    $sub_category = $value['subCategory'];
    $precache = $value['precache'];
    $sql = "INSERT INTO `items` 
    (`id`, `name`, `image`, `price`, `images`, `desc`, `is_variable`, `variables`, `category`, `sub_category`, `precache`)
     VALUES ('$id', '$name', '$image', $price, $images, '$desc', '$is_variable', $variables, '$category', '$sub_category', '$precache');\n";
    try {
        if ($connection->query($sql) === TRUE) {
            echo "New record created successfully\n";
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    } catch (Exception $e) {
        echo $sql. "\n" . $e->getMessage()."\n\n";
    }
    
 }