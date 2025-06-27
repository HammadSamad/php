<?php
require '../connection/connection.php';

if (isset($_POST['countryId'])) {
    $countryId = $_POST['countryId'];
    $cityQuery = "SELECT * FROM `cities` WHERE `country_id` = :country_id";
    $cityPrepare = $connect->prepare($cityQuery);
    $cityPrepare->bindParam(':country_id', $countryId, PDO::PARAM_INT);
    $cityPrepare->execute();
    $cities = $cityPrepare->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cities);
}
?>
