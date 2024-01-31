<?php
header('Content-Type: application/json; charset=utf-8');
$connection = new mysqli('localhost', 'root', '1234', 'menu');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
// $conditions = 1;
// if (isset($_GET['category']) && isset($_GET['sub_category']) && isset($_GET['is_variable'])) {
//     $conditions = "`category` = '{$_GET['category']}' AND `sub_category` = '{$_GET['sub_category']}' AND `is_variable` = '{$_GET['is_variable']}'";
// }
// elseif (isset($_GET['category']) && isset($_GET['is_variable'])) {
//     $conditions = "`category` = '{$_GET['category']}' AND `is_variable` = '{$_GET['is_variable']}'";
// }
// elseif (isset($_GET['sub_category']) && isset($_GET['is_variable'])) {
//     $conditions = "`sub_category` = '{$_GET['sub_category']}' AND `is_variable` = '{$_GET['is_variable']}'";
// }
// elseif (isset($_GET['category']) && isset($_GET['sub_category'])) {
//     $conditions = "`category` = '{$_GET['category']}' AND `sub_category` = '{$_GET['sub_category']}'";
// }
// elseif (isset($_GET['category'])) {
//     $conditions = "`category` = '{$_GET['category']}'";
// }
// elseif (isset($_GET['sub_category'])) {
//     $conditions = "`sub_category` = '{$_GET['sub_category']}'";
// }
// elseif (isset($_GET['is_variable'])) {
//     $conditions = "`is_variable` = '{$_GET['is_variable']}'";
// }



$valid = ['category' => '=', 'sub_category' => '=', 'is_variable' => '=', 'name' => 'LIKE'];
$conditions = [];

foreach ($_GET as $key => $value) {
    if (!isset($valid[$key])) {
        continue;
    }
    if ($valid[$key] === 'LIKE') {
        // `name` LIKE '% . $value .%'
        $conditions[] = '`' . $key . '` ' . $valid[$key] . ' \'%'  . $value  . '%\'';
    } else {
        $conditions[] = '`' . $key . '` ' . $valid[$key] . ' \'' . $value . '\'';
    }
}


// $valid = ['category', 'sub_category', 'is_variable'];
// $conditions = [];

// foreach ($_GET as $key => $value) {
//     if (!in_array($key, $valid)) {
//         continue;
//     }
//     $conditions[] = '`' . $key . '` = \'' . $value . '\'';
// }
// print_r($conditions);
// exit;
if (count($conditions)) {
    $where = ' WHERE ' . implode(' AND ', $conditions);
} else {
    $where = '';
}
$sql = "SELECT * FROM `items` $where";

$result = $connection->query($sql);
$data = array();
foreach (queryData($result) as $row) {
    $row['variables'] = json_decode($row['variables'], true);
    $row['images'] = json_decode($row['images'], true);
    $data[] = $row;
}
$sql2 = "SELECT category,sub_category FROM `items` GROUP BY category,sub_category";
$result = $connection->query($sql2);
$data2 = [];
foreach (queryData($result) as $row) {
    $data2[$row['category']][] = $row['sub_category'];
}

$data = ['items' => $data, 'categories' => $data2];
$data = json_encode($data, JSON_UNESCAPED_UNICODE);

echo ($data);
$connection->close();

function queryData($handler): array
{
    $data = [];
    if ($handler->num_rows > 0) {
        while ($row = $handler->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
