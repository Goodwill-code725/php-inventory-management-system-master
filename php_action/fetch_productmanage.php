<?php
require_once 'core.php'; // Ensure the core.php file is included correctly

// Fetch all ingredients and the related product name from the database
$sql = "
SELECT 
    ingredients.id, 
    ingredients.product_id, 
    product.product_name, 
    ingredients.ingredient_name, 
    ingredients.ingredient_quantity, 
    ingredients.ingredient_cost
FROM 
    ingredients
INNER JOIN 
    product ON ingredients.product_id = product.product_id
"; 

// Run the query
$result = $connect->query($sql);

// Initialize an empty array to store the data
$data = array();

if ($result->num_rows > 0) {
    // Loop through each row in the result set
    while ($row = $result->fetch_assoc()) {
        // Add data to the array
        $data[] = array(
            "id" => $row['id'],
            "product_id" => $row['product_id'],
            "product_name" => $row['product_name'],
            "ingredient_name" => $row['ingredient_name'],
            "ingredient_quantity" => $row['ingredient_quantity'],
            "ingredient_cost" => $row['ingredient_cost']
        );
    }
}

// Close the database connection
$connect->close();

// Output the data as JSON
echo json_encode(array("data" => $data));
?>
