<?php

require "connection/connection.php";

$updateId = $_GET['upid'];


$viewQuery = "SELECT * FROM pdo_products WHERE prodId = :id";

$viewPrepare = $connection->prepare($viewQuery);

$viewPrepare->bindParam(":id", $updateId,PDO::PARAM_INT);

$viewPrepare->execute();

$viewData = $viewPrepare->fetch(PDO::FETCH_ASSOC);


if(isset($_POST['btn']))
{
    $prodName = $_POST['prodName'];
    $prodDesc = $_POST['prodDesc'];
    $prodPrice = $_POST['prodPrice'];
    $prodRating = $_POST['prodRating'];
    $prodImage = $_FILES['prodImage'];


    if($prodImage['size'] > 5000000)
    {
      echo "<script>alert('Your image size is too large')</script>";
    }
    else
    {
      $extention = explode(".",$prodImage['name']);
      $extention = $extention[1];
      $imageUniqueName = uniqid();
      $imageName = $imageUniqueName . "." . $extention;
      move_uploaded_file($prodImage['tmp_name'],"prodimages/".$imageName);
      $image = empty($prodImage['name']) ? $viewData['prodImage'] : $imageName;

      $updateQuery = "UPDATE pdo_products SET prodName = :productname,prodDesc = :productdesc,prodPrice = :productprice,prodRating = :productrating,prodImage = :productimage WHERE prodId = :upateid";

      $updatePrepare = $connection->prepare($updateQuery);

      $updatePrepare->bindParam(":upateid",$updateId,PDO::PARAM_STR);
      $updatePrepare->bindParam(":productname",$prodName,PDO::PARAM_STR);
      $updatePrepare->bindParam(":productdesc",$prodDesc,PDO::PARAM_STR);
      $updatePrepare->bindParam(":productprice",$prodPrice,PDO::PARAM_INT);
      $updatePrepare->bindParam(":productrating",$prodRating);
      $updatePrepare->bindParam(":productimage",$image,PDO::PARAM_STR);

      if($updatePrepare->execute())
      {
        header("location:adminview.php");
      }

    }

}


?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>


<div class="container">
    <h1 class="text-center">Update Products!</h1>
<div class="row">
<form class="row g-3" method="post" enctype="multipart/form-data">
  <div class="col-md-12">
    <label for="inputEmail4" class="form-label">Product Name</label>
    <input type="text" class="form-control" id="inputEmail4" name="prodName" value="<?= $viewData['prodName'] ?>">
  </div>
  <div class="col-md-12">
    <label for="inputPassword4" class="form-label">Product Description</label>
    <input type="text" class="form-control" id="inputPassword4" name="prodDesc" value="<?= $viewData['prodDesc'] ?>">
  </div>
  <div class="col-12">
    <label for="inputAddress" class="form-label">Product Price</label>
    <input type="text" class="form-control" id="inputAddress" name="prodPrice" value="<?= $viewData['prodPrice'] ?>">
  </div>
  <div class="col-md-12">
    <label for="inputCity" class="form-label">Product Rating</label>
    <input type="text" class="form-control" id="inputCity" name="prodRating" value="<?= $viewData['prodRating'] ?>">
  </div>
  <div class="col-md-12">
    <label for="inputZip" class="form-label">Product Image</label>
    <img src="prodimages/<?= $viewData['prodImage'] ?>" alt="" width="100px">
    <input type="file" class="form-control" id="inputZip" name="prodImage" accept="image/png,image/jpg,image/jpeg,image/jfif,image/webp">
  </div>
  <div class="col-12">
    <button type="submit" class="btn btn-primary" name="btn">Update</button>
  </div>
</form>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
