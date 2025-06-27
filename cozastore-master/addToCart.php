<?php
session_start();
require "connection/connection.php";

header('Content-Type: application/json'); // Set content type for JSON response

try {
    if (!isset($_SESSION['userId']) || empty($_SESSION['userId'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in."]);
        exit;
    }

    $id = $_SESSION['userId'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);

        if ($product_id > 0 && $quantity > 0) {
            // Check if the product already exists in the cart
            $checkQuery = "SELECT * FROM `carts` WHERE prod_id = :product_id AND user_id = :id";
            $checkStmt = $connect->prepare($checkQuery);
            $checkStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                // Product already in cart
                echo json_encode(["status" => "error", "message" => "Product already in cart."]);
            } else {
                // Product does not exist, insert it
                $insertQuery = "INSERT INTO `carts` (prod_id, quantity, user_id) VALUES (:product_id, :quantity, :id)";
                $insertStmt = $connect->prepare($insertQuery);
                $insertStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                $insertStmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                $insertStmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($insertStmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "Product added to cart successfully!"]);
                } else {
                    $errorInfo = $insertStmt->errorInfo();
                    echo json_encode(["status" => "error", "message" => "Failed to insert product: " . $errorInfo[2]]);
                }
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid product ID or quantity."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
}
?>
