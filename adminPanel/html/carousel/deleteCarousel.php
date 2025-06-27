<?php 

  require '../connection/connection.php';


  $id = $_GET['id'];

  $deleteQuery = "DELETE FROM `slider` WHERE slider_id = :id";
  $deletePrepare = $connect->prepare($deleteQuery);
  $deletePrepare->bindParam(':id',$id,PDO::PARAM_INT);
  
  if($deletePrepare->execute())
  {
    header('location:viewCarousel.php');
  }



?>