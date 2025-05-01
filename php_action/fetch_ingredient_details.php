<?php
require_once '../core.php';  // Include the database connection

$response = array("success" => false, "details" => "", "error" => "");

if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];  // Use the correct POST variable

    // Get the product name from the product table
    $productSql = "SELECT product_name FROM product WHERE product_id = '$product_id'";  // Use the dynamic product_id
    $productResult = $connect->query($productSql);

    if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        $product_name = $productRow['product_name'];

        // Get the ingredients for this product
        $sql = "SELECT ingredient_name, ingredient_quantity, ingredient_quantity_per_product, ingredient_cost 
                FROM ingredients 
                WHERE product_id = '$product_id'";  // Use the dynamic product_id
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            $details = "<h4>Product Name: " . htmlspecialchars($product_name) . "</h4>";
            $details .= "<table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Ingredient</th>
                                    <th>Available Quantity</th>
                                    <th>Quantity per Product</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>";

            $minProducts = PHP_INT_MAX;

            while ($row = $result->fetch_assoc()) {
                $ingredientName = $row['ingredient_name'];
                $availableQty = floatval($row['ingredient_quantity']);
                $qtyPerProduct = floatval($row['ingredient_quantity_per_product']);
                $cost = $row['ingredient_cost'];

                $possibleProducts = ($qtyPerProduct > 0) ? floor($availableQty / $qtyPerProduct) : 0;
                if ($possibleProducts < $minProducts) {
                    $minProducts = $possibleProducts;
                }

                $details .= "<tr>
                                <td>" . htmlspecialchars($ingredientName) . "</td>
                                <td>" . $availableQty . "</td>
                                <td>" . $qtyPerProduct . "</td>
                                <td>" . $cost . "</td>
                            </tr>";
            }

            $details .= "</tbody></table>";
            $details .= "<div><strong>Maximum Number of Products That Can Be Made:</strong> " . $minProducts . "</div>";
            $response["success"] = true;
            $response["details"] = $details;
        } else {
            $response["error"] = "No ingredients found for this product.";
        }
    } else {
        $response["error"] = "Product not found.";
    }
} else {
    $response["error"] = "No product_id provided.";
}

$connect->close();
echo json_encode($response);
?>
