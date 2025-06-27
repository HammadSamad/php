<?php require "connection/connection.php" ?>


<?php
session_start();
$id = $_GET['id'];

// fetch product id from order_product table
$fetchProdIdQuery = "SELECT * FROM `order_product` WHERE prod_id = :id";
$fetchProdIdPrepare = $connect->prepare($fetchProdIdQuery);
$fetchProdIdPrepare->bindParam(':id', $id , pdo::PARAM_INT);
$fetchProdIdPrepare->execute();
$fetchProdIdData = $fetchProdIdPrepare->fetch(PDO::FETCH_ASSOC);

$prodId = $fetchProdIdData['prod_id'];
$order_id = $fetchProdIdData['order_id'];
$qty = $fetchProdIdData['quantity'];
$userId = $_SESSION['userId'];

// insert delete order product
$deleteOrderQuery = "INSERT INTO `delete_order`(`prod_id`, `order_id`, `quantity`, `user_id`) VALUES (:prod_id, :order_id, :quantity, :user_id)";
$deleteOrderPrepare = $connect->prepare($deleteOrderQuery);
$deleteOrderPrepare->bindParam(':prod_id', $prodId , pdo::PARAM_INT);
$deleteOrderPrepare->bindParam(':order_id', $order_id , pdo::PARAM_INT);
$deleteOrderPrepare->bindParam(':quantity', $qty , pdo::PARAM_INT);
$deleteOrderPrepare->bindParam(':user_id', $userId , pdo::PARAM_INT);
$deleteOrderPrepare->execute();


// Delete from cart table

$deleteOrderProdQuery = "DELETE FROM `order_product` WHERE prod_id = :id";
$deleteOrderProdPrepare = $connect->prepare($deleteOrderProdQuery);
$deleteOrderProdPrepare->bindParam(':id', $id , pdo::PARAM_INT);

if($deleteOrderProdPrepare->execute()){

    header("Location: order.php");

}else{
    echo "Error deleting record";
}



?>