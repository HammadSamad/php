<?php

require "connection/connection.php";

// Get country ID
$countryId = $_POST['countryId'];

// Query to fetch cities based on selected country
$cityQuery = "SELECT * FROM `cities` WHERE `country_id` = :countryId";
$cityPrepare = $connect->prepare($cityQuery);
$cityPrepare->bindParam(':countryId', $countryId, PDO::PARAM_INT);
$cityPrepare->execute();
$citiesData = $cityPrepare->fetchAll(PDO::FETCH_ASSOC);

// Generate city options
echo '<option selected disabled value="">Select City</option>'; // Default option
foreach ($citiesData as $cityData) {
  echo '<option value="' . $cityData['city_id'] . '">' . $cityData['city_name'] . '</option>';
}

?>
