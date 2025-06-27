<?php require "connection/connection.php" ?>
<?php 

ob_start(); 
session_name('adminPanel');

session_start();
if(!isset($_SESSION['apUserId']))
{
	header("location:auth-login-basic.php");
  
}

?>

<?php


$roleId = $_SESSION['roleId'];
$userName = $_SESSION['apUsername'];

$rolePermissionQuery = "SELECT * FROM `permissions` JOIN `permission_role` ON permissions.permissions_id = permission_role.permission_id JOIN `roles` ON roles.role_id = permission_role.role_id WHERE permission_role.role_id = :roleId";
$rolePermissionPrepare = $connect->prepare($rolePermissionQuery);
$rolePermissionPrepare->bindParam(':roleId', $_SESSION['roleId'], PDO::PARAM_INT);
$rolePermissionPrepare->execute();
$rolePermissionData = $rolePermissionPrepare->fetchAll(PDO::FETCH_ASSOC);

$isShipmentAvailable = false;
$isCreditCardAvailable = false;
$isReviewAvailable = false;
$isCarouselAvailable = false;
$isOrderAvailable = false;
$isSizeAvailable = false;
$isColorAvailable = false;
$isUserAvailable = false;
$isCityAvailable = false;
$isCountryAvailable = false;
$isCategoriesAvailable = false;
$isProductsAvailable = false;


$viewSales = "SELECT SUM(total_amount) AS sales FROM `orders`";
$viewSalesPrepare = $connect->prepare($viewSales);
$viewSalesPrepare->execute();
$viewSalesData = $viewSalesPrepare->fetch(PDO::FETCH_ASSOC);

// Profile Work //

$viewCountryQuery = "SELECT * FROM countries";
$viewCountryPrepare = $connect->prepare($viewCountryQuery);
$viewCountryPrepare->execute();
$viewCountryData = $viewCountryPrepare->fetchAll(PDO::FETCH_ASSOC);

$viewCityQuery = "SELECT * FROM cities";
$viewCityPrepare = $connect->prepare($viewCityQuery);
$viewCityPrepare->execute();
$viewCityData = $viewCityPrepare->fetchAll(PDO::FETCH_ASSOC);

$viewUserDataQuery = "SELECT * FROM users LEFT JOIN user_address ON users.user_id = user_address.user_id LEFT JOIN countries ON users.country_id = countries.country_id LEFT JOIN cities ON users.city_id = cities.city_id WHERE users.user_id = :user_id";
$viewUserDataPrepare = $connect->prepare($viewUserDataQuery);
$viewUserDataPrepare->bindParam(':user_id', $_SESSION['apUserId'], PDO::PARAM_INT);
$viewUserDataPrepare->execute();
$userData = $viewUserDataPrepare->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// print_r($userData) ;
// echo '</pre>';

$addressData = isset($_POST['address']) ? $_POST['address'] : null;
$countryNameData = $userData['country_name'];
$countryIdData = $userData['country_id'];
$cityNameData = $userData['city_name'];
$cityIdData = $userData['city_id'];


if (isset($_POST['Btn'])) {

  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  if ($password !== $confirmPassword) {
      echo "<script>alert('Passwords do not match');</script>";
  } else {

      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $userName = $_POST['userName'];
      $email = $_POST['email'];
      $phoneNumber = $_POST['phoneNumber'];
      $country = $_POST['country'];
      $city = $_POST['city'];
      $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

      // ✅ Check if username or email exists (excluding current user)
      $checkUserQuery = "SELECT * FROM `users` WHERE (`username` = :username OR `user_email` = :email) AND `user_id` != :user_id";
      $checkUserPrepare = $connect->prepare($checkUserQuery);
      $checkUserPrepare->bindParam(':username', $userName, PDO::PARAM_STR);
      $checkUserPrepare->bindParam(':email', $email, PDO::PARAM_STR);
      $checkUserPrepare->bindParam(':user_id', $_SESSION['apUserId'], PDO::PARAM_INT);
      $checkUserPrepare->execute();
      $existingUser = $checkUserPrepare->fetch(PDO::FETCH_ASSOC);

      // ✅ Check if the user already exists
      if ($existingUser) { 
          if ($existingUser['username'] == $userName) {
              echo "<script>alert('Username already exists');</script>";
              exit;
          }
          if ($existingUser['user_email'] == $email) {
              echo "<script>alert('Email already exists');</script>";
              exit;
          }
      }

      if (!password_verify($password, $userData['password_hash'])){
          $profileUpdateQuery = "UPDATE `users` 
          SET `first_name` = :firstName, 
              `last_name` = :lastName, 
              `username` = :userName, 
              `phone_number` = :phoneNumber,
              `user_email` = :email, 
              `country_id` = :country, 
              `city_id` = :city 
          WHERE `user_id` = :user_id";
          $isPass = false;
      }else{
        $profileUpdateQuery = "UPDATE `users` 
        SET `first_name` = :firstName, 
            `last_name` = :lastName, 
            `username` = :userName, 
            `phone_number` = :phoneNumber, 
            `password_hash` = :password_hash, 
            `user_email` = :email, 
            `country_id` = :country, 
            `city_id` = :city 
        WHERE `user_id` = :user_id";
        $isPass = true;
      }
      
      $profileUpdatePrepare = $connect->prepare($profileUpdateQuery);
      $profileUpdatePrepare->bindParam(':firstName', $firstName, PDO::PARAM_STR);
      $profileUpdatePrepare->bindParam(':lastName', $lastName, PDO::PARAM_STR);
      $profileUpdatePrepare->bindParam(':email', $email, PDO::PARAM_STR);
      if($isPass){
        $profileUpdatePrepare->bindParam(':password_hash', $encryptedPassword, PDO::PARAM_STR);
      }
      $profileUpdatePrepare->bindParam(':country', $country, PDO::PARAM_INT);
      $profileUpdatePrepare->bindParam(':city', $city, PDO::PARAM_INT);
      $profileUpdatePrepare->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
      $profileUpdatePrepare->bindParam(':userName', $userName, PDO::PARAM_STR);
      $profileUpdatePrepare->bindParam(':user_id', $_SESSION['apUserId'], PDO::PARAM_INT);

      if ($profileUpdatePrepare->execute()) {
          echo "<script>alert('Profile updated successfully.');</script>";
      } else {
          echo "<script>alert('Profile update unsuccessful.');</script>";
      }
  }
}




// session_start();

// Generate CSRF token (only once per session)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['deleteBtn'])) {
    // Validate CSRF token
    if ($_GET['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    // Prepare DELETE Query
    $deleteUserQuery = "DELETE FROM `users` WHERE `user_id` = :user_id";
    $deleteUserPrepare = $connect->prepare($deleteUserQuery);
    $deleteUserPrepare->bindParam(':user_id', $_SESSION['apUserId'], PDO::PARAM_INT);

    // Execute Query
    if ($deleteUserPrepare->execute()) {
        session_name('adminPanel');
        session_destroy();
        echo "<script>alert('Account deleted successfully');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting account. Please try again.');</script>";
    }
}

?>


<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Account settings - Account | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>

    <style>
  .password-field {
        font-family: monospace;
        -webkit-text-security: disc; /* Works in Safari, Chrome */
        -text-security: disc; /* Standard property */
    }
</style>

  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.php" class="app-brand-link">
              <span class="app-brand-logo demo">
                <svg
                  width="25"
                  viewBox="0 0 25 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <defs>
                    <path
                      d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                      id="path-1"
                    ></path>
                    <path
                      d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                      id="path-3"
                    ></path>
                    <path
                      d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                      id="path-4"
                    ></path>
                    <path
                      d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                      id="path-5"
                    ></path>
                  </defs>
                  <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                      <g id="Icon" transform="translate(27.000000, 15.000000)">
                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                          <mask id="mask-2" fill="white">
                            <use xlink:href="#path-1"></use>
                          </mask>
                          <use fill="#696cff" xlink:href="#path-1"></use>
                          <g id="Path-3" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-3"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                          </g>
                          <g id="Path-4" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-4"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                          </g>
                        </g>
                        <g
                          id="Triangle"
                          transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                        >
                          <use fill="#696cff" xlink:href="#path-5"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </span>
              <span class="app-brand-text demo menu-text fw-bolder ms-2">Shopping Cart</span>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item active">
              <a href="index.php" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>

           
            <?php
    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'categories')) {
        $isCategoriesAvailable = true;
      }
    }
    ?>
              <?php if ($isCategoriesAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Categories</div>
              </a>
              <ul class="menu-sub">
              <?php
            foreach ($rolePermissionData as $rolePermission) {
              if (str_contains($rolePermission['permission_path'], 'categories')) {
            ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                  <div data-i18n="Notifications"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
              }
            }
            ?>
              </ul>
            </li>
            <?php } ?>
            

            <?php
    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'products')) {
        $isProductsAvailable = true;
      }
    }
    ?>
      <?php if ($isProductsAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Products</div>
              </a>
              <ul class="menu-sub">
              <?php
            foreach ($rolePermissionData as $rolePermission) {
              if (str_contains($rolePermission['permission_path'], 'products')) {
            ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
              }
            }
            ?>
              </ul>
            </li>
            <?php } ?>
            

            <?php
    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'country')) {
        $isCountryAvailable = true;
      }
    }
    ?>
     <?php if ($isCountryAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Country</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'country')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>

                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>


<?php
    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'cities')) {
        $isCityAvailable = true;
      }
    }
    ?>
    <?php if ($isCityAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">City</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'cities')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>

                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>


            <?php
    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'users')) {
        $isUserAvailable = true;
      }
    }
    ?>
        <?php if ($isUserAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">User</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'users/')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>


            <?php
    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'color')) {
        $isColorAvailable = true;
      }
    }
    ?> 
    <?php if ($isColorAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Color</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'color')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>


<?php
            foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'size')) {
        $isSizeAvailable = true;
      }
    }
    ?> 
    <?php if ($isSizeAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Size</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'size')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>

            <?php
            foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'orders')) {
        $isOrderAvailable = true;
      }
    }
    ?> 
    <?php if ($isOrderAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Orders</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'orders')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>
        <?php    foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'carousel')) {
        $isCarouselAvailable = true;
      }
    }
    ?> 
    <?php if ($isCarouselAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Carousel</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'carousel')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>
            <?php
            foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'reviews')) {
        $isReviewAvailable = true;
      }
    }
    ?> 
    <?php if ($isReviewAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Review</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'reviews')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>
           <?php foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'creditcard')) {
        $isCreditCardAvailable = true;
      }
    }
    ?> 
    <?php if ($isCreditCardAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Credit Card</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'creditcard')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>
            <?php foreach ($rolePermissionData as $rP) {
      if (str_contains($rP['permission_path'], 'shipment')) {
        $isShipmentAvailable = true;
      }
    }
    ?> 
    <?php if ($isShipmentAvailable) { ?>
            <li class="menu-item">
              <a href="../javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Shipment</div>
              </a>
              <ul class="menu-sub">
              <?php
          foreach ($rolePermissionData as $rolePermission) {
            if (str_contains($rolePermission['permission_path'], 'shipment')) {
          ?>
                <li class="menu-item">
                  <a href="<?= $rolePermission['permission_path'] ?>" class="menu-link">
                    <div data-i18n="Account"><?= $rolePermission['permission_name'] ?></div>
                  </a>
                </li>
                <?php
            }
          }
          ?>
              </ul>
            </li>
            <?php } ?>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <!-- <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div> -->
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar rounded-circle bg-dark avatar-online">
                    <h2 class="text-white text-center"><?=$userName[0]?></h2>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar rounded-circle bg-dark avatar-online">
                              <h2 class="text-white text-center"><?=$userName[0]?></h2>
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?=$userName?></span>
                            <small class="text-muted"><strong>Role: </strong><?=$rolePermission['role_name']?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="pages-account-settings-account.php">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout.php">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
          

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-md-12">
                  
                  <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                   
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName"
                              autofocus
                              value="<?= $userData['first_name']?>"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="<?= $userData['last_name']?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">User Name</label>
                            <input class="form-control" type="text" name="userName" id="userName" value="<?= $userData['username']?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input
                              class="form-control"
                              type="text"
                              id="email"
                              name="email"
                              value="<?= $userData['user_email']?>"
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Password</label>
                            <input class="form-control password-field" type="text" name="password" id="password" value="<?= $userData['password_hash']?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="confirmPassword" class="form-label">Password Confirm</label>
                            <input class="form-control password-field" type="text" name="confirmPassword" id="confirmPassword" value="<?= $userData['password_hash']?>" />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="phoneNumber">Phone Number</label>
                            <div class="input-group input-group-merge">
                              <input
                                type="text"
                                id="phoneNumber"
                                name="phoneNumber"
                                class="form-control"
                                value="<?= $userData['phone_number']?>"
                              />
                            </div>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Country</label>
                            <select id="countryId" name="country" onchange="countryFunc()" class="select2 form-select">
                              <option selected style="font-weight: bolder;" value="<?= $countryIdData ?>"><?= $countryNameData ?></option>
                              <?php foreach ($viewCountryData as $countryD) {
                                if ($countryD['country_name'] != $countryNameData) { ?>
                                  <option value="<?= $countryD['country_id'] ?>"><?= $countryD['country_name'] ?></option>
                              <?php }} ?>
                            </select>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="city" class="form-label">City</label>
                            <select id="citySelectAdd" name="city" class="select2 form-select">
                              <option value="<?= $cityIdData ?>" style="font-weight: bolder;"><?= $cityNameData ?></option>
                            </select>
                          </div>
                        <div class="mt-2">
                          <button type="submit" name="Btn" class="btn btn-primary me-2">Save changes</button>
                          <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                      <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                          <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                          <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
                        </div>
                      </div>
                      <form id="formAccountDeactivation" onsubmit="return false">
                        <!-- <div class="form-check mb-3">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            name="accountActivation"
                            id="accountActivation"
                            required
                          />
                          <label class="form-check-label" for="accountActivation"
                            >I confirm my account delete</label
                          >
                        </div> -->
                        <a name="deleteBtn" class="btn btn-danger deactivate-account" href="?deleteBtn=1&csrf_token=<?php echo $_SESSION['csrf_token']; ?>" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</a>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>

let countryId = document.getElementById('countryId');
let citySelect = document.getElementById('citySelectAdd');

function countryFunc() {
  // Send countryId to the server and get cities

  $.ajax({
    url: 'profile-city-dependent-selector.php',
    data: {
      countryId: countryId.value
    },
    type: 'POST',
    success: (data) => {
      // Update city select with new options
      $('#citySelectAdd').html(data); // Replace the content with the response
      console.log(data)
    }
  });
}

</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".password-field").forEach(input => {
            let originalValue = input.value; // Store actual hash
            input.dataset.realValue = originalValue; // Save original hash in dataset
            input.value = "..............."; // Show only dots (15 max)
            
            input.addEventListener("focus", function() {
              this.value = ""; // Clear field when user clicks
            });

            input.addEventListener("blur", function() {
                if (this.value.trim() === "") {
                    this.value = this.dataset.realValue; // Restore original PHP value if empty
                    input.value = "..............."; // Show only dots (15 max)
                }
            });
        });
    });



  document.getElementById("cancel").addEventListener("click", function() {
    location.reload();
  });
  </script>
  </body>
</html>
