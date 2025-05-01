<?php
require_once 'core.php'; 

$sql = "SELECT product_id, product_name, quantity, rate FROM product";
$result = $connect->query($sql);

$data = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            "product_id" => $row['product_id'],
            "product_name" => $row['product_name'],
            "quantity" => $row['quantity'],
            "rate" => $row['rate']
        );
    }
}

$connect->close();
echo json_encode(array("data" => $data));
?>
