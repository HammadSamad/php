<?php 

require "connection/connection.php";

$delId = $_GET['delid'];

$deleteQuery = "DELETE FROM pdo_products WHERE prodId = :delId";

$deletePrepare = $connection->prepare($deleteQuery);

$deletePrepare->bindParam(":delId",$delId,PDO::PARAM_INT);

$deletePrepare->execute();

header("location:adminview.php");











