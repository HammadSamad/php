<?php

require "../connection/connection.php";


$countryId = $_POST['countryId'];

$cityQuery = "SELECT * FROM `cities` WHERE `country_id` = :countryId";

$cityPrepare = $connect->prepare($cityQuery);
$cityPrepare->bindParam(':countryId', $countryId, PDO::PARAM_INT);
$cityPrepare->execute();
$citiesData = $cityPrepare->fetchAll(PDO::FETCH_ASSOC);


?>
<select name="city" id="cityId" class="form-control">
    <option value="" selected disabled>Select your City</option>
    <?php foreach ($citiesData as $cd) { ?>
        <option value="<?= $cd['city_id'] ?>"><?= $cd['city_name'] ?></option>
    <?php } ?>
</select>