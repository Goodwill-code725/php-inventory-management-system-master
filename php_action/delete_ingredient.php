<?php
// not yet implemented 
// PHP 5.3 Compatible (no shorthand array syntax!)

require_once 'core.php'; // Connect to DB

$response = array("success" => false); // Default response

// Check if 'id' is set and not empty
if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];  // Ensure it's an integer

    // Prepare the DELETE SQL statement using product_id
    $sql = "DELETE FROM ingredients WHERE product_id = $product_id";

    // Execute the query and check if it succeeds
    if ($connect->query($sql) === TRUE) {
        $response["success"] = true;
    } else {
        $response["error"] = "Error deleting ingredient: " . $connect->error;
    }
} else {
    $response["error"] = "No product_id provided.";  // If product_id is missing
}

$connect->close();

echo json_encode($response);  // Return JSON response
?>
