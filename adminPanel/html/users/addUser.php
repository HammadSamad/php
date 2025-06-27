<?php
 session_name('adminPanel');

session_start();


if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}

?>


<?php require '../connection/connection.php' ?>


<?php

// $citiesyQuery = "SELECT * FROM `cities`";
// $citiesPrepare = $connect->prepare($citiesyQuery);
// $citiesPrepare->execute();
// $citiesData = $citiesPrepare->fetchAll(PDO::FETCH_ASSOC);


$countryQuery = "SELECT * FROM `countries`";
$countryPrepare = $connect->prepare($countryQuery);
$countryPrepare->execute();
$countryData = $countryPrepare->fetchAll(PDO::FETCH_ASSOC);


$userRoleQuery = "SELECT * FROM `roles`";
$userRolePrepare = $connect->prepare($userRoleQuery);
$userRolePrepare->execute();
$userRoleData = $userRolePrepare->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['addUserbtn'])) {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $userName = $_POST['userName'];
  $userPassword = $_POST['userPassword'];
  $phoneNum = $_POST['phoneNum'];
  $userEmail = $_POST['userEmail'];
  $userRole = $_POST['userRole'];
  $countryId = $_POST['countryId'];
  $cityId = $_POST['cityId'];

  $passwordHash = password_hash($userPassword, PASSWORD_BCRYPT);
  $userName = $firstName . " " . $lastName;

  $userAddQuery = "INSERT INTO `users`(`first_name`, `last_name`, `username`, `password_hash`, `phone_number`, `role_id`, `user_email`, `country_id`, `city_id`) VALUES (:first_name, :last_name, :username, :password_hash, :phone_num, :role_id, :user_email, :country_id, :city_id)";
  $userAddprepare = $connect->prepare($userAddQuery);
  $userAddprepare->bindParam(':first_name', $firstName, PDO::PARAM_STR);
  $userAddprepare->bindParam(':last_name', $lastName, PDO::PARAM_STR);
  $userAddprepare->bindParam(':username', $userName, PDO::PARAM_STR);
  $userAddprepare->bindParam(':password_hash', $passwordHash, PDO::PARAM_STR);
  $userAddprepare->bindParam(':phone_num', $phoneNum, PDO::PARAM_INT);
  $userAddprepare->bindParam(':role_id', $userRole, PDO::PARAM_INT);
  $userAddprepare->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
  $userAddprepare->bindParam(':country_id', $countryId, PDO::PARAM_INT);
  $userAddprepare->bindParam(':city_id', $cityId, PDO::PARAM_INT);


  if ($userAddprepare->execute()) {
    echo "<script>alert('User Added Successfully')</script>";
  } else {
    echo "<script>alert('Failed to Add User')</script>";
  }

}

?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Add User</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>


  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <?php require "../partials/sidebar.php" ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php require '../partials/navbaar.php' ?>


          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-md-12">

                  <div class="card mb-4">
                    <h5 class="card-header">Add Permission</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return validateForm()">
                        <div class="row">

                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">First Name</label>
                            <input class="form-control" type="text" name="firstName" id="firstName" placeholder="First Name" required/>
                            <small class="text-danger" id="firstNameError"></small>
                          </div>
                          
                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" placeholder="Last Name" required/>
                            <small class="text-danger" id="lastNameError"></small>
                          </div>
                          
                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">User Name</label>
                            <input class="form-control" type="text" name="userName" id="userName" placeholder="User Name" required/>
                            <small class="text-danger" id="userNameError"></small>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">User Password</label>
                            <input class="form-control" type="password" name="userPassword" id="password" placeholder="User Password" required />
                            <small class="text-danger" id="passwordError"></small>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">Phone Number</label>
                            <input class="form-control" type="text" name="phoneNum" id="phoneNumber" placeholder="User Phone Number" required/>
                            <small class="text-danger" id="phoneNumberError"></small>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">User Role</label>
                            <select name="userRole" id="" class="form-control" required>
                                                <option value="" selected disabled>Select user role...</option>

                                                <?php foreach ($userRoleData as $userRole) { ?>
 <option value="<?= $userRole['role_id'] ?>"><?= $userRole['role_name'] ?></option> <?php } ?>



                                            </select>
                          </div>

                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">User Email</label>
                            <input class="form-control" type="email" name="userEmail" id="email" placeholder="User Email" required/>
                            <small class="text-danger" id="emailError"></small>
                          </div>
                          
                          <div class="mb-3 col-md-12">
    <label for="exampleInputName1" class="form-label">Country</label>
    <select name="countryId" id="countryId" class="form-control" required>
        <option value="" selected disabled>Select Country....</option>
        <?php foreach ($countryData as $cD) { ?>
             <option value="<?= $cD['country_id'] ?>"><?= $cD['country_name'] ?></option>
        <?php } ?>
    </select>
</div>

<div class="mb-3 col-md-12">
    <label for="exampleInputName1" class="form-label">City</label>
    <select name="cityId" id="cityId" class="form-control" required>
        <option value="" selected disabled>Select City....</option>
    </select>
</div>


                         

                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2 " name="addUserbtn">Add User</button>
                          <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <?php require '../partials/footer.php' ?>
         
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
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script>
      $(document).ready(function () {
        $('#countryId').change(function () {
          const countryId = $(this).val();
          if (countryId) {
            $.ajax({
              type: 'POST',
              url: 'getCitiesByCountry.php',
              data: { countryId: countryId },
              dataType: 'json',
              success: function (response) {
                $('#cityId').empty();
                $('#cityId').append('<option value="" selected disabled>Select City....</option>');
                response.forEach(function (city) {
                  $('#cityId').append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                });
              },
              error: function () {
                alert('Failed to fetch cities.');
              }
            });
          } else {
            $('#cityId').empty();
            $('#cityId').append('<option value="" selected disabled>Select City....</option>');
          }
        });
      });



      function validateForm() {
    let valid = true;

    // Regex patterns
    const nameRegex = /^[A-Za-z]{2,16}$/; // Only letters, min 2, max 16
    const userNameRegex = /^(?=.*[A-Za-z])[A-Za-z0-9]{3,18}$/; // At least one letter, letters/numbers allowed, min 3, max 18
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Standard email pattern
    const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/; // 1 Uppercase, 1 Lowercase, 1 Number, 1 Special Char, min 8, max 16
    const phoneRegex = /^[1-9][0-9]{6,14}$/; // Numbers only, min 7, max 15, first digit can't be 0

    // Get input values
    const firstName = document.getElementById("firstName").value.trim();
    const lastName = document.getElementById("lastName").value.trim();
    const userName = document.getElementById("userName").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const phoneNumber = document.getElementById("phoneNumber").value.trim();

    // Clear all previous error messages
    document.getElementById("firstNameError").innerText = "";
    document.getElementById("lastNameError").innerText = "";
    document.getElementById("userNameError").innerText = "";
    document.getElementById("emailError").innerText = "";
    document.getElementById("passwordError").innerText = "";
    document.getElementById("phoneNumberError").innerText = "";

    // Validation checks
    if (!nameRegex.test(firstName)) {
        document.getElementById("firstNameError").innerText = "First name must be 2-16 letters only.";
        valid = false;
    }

    if (!nameRegex.test(lastName)) {
        document.getElementById("lastNameError").innerText = "Last name must be 2-16 letters only.";
        valid = false;
    }

    if (!userNameRegex.test(userName)) {
        document.getElementById("userNameError").innerText = "Username must be 3-18 characters and contain at least one letter.";
        valid = false;
    }

    if (!emailRegex.test(email)) {
        document.getElementById("emailError").innerText = "Enter a valid email address.";
        valid = false;
    }

    if (!passwordRegex.test(password)) {
        document.getElementById("passwordError").innerText = "Password must be 8-16 chars with 1 uppercase, 1 lowercase, 1 number, and 1 special char.";
        valid = false;
    }

    if (!phoneRegex.test(phoneNumber)) {
        document.getElementById("phoneNumberError").innerText = "Enter a valid phone number (7-15 digits, no leading 0).";
        valid = false;
    }

    return valid;
}




    </script>
  </body>
</html>