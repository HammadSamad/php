<?php
require "connection/connection.php"; session_start();

if(!isset($_SESSION['userId'])){

}else{

$viewUserDataQuery = "SELECT * FROM users WHERE users.user_id = :user_id";
$viewUserDataPrepare = $connect->prepare($viewUserDataQuery);
$viewUserDataPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
$viewUserDataPrepare->execute();
$userData = $viewUserDataPrepare->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['send-btn'])) {
  echo "Send";
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $msg = $_POST['msg'];
  // Ensure all fields are filled
    if (empty($name) || empty($lastname) || empty($email) || empty($phone) || empty($msg)) {
        echo '<script>alert("All fields are required.")</script>';
    } else {
        // Insert query
        $contactQuery = "INSERT INTO `contact`(`first_Name`, `last_Name`, `email`, `phone_number`, `message`) 
                        VALUES (:first_name, :last_name, :email, :phone, :message)";
        $contactPrepare = $connect->prepare($contactQuery);
        $contactPrepare->bindParam(':first_name', $name, PDO::PARAM_STR);
        $contactPrepare->bindParam(':last_name', $lastname, PDO::PARAM_STR);
        $contactPrepare->bindParam(':email', $email, PDO::PARAM_STR);
        $contactPrepare->bindParam(':phone', $phone, PDO::PARAM_INT);
        $contactPrepare->bindParam(':message', $msg, PDO::PARAM_STR);
        if ($contactPrepare->execute()) {
            echo '<script>alert("Form Submitted successfully")</script>';
        } else {
            echo '<script>alert("Failed to submit form. Please try again.")</script>';
        }
    }
}
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Contact</title>
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
</head>
<style>
	
  .about-main-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    background-color: #e1eefa;
  }

  .about-sub-main-container {
    width: 95%;
    background-color: whitesmoke;
    margin-top: 15px;
    padding: 15px;
  }




  /* contact start */



  .contact-form {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    align-items: center;
    /* justify-items: space-between; */

    padding-left: 50px;
    padding-right: 50px;
  }

  .main-head {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-bottom: 1rem;
  }


  .contact-form form {
    padding-bottom: 1rem;
  }

  .form-control {
    width: 100%;
    border: 1.5px solid #c7c7c7;
    border-radius: 5px;
    padding: 0.7rem;
    margin: 0.6rem 0;
    font-family: 'Open Sans', sans-serif;
    font-size: 1rem;
    outline: 0;
  }

  .form-control:focus {
    box-shadow: 0 0 6px -3px rgba(48, 48, 48, 1);
  }

  .contact-form form div {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    column-gap: 0.6rem;
  }

  .send-btn {
    width: 100px;
    color: whitesmoke;
    font-weight: 600;
    font-size: 18px;
    background-color:rgb(35, 15, 216);
    border: 1px solid var(--heading-color);
    transition: 0.5s linear ease-in-out;
    height: 32px;
	border-radius: 25px;
  }

  .send-btn:hover {
    background-color: rgb(0, 0, 0);
    cursor: pointer;
    color: white;
  }

  .contact-form>div img {
    width: 85%;
  }

  .contact-form>div {
    margin: 0 auto;
    text-align: center;
  }
  .number-I-D input[type="number"]::-webkit-inner-spin-button{
        -webkit-appearance: none;
    }

  @media screen and (min-width: 1200px) {
    .contact-info {
      grid-template-columns: repeat(4, 1fr);
    }

  }

  @media screen and (min-width: 992px) {
    .contact-bg .text {
      width: 50%;
    }


  }

  @media screen and (min-width: 768px) {
    .contact-bg .text {
      width: 70%;
      margin-left: auto;
      margin-right: auto;
    }


    .contact-info {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media screen and (max-width: 580px) {
    .contact-form {
      padding-left: 17px;
      padding-right: 17px;
    }

  }





  @media screen and (max-width: 480px) {
    .contact-bg h2 {
      font-size: 2rem;

    }

    .contact-bg .text {
      font-size: 0.8rem;
    }

    .contact-form {
      padding-left: 18px;
      padding-right: 18px;
    }
  }

  @media screen and (max-width: 400px) {
    .contact-bg h2 {
      font-size: 2rem;

    }

    .contact-bg .text {
      font-size: 0.8rem;
    }

  }

  /* contact end */


</style>
<body class="animsition">

<?php require "partials/lightnavbar.php" ?>
	
	<!-- Header -->


	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			Contact
		</h2>
	</section>	


	<!-- Content page -->
	<section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="">
			<div class="contact-form">
        <h1 class="main-head">Contact Form</h1>
		<form action="" method="POST" id="reset" onsubmit="return validateForm()">

          <input type="hidden" name="access_key" value="5c7c617b-de0c-424d-88ed-ee2998e2b000">
          <div>
            <input id="c_firstName" name="name" type="text" class="form-control" value="<?=$userData['first_name']?>" placeholder="First Name">

            <input id="c_lastName" name="lastname" type="text" class="form-control" value="<?=$userData['last_name']?>" placeholder="Last Name">
          </div>
          <div>
            <p class="text-danger" id="firstName_error"></p>
            <p class="text-danger" id="lastName_error"></p>

          </div>
          <div class="number-I-D">
            <input id="c_email" name="email" type="email" class="form-control" value="<?=$userData['user_email']?>" placeholder="E-mail">
            <input id="c_phone" name="phone" type="number" class="form-control" value="<?=$userData['phone_number']?>" placeholder="Phone">
          </div>
          <div>
            <p class="text-danger" id="email_error"></p>
            <p class="text-danger" id="phone_error"></p>

          </div>
          <textarea id="c_message" rows="5" name="msg" placeholder="Message" class="form-control"></textarea>
          <p class="text-danger" id="message_error"></p>
          <button type="submit" id="c_btn" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center" name="send-btn" style="margin-left:43%;"> Submit
          </button>

          <br>
          <!-- <div id="successMessage" style="display: flex; justify-content: center;"></div> -->
        </form>

        <!-- <div>
          <img src="image/contact-png.png" alt="">
        </div> -->
      </div>
			</div>
		</div>
	</section>	
	
	
	<!-- Map -->
	<div class = "map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3616.5340516709284!2d67.06039278680284!3d24.981962883287462!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb340e584b891c3%3A0x29b2cbc198ba2dbd!2sAptech%20Computer%20Education%20North%20Karachi%20Center!5e0!3m2!1sen!2s!4v1716619477774!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>


	<!-- Footer -->

  <?php require "partials/footer.php" ?>
	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

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








  
  <script>
    AOS.init();
  </script>
  <script>
function validateForm() {
    let valid = true;

    // Regex patterns
    const nameRegex = /^[A-Za-z]{2,16}$/; // Only letters, min 2, max 16
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Standard email pattern
    const phoneRegex = /^[1-9][0-9]{6,14}$/; // Numbers only, min 7, max 15, first digit can't be 0

    // Get input values
    const firstName = document.getElementById("c_firstName").value;
    const lastName = document.getElementById("c_lastName").value;
    const email = document.getElementById("c_email").value;
    const phoneNumber = document.getElementById("c_phone").value;

    // Validation checks
    if (!nameRegex.test(firstName)) {
        document.getElementById("firstName_error").innerText = "First name must be 2-16 letters only.";
        valid = false;
    } else {
        document.getElementById("firstName_error").innerText = "";
    }

    if (!nameRegex.test(lastName)) {
        document.getElementById("lastName_error").innerText = "Last name must be 2-16 letters only.";
        valid = false;
    } else {
        document.getElementById("lastName_error").innerText = "";
    }

    if (!emailRegex.test(email)) {
        document.getElementById("email_error").innerText = "Enter a valid email address.";
        valid = false;
    } else {
        document.getElementById("email_error").innerText = "";
    }

    if (!phoneRegex.test(phoneNumber)) {
        document.getElementById("phone_error").innerText = "Enter a valid phone number (7-15 digits, no leading 0).";
        valid = false;
    } else {
        document.getElementById("phone_error").innerText = "";
    }

    return valid;
}
</script>
 
</body>
</html>