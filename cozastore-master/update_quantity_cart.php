<?php require "connection/connection.php" ?>



<?php
// $qty= $_POST['qty'];
// $cartId= $_POST['cartId'];

// $cartValueQuery = "UPDATE `carts` SET `quantity`= :qty WHERE `cart_id`=:cartId";
// $cartValuePrepare = $connect->prepare($cartValueQuery);
// $cartValuePrepare->bindParam(':qty',$qty,PDO::PARAM_INT);
// $cartValuePrepare->bindParam(':cartId',$cartId,PDO::PARAM_INT);
// $cartValuePrepare->execute();




// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 0;
//     $cartId = isset($_POST['cartId']) ? (int)$_POST['cartId'] : 0;

//     if ($qty > 0 && $cartId > 0) {
//         $cartValueQuery = "UPDATE `carts` SET `quantity` = :qty WHERE `cart_id` = :cartId";
//         $cartValuePrepare = $connect->prepare($cartValueQuery);
//         $cartValuePrepare->bindParam(':qty', $qty, PDO::PARAM_INT);
//         $cartValuePrepare->bindParam(':cartId', $cartId, PDO::PARAM_INT);

//         if ($cartValuePrepare->execute()) {
//             echo json_encode(['success' => true, 'message' => 'Quantity updated successfully.']);
//         } else {
//             echo json_encode(['success' => false, 'message' => 'Failed to update quantity.']);
//         }
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Invalid quantity or cart ID.']);
//     }
// } else {
//     echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
// }






$qty = intval($_POST['qty']);
$cartId = intval($_POST['cartId']);

try {
    // Fetch current product stock
    $stockQuery = "SELECT p.stock_quantity FROM carts c JOIN products p ON c.prod_id = p.product_id WHERE c.cart_id = :cartId";
    $stockStmt = $connect->prepare($stockQuery);
    $stockStmt->bindParam(':cartId', $cartId, PDO::PARAM_INT);
    $stockStmt->execute();
    $productData = $stockStmt->fetch(PDO::FETCH_ASSOC);

    if (!$productData) {
        echo json_encode(["status" => "error", "message" => "Product not found."]);
        exit;
    }

    $availableStock = intval($productData['stock_quantity']);

    if ($qty > $availableStock) {
        echo json_encode(["status" => "error", "message" => "Only $availableStock units available in stock."]);
        exit;
    }

    // Update cart quantity
    $cartValueQuery = "UPDATE `carts` SET `quantity` = :qty WHERE `cart_id` = :cartId";
    $cartValuePrepare = $connect->prepare($cartValueQuery);
    $cartValuePrepare->bindParam(':qty', $qty, PDO::PARAM_INT);
    $cartValuePrepare->bindParam(':cartId', $cartId, PDO::PARAM_INT);
    $cartValuePrepare->execute();

    echo json_encode(["status" => "success", "message" => "Quantity updated successfully."]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
}



// $qty = $_POST['qty'];
// $cartId = $_POST['cartId'];

// // Update the quantity in the database
// $cartValueQuery = "UPDATE carts SET quantity = :qty WHERE cart_id = :cartId";
// $cartValuePrepare = $connect->prepare($cartValueQuery);
// $cartValuePrepare->bindParam(':qty', $qty, PDO::PARAM_INT);
// $cartValuePrepare->bindParam(':cartId', $cartId, PDO::PARAM_INT);
// $cartValuePrepare->execute();

// // Send a success response
// echo json_encode(['success' => true]);







?>

