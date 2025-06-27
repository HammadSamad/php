<?php require "connection/connection.php"; session_start(); ?>

<?php

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
$viewUserDataPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
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
      $checkUserPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
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
      $profileUpdatePrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);

      if ($profileUpdatePrepare->execute()) {
          echo "<script>alert('Profile updated successfully.');</script>";
      } else {
          echo "<script>alert('Profile update unsuccessful.');</script>";
      }
  }
}




if (isset($_POST['deleteBtn'])) {

  // Prepare DELETE Query
  $deleteUserQuery = "DELETE FROM `users` WHERE `user_id` = :user_id";
  $deleteUserPrepare = $connect->prepare($deleteUserQuery);
  $deleteUserPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);

  // Execute Query
  if ($deleteUserPrepare->execute()) {
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
<html lang="en">
<head>
	<title>About</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<style>
  .password-field {
        font-family: monospace;
        -webkit-text-security: disc; /* Works in Safari, Chrome */
        -text-security: disc; /* Standard property */
    }
</style>
</head>
<body class="animsition">
	
	<!-- Header -->
	<?php require "partials/lightnavbar.php" ?>


	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			MY PROFILE
		</h2>
	</section>	


	<!-- Content page -->
	<section class="bg0 p-t-75 p-b-120">
		<div class="container">
			
    <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" onsubmit="return validateForm()">
                        <div class="row">
                          <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="firstName"
                              value="<?= $userData['first_name']?>"
                              autofocus
                            />
                            <small class="text-danger" id="firstNameError"></small>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input class="form-control" type="text" name="lastName" id="lastName" value="<?= $userData['last_name']?>" />
                            <small class="text-danger" id="lastNameError"></small>
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="userName" class="form-label">User Name</label>
                            <input class="form-control" type="text" name="userName" id="userName" value="<?= $userData['username']?>" />
                            <small class="text-danger" id="userNameError"></small>
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
                            <small class="text-danger" id="emailError"></small>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control password-field" type="text" name="password" id="password" value="<?= $userData['password_hash']?>"/>
                            <small class="text-danger" id="passwordError"></small>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="confirmPassword" class="form-label">Password Confirm</label>
                            <input class="form-control password-field" type="text" name="confirmPassword" id="confirmPassword" value="<?= $userData['password_hash']?>" />
                            <small class="text-danger" id="confirmPasswordError"></small>
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
                            <small class="text-danger" id="phoneError"></small>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= $addressData ?>" placeholder="The address has not been provided."/>
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

                          
                        </div>
                        <div class="mt-2">
                          <button type="submit" name="Btn" class="btn btn-primary me-2">Save changes</button>
                          <button type="reset" class="btn btn-outline-secondary" id="cancel">Cancel</button>
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
                      <form id="formAccountDeactivation" method="post">
                        <div class="form-check mb-3">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            name="accountActivation"
                            id="accountActivation"
                            required
                          />
                          <label class="form-check-label" for="accountActivation">I confirm my account delete</label>
                        </div>
                        <button type="submit" name="deleteBtn" class="btn btn-danger deactivate-account">Delete Account</button>
                      </form>
                    </div>
                  </div>
			
			
		</div>
	</section>	

	
		

	<!-- Footer -->
	<?php require "partials/footer.php" ?>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			$(this).css('position','relative');
			$(this).css('overflow','hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function(){
				ps.update();
			})
		});
	</script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
<!--===============================================================================================-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


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
<script>
document.addEventListener("DOMContentLoaded", function() {
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirmPassword");
    const originalPasswordHash = passwordField.dataset.realValue; // Original password hash

    let isPasswordChanged = false; // Track if password is changed

    // Track changes in password field
    passwordField.addEventListener("input", function() {
        if (this.value !== originalPasswordHash) {
            isPasswordChanged = true; // Password has been changed
        } else {
            isPasswordChanged = false; // Password is same as original
        }
    });

    // Validate form
    function validateForm() {
        let valid = true;

        // Regex patterns
        const nameRegex = /^[A-Za-z]{2,16}$/; // Only letters, min 2, max 16
        const userNameRegex = /^(?=.*[A-Za-z])[A-Za-z0-9]{3,18}$/; // Must contain at least one letter, letters and numbers allowed, min 3, max 18
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Standard email pattern
        const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/; // 1 Uppercase, 1 Lowercase, 1 Number, 1 Special Char, min 8, max 16
        const phoneRegex = /^[1-9][0-9]{6,14}$/; // Numbers only, min 7, max 15, first digit can't be 0

        // Get input values
        const firstName = document.getElementById("firstName").value;
        const lastName = document.getElementById("lastName").value;
        const userName = document.getElementById("userName").value;
        const email = document.getElementById("email").value;
        const password = passwordField.value;
        const confirmPassword = confirmPasswordField.value;
        const phoneNumber = document.getElementById("phoneNumber").value;

        // Validation checks
        if (!nameRegex.test(firstName)) {
            document.getElementById("firstNameError").innerText = "First name must be 2-16 letters only.";
            valid = false;
        } else {
            document.getElementById("firstNameError").innerText = "";
        }

        if (!nameRegex.test(lastName)) {
            document.getElementById("lastNameError").innerText = "Last name must be 2-16 letters only.";
            valid = false;
        } else {
            document.getElementById("lastNameError").innerText = "";
        }

        if (!userNameRegex.test(userName)) {
            document.getElementById("userNameError").innerText = "Username must be 3-18 characters and contain at least one letter.";
            valid = false;
        } else {
            document.getElementById("userNameError").innerText = "";
        }

        if (!emailRegex.test(email)) {
            document.getElementById("emailError").innerText = "Enter a valid email address.";
            valid = false;
        } else {
            document.getElementById("emailError").innerText = "";
        }

        // Password validation (only if password is changed)
        if (isPasswordChanged) {
            if (!passwordRegex.test(password)) {
                document.getElementById("passwordError").innerText = "Password must be 8-16 chars with 1 uppercase, 1 lowercase, 1 number, and 1 special char.";
                valid = false;
            } else {
                document.getElementById("passwordError").innerText = "";
            }

            if (password !== confirmPassword) {
                document.getElementById("confirmPasswordError").innerText = "Passwords do not match.";
                valid = false;
            } else {
                document.getElementById("confirmPasswordError").innerText = "";
            }
        } else {
            // If password is not changed, clear any existing error messages
            document.getElementById("passwordError").innerText = "";
            document.getElementById("confirmPasswordError").innerText = "";
        }

        if (!phoneRegex.test(phoneNumber)) {
            document.getElementById("phoneError").innerText = "Enter a valid phone number (7-15 digits, no leading 0).";
            valid = false;
        } else {
            document.getElementById("phoneError").innerText = "";
        }

        return valid;
    }

    // Attach validateForm to form submission
    document.getElementById("formAccountSettings").addEventListener("submit", function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
</script>
</body>
</html>