<?php 

  require '../connection/connection.php';


  $id = $_GET['id'];

  $colorQuery = "DELETE FROM `colors` WHERE color_id = :id";
  $colorPrepare = $connect->prepare($colorQuery);
  $colorPrepare->bindParam(':id',$id,PDO::PARAM_INT);
  
  if($colorPrepare->execute())
  {
    header('location:viewColor.php');
  }



?>