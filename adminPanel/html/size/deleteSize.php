<?php 

  require '../connection/connection.php';


  $id = $_GET['id'];

  $sizesQuery = "DELETE FROM `sizes` WHERE size_id = :id";
  $sizesPrepare = $connect->prepare(query: $sizesQuery);
  $sizesPrepare->bindParam(':id',$id,PDO::PARAM_INT);
  
  if($sizesPrepare->execute())
  {
    header('location:viewSize.php');
  }



?>