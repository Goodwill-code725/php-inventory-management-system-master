<?php 

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {

    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];
    $rate = $_POST['rate'];
    $brandName = $_POST['brandName'];
    $categoryName = $_POST['categoryName'];
    $productStatus = $_POST['productStatus'];

    // Handle file upload for the product image
    $type = explode('.', $_FILES['productImage']['name']);
    $type = $type[count($type) - 1];
    $url = '../assests/images/stock/' . uniqid(rand()) . '.' . $type;

    if (in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
        if (is_uploaded_file($_FILES['productImage']['tmp_name'])) {
            if (move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {

                // Insert product into the database using prepared statements
                $sql = "INSERT INTO product (product_name, product_image, brand_id, categories_id, quantity, rate, active, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("ssiiiii", $productName, $url, $brandName, $categoryName, $quantity, $rate, $productStatus);

                if ($stmt->execute()) {
                    $productId = $stmt->insert_id; // Get the last inserted product_id

                    // Insert ingredients if provided
                    if (!empty($_POST['ingredient_name']) && !empty($_POST['ingredient_quantity']) && !empty($_POST['ingredient_cost'])) {
                        $ingredientNames = $_POST['ingredient_name'];
                        $ingredientQuantities = $_POST['ingredient_quantity'];
                        $ingredientCosts = $_POST['ingredient_cost']; // Get the ingredient cost values

                        foreach ($ingredientNames as $key => $ingredientName) {
                            $ingredientQuantity = $ingredientQuantities[$key];
                            $ingredientCost = $ingredientCosts[$key]; // Get the cost for each ingredient

                            // Insert ingredient into the database
                            $ingredientSql = "INSERT INTO ingredients (product_id, ingredient_name, ingredient_quantity, ingredient_cost) 
                                              VALUES (?, ?, ?, ?)";
                            $ingredientStmt = $connect->prepare($ingredientSql);
                            $ingredientStmt->bind_param("isds", $productId, $ingredientName, $ingredientQuantity, $ingredientCost);
                            $ingredientStmt->execute();
                            $ingredientStmt->close();
                        }
                    }

                    $valid['success'] = true;
                    $valid['messages'] = "Successfully Added Product with Ingredients";    
                } else {
                    $valid['success'] = false;
                    $valid['messages'] = "Error while adding the product";
                }

                $stmt->close(); // Close the prepared statement for product insertion
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while uploading image";
            }
        }
    }

    $connect->close(); // Close database connection once

    echo json_encode($valid);
}

?>
