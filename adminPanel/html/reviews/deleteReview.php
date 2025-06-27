<?php 

  require '../connection/connection.php';


  $id = $_GET['id'];

  $reviewQuery = "DELETE FROM `reviews` WHERE reviews_id = :id";
  $reviewPrepare = $connect->prepare(query: $reviewQuery);
  $reviewPrepare->bindParam(':id',$id,PDO::PARAM_INT);
  
  if($reviewPrepare->execute())
  {
    header('location:viewReview.php');
  }



?>

