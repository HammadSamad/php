<?php

require "connection/connection.php";

$viewQuery = "SELECT * FROM pdo_products";

$viewPrepare = $connection->prepare($viewQuery);

$viewPrepare->execute();

$prodData = $viewPrepare->fetchAll(PDO::FETCH_ASSOC);


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
          <h1 class="text-center">View Products!</h1>
          <div class="row mt-5">
        <?php foreach($prodData as $viewData) { ?>
        <div class="card" style="width: 18rem;">
  <img src="prodimages/<?= $viewData['prodImage'] ?>" class="card-img-top" alt="image" width="200px" style="aspect-ratio:1/1;">
  <div class="card-body">
    <h6 class="card-title">Name: <?= $viewData['prodName'] ?></h6>
    <h6 class="card-title">Price: <?= $viewData['prodPrice'] ?></h6>
    <h6 class="card-text">Description: <?= $viewData['prodDesc'] ?></h6>    
    <h6 class="card-text">Rating: <?= $viewData['prodRating'] ?></h6>    
    </div>
    </div>
    <?php } ?>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
