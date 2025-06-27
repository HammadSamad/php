<?php
session_start();
require "connection/connection.php";

$userId = $_SESSION['userId'];
$shipmentPrice = 80;

try {
    // Calculate subtotal
    $subTotalQuery = 'SELECT ROUND(SUM(products.product_price * carts.quantity), 2) as subTotal 
                      FROM carts 
                      JOIN products ON products.product_id = carts.prod_id 
                      WHERE user_id = :user_id';
    $subTotalPrepare = $connect->prepare($subTotalQuery);
    $subTotalPrepare->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $subTotalPrepare->execute();
    $subTotal = $subTotalPrepare->fetch(PDO::FETCH_ASSOC);

    // Calculate total (subtotal + shipment price)
    $subTotalAmount = $subTotal['subTotal'] ?? 0; // Default to 0 if no cart items
    $total = $subTotalAmount + $shipmentPrice;

    // Return JSON response
    echo json_encode([
        'status' => 'success',
        'subTotal' => $subTotalAmount,
        'shipmentPrice' => $shipmentPrice,
        'total' => $total,
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error calculating totals: ' . $e->getMessage(),
    ]);
}
?>
