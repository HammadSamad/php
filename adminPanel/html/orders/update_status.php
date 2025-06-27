<?php
require "../connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Update the status in the database
    $updateQuery = "UPDATE orders SET dispatch_status = :status WHERE order_id = :order_id";
    $updateStmt = $connect->prepare($updateQuery);
    $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
    $updateStmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);

    if ($updateStmt->execute()) {
        // Redirect back to the orders page
        header("Location: order.php");
        exit();
    } else {
        echo "Failed to update status.";
    }
}
?>