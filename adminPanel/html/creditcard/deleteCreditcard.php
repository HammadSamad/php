<?php
  require '../connection/connection.php';

    $id = $_GET['id'];
    $deleteCreditCardQuery = "DELETE FROM `creditcard` WHERE creditCardId = :id";
    $deleteCreditCardprepare = $connect->prepare($deleteCreditCardQuery);
    $deleteCreditCardprepare->bindParam(':id', $id, PDO::PARAM_INT);
     if($deleteCreditCardprepare->execute()){
        header('location:viewCreditCard.php');
     }   




?>