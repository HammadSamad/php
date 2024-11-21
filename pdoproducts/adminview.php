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
      <h1 class="text-center">Admin View!</h1>
    <div class="row m-5">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Product Id</th>
      <th scope="col">Product Image</th>
      <th scope="col">Product Name</th>
      <th scope="col">Product Description</th>
      <th scope="col">Product Price</th>
      <th scope="col">Product Rating</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($prodData as $viewData) { ?>
    <tr>
      <td><?= $viewData['prodId'] ?></td>
      <td><img src="prodimages/<?= $viewData['prodImage'] ?>" alt="images" width="100px" style="aspect-ratio:4/3"></td>
      <td><?= $viewData['prodName'] ?></td>
      <td><?= $viewData['prodPrice'] ?></td>
      <td><?= $viewData['prodDesc'] ?></td>
      <td><?= $viewData['prodRating'] ?></td>
        <td><a class="btn btn-warning" href="update.php/?upid=<?= $viewData['prodId'] ?>">Update</a>
            <a class="btn btn-danger" href="delete.php/?delid=<?= $viewData['prodId'] ?>">Delete</a>
        </td>
    </tr>
<?php } ?>
  </tbody>
</table>
    </div>
  </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

