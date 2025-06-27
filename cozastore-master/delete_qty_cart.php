<?php require "connection/connection.php" ?>


<?php

$id = $_GET['id'];
$deleteCartQuery = "DELETE FROM `carts` WHERE cart_id = :id";
$deleteCartPrepare = $connect->prepare($deleteCartQuery);
$deleteCartPrepare->bindParam(':id', $id , pdo::PARAM_INT);

if($deleteCartPrepare->execute()){
    // header("Location: shoping-cart.php");
    session_start();
    if (!empty($_SESSION['last_page'])) {
        header("Location: " . $_SESSION['last_page']);
        unset($_SESSION['last_page']);
        exit();
    }
}else{
    echo "Error deleting record";
}
// $deleteCartData = $viewCartPrepare->fetchAll(PDO::FETCH_ASSOC);



?>