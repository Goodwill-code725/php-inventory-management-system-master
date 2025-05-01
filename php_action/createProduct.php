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

    if (in_array(strtolower($type), array('gif', 'jpg', 'jpeg', 'png'))) {
        if (is_uploaded_file($_FILES['productImage']['tmp_name'])) {
            if (move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {

                // Insert product into the database
                $sql = "INSERT INTO product (product_name, product_image, brand_id, categories_id, quantity, rate, active, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
                $stmt = $connect->prepare($sql);
                $stmt->bind_param("ssiiiii", $productName, $url, $brandName, $categoryName, $quantity, $rate, $productStatus);

                if ($stmt->execute()) {
                    $productId = $stmt->insert_id; // Get the last inserted product_id

                    // Insert ingredients if provided
                    if (
                        !empty($_POST['ingredient_name']) &&
                        !empty($_POST['ingredient_quantity']) &&
                        !empty($_POST['ingredient_cost']) &&
                        !empty($_POST['ingredient_quantity_per_product'])
                    ) {
                        $ingredientNames = $_POST['ingredient_name'];
                        $ingredientQuantities = $_POST['ingredient_quantity'];
                        $ingredientCosts = $_POST['ingredient_cost'];
                        $ingredientQuantityPerProduct = $_POST['ingredient_quantity_per_product'];

                        foreach ($ingredientNames as $key => $ingredientName) {
                            $ingredientQuantity = $ingredientQuantities[$key];
                            $ingredientCost = $ingredientCosts[$key];
                            $quantityPerProduct = $ingredientQuantityPerProduct[$key];

                            // Insert ingredient into the database
                            $ingredientSql = "INSERT INTO ingredients (product_id, ingredient_name, ingredient_quantity, ingredient_cost, ingredient_quantity_per_product) 
                                              VALUES (?, ?, ?, ?, ?)";
                            $ingredientStmt = $connect->prepare($ingredientSql);
                            $ingredientStmt->bind_param("isdsi", $productId, $ingredientName, $ingredientQuantity, $ingredientCost, $quantityPerProduct);
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

                $stmt->close();
            } else {
                $valid['success'] = false;
                $valid['messages'] = "Error while uploading image";
            }
        }
    }

    $connect->close();

    echo json_encode($valid);
}

?>
