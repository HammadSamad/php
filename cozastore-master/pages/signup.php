<?php require "../connection/connection.php" ?>

<?php
session_start();
ob_start();


if(isset($_SESSION['userId']))
{
	header("location:../index.php");
}

// For Fetching Countries

$countryQuery = "SELECT * FROM `countries`";
$countryPrepare = $connect->prepare($countryQuery);
$countryPrepare->execute();
$countryData = $countryPrepare->fetchAll(PDO::FETCH_ASSOC);

// For Fetching Cities

$citiesQuery = "SELECT * FROM `cities`";
$citiesPrepare = $connect->prepare($citiesQuery);
$citiesPrepare->execute();
$citiesData = $citiesPrepare->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['Btn'])) {


	$password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if($password != $confirmPassword) {
        echo "<script>alert('Passwords do not match')</script>";
        exit();
    }else {

	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$userName = $_POST['userName'];
	$email = $_POST['email'];
	$phoneNumber = $_POST['phoneNumber'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$roleId = 2;
	$encryptedPassword = password_hash($password, PASSWORD_BCRYPT);


	$registrationQuery = "INSERT INTO `users`(`first_name`, `last_name`, `username`, `phone_number`, `password_hash`, `role_id`, `user_email`, `country_id`, `city_id`) VALUES (:firstName, :lastName, :userName, :phoneNumber, :password, :roleId, :email,  :country, :city)";
	$registrationPrepare = $connect->prepare($registrationQuery);
	$registrationPrepare->bindParam(':firstName',$firstName,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':lastName',$lastName,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':email',$email,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':password',$encryptedPassword,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':country',$country,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':city',$city,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':phoneNumber',$phoneNumber,PDO::PARAM_INT);
	$registrationPrepare->bindParam(':userName',$userName,PDO::PARAM_STR);
	$registrationPrepare->bindParam(':roleId',$roleId,PDO::PARAM_INT);


	$checkUserQuery = "SELECT * FROM `users` WHERE `username` = :username OR `user_email` = :email";
	$checkUserPrepare = $connect->prepare($checkUserQuery);
	$checkUserPrepare->bindParam(':username', $userName, PDO::PARAM_STR);
	$checkUserPrepare->bindParam(':email', $email, PDO::PARAM_STR);
	$checkUserPrepare->execute();
	$existingUser = $checkUserPrepare->fetch(PDO::FETCH_ASSOC);

	if($existingUser['username']==$userName){
		echo "<script>alert('Username already exists')</script>";
	}else if($existingUser['user_email']==$email){
		echo "<script>alert('Email already exists')</script>";
	}else{
		if($registrationPrepare->execute())
		{
			// $_SESSION['register_User_Email'] = $email;
			$_SESSION['userId'] = $userId;
			// header("location: registerCode.php");
			
			header("location: login.php");
			echo "<script>alert('User Registered')</script>";
		}
		else
		{
			echo "<script>alert('User not Registered')</script>";
		}
}
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>singup</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../images/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../fonts/linearicons-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="../vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/MagnificPopup/magnific-popup.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../css/util.css">
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<!--===============================================================================================-->


<style>
    .p-t-60, .p-tb-60, .p-all-60 {
    padding-top: 40px;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    padding-right: 0px;
    padding-left: 15px;
}
.p-r-30, .p-lr-30, .p-all-30 {
    padding-right: 0px;
}
.wrap-slick3 {
    width: 35rem;
    padding-left: 25px;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    padding-right: 0px;
    padding-left: 0px;
}
.form-check {
    margin-left: 1.5rem;
}
.size-101 {
    min-width: 375px;
    height: 46px;
    margin-top: 1.8rem;
    margin-right: auto;
    margin-left: auto;
}
.p-b-30, .p-tb-30, .p-all-30 {
    padding-bottom: 40px;
}
.p-t-33, .p-tb-33, .p-all-33 {
    padding-top: 20px;
}
.BGimage{
    background-image: url('240_F_355607062_zYMS8jaz4SfoykpWz5oViRVKL32IabTP.jpg');
    width: 88%;
    height: 100%;
    /* margin-left: 2.6rem; */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    flex-direction: column;
    gap: 1rem;
}
.form-group input[type="number"]::-webkit-inner-spin-button{
        -webkit-appearance: none;
    }
	.container {
    max-width: 80%;
}
</style>

</head>
<body class="animsition">
	
	<!-- Header -->
	<?php require "lightnavbar.php" ?>

	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('../images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			REGISTER
		</h2>
	</section>	
	<!-- Content page -->
	<section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr">
				<div class="size-210 bor10 p-lr-10-lg w-full-md">
				<div class="" style="width: 100%; height:100%;">
						<div class="p-lr-25 p-t-55 p-b-70 BGimage" style="width: 100%; height:100%;">
                            <h1 style="font-weight: 600;">Welcome</h1>
                            <p style="font-size: 18px; text-align: center;">To connected with us please share your personal info!</p>
                            
                            <a href="login.php" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 text-center" style="margin-top: 1rem; color:white; cursor:pointer;">
                            Already have an Account?
							</a>
                        </div>
					</div>
				</div>

				<div class="size-210 bor10 flex-w flex-col-m p-lr-50 p-tb-30 p-lr-15-lg w-full-md">

						<h1 class="mtext-105 cl2 p-b-14 text-center">
						Create an Account
							</h1>

					<div class="p-t-33">
                            <form action="" method="POST" onsubmit="return validateForm()">
								<div class="form-group">
                                    <label for="exampleInputEmail1">First Name</label>
                                    <input type="text" class="form-control" id="firstName" aria-describedby="emailHelp" placeholder="First Name" required spellcheck="true" name="firstName">
									<small class="text-danger" id="firstNameError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" aria-describedby="emailHelp" placeholder="Last Name" required spellcheck="true" name="lastName">
									<small class="text-danger" id="lastNameError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">UserName</label>
                                    <input type="text" class="form-control" id="userName" aria-describedby="emailHelp" placeholder="Last Name" required spellcheck="true" name="userName">
									<small class="text-danger" id="userNameError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" required name="email">
									<small class="text-danger" id="emailError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password" required name="password">
									<small class="text-danger" id="passwordError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm Password" required name="confirmPassword">
									<small class="text-danger" id="confirmPasswordError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone No.</label>
                                    <input type="number" class="form-control" id="phoneNumber" placeholder="Phone No." required name="phoneNumber">
									<small class="text-danger" id="phoneError"></small>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Country</label>
                                    <select class="form-control" id="countryId" name="country" onchange="countryFunc()">
                                        <option value="" selected disabled>Select your Country</option>
                                        <?php foreach ($countryData as $cd) { ?>
                                            <option value="<?= $cd['country_id'] ?>"><?= $cd['country_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">City</label>
                                    <select class="form-control" name="city" id="citySelectAdd">
                                        <option selected disabled>Select your Country first</option>
                                    </select>
                                </div>
                                
                                <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center" name="Btn">
                                    Submit
                                </button>

                            </form>
							</div>
				</div>
			</div>
		</div>
	</section>	

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

	<script>

	let countryId = document.getElementById('countryId');
	let cityId = document.getElementById('citySelectAdd');

	
	console.log(countryId);
	
	function countryFunc(){

		$.ajax({
			url: 'countryDependent.php',
			data: {
				countryId: countryId.value
			},
			type: 'POST',
			success:(data)=>{

				$('#citySelectAdd').html(data)

			}
		})
	}


</script>
	<!-- Footer -->
	<?php require "footer.php" ?>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

<!--===============================================================================================-->	
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/bootstrap/js/popper.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
<script src="../js/main.js"></script>
<!--===============================================================================================-->
<script>
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
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;
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

    if (!phoneRegex.test(phoneNumber)) {
        document.getElementById("phoneError").innerText = "Enter a valid phone number (7-15 digits, no leading 0).";
        valid = false;
    } else {
        document.getElementById("phoneError").innerText = "";
    }

    return valid;
}
</script>
</body>
</html>