<?php
session_start();

// Include database connection
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = intval($_POST['product_id']);
    $userId = $_SESSION['user_id']; // Assume user ID is stored in session
    $userId = 2;

    if ($productId && $userId) {
        // Insert into wishlist table
        $query = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $userId, $productId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid product or user']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
