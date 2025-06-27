<?php require "../connection/connection.php" ?>

<?php

session_start();

ob_start();


if(isset($_POST['Btn']))
{

	$userCode= $_POST['code'];


	if($_SESSION['forgotOTP'] == $userCode)
	{
		header('location: forgotPass.php');
		   unset($_SESSION['forgotOTP']);
	}
	else
	{
		echo "<script>alert('You have enterd wrong OTP')</script>";
	}


}


?>




<!DOCTYPE html>
<html lang="en">
<head>
	<title>login</title>
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
.container {
    max-width: 80%;
}
.form-group input[type="number"]::-webkit-inner-spin-button{
        -webkit-appearance: none;
    }
</style>

</head>
<body class="animsition">
	
	<!-- Header -->
	<?php require "lightnavbar.php" ?>

	
	<!-- Title page -->
	<section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('../images/bg-01.jpg');">
		<h2 class="ltext-105 cl0 txt-center">
			LOGIN
		</h2>
	</section>	


	<!-- Content page -->
	<section class="bg0 p-t-104 p-b-116">
		<div class="container">
			<div class="flex-w flex-tr">
				<div class="size-210 bor10 p-lr-10-lg w-full-md">
				<div class="" style="width: 100%; height:100%;">
						<div class="p-lr-25 p-t-55 p-b-70 BGimage" style="width: 100%; height:100%;">
                            <h1 style="font-weight: 600;">Email Verification</h1>
                            <p style="font-size: 18px; text-align: center;">Enter the verification code we sent on: <?php echo substr($_SESSION['user_Email'] , 0,6) ?>******@<?php echo explode("@", $_SESSION['user_Email'])[1]; ?></p>
                        </div>
					</div>
				</div>

				<div class="size-210 bor10 flex-w flex-col-m p-lr-50 p-tb-30 p-lr-15-lg w-full-md">

						<h1 class="mtext-105 cl2 p-b-14 text-center">
                            Login to Enter
							</h1>

					<div class="p-t-33">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Verification Code</label>
                                    <input type="number" name="code" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="code" oninput="this.value = this.value.slice(0, 6);" required>
                                    <small id="emailHelp" class="form-text text-muted" style="font-size: 11px;">Didn't receive any code? <a href="">Resent code</a></small>
                                </div>
                                <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center" name="Btn">
                                    Verify
                                </button>
                                
                                <!-- <p class="text-center p-t-13"><a href="#">Forgot Password?</a></p> -->
                            </form>

								
								
							</div>

				</div>
			</div>
		</div>
	</section>	
	
	
	



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
	<script src="../vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="../vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
<!--===============================================================================================-->
	<script src="../vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
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
	<script src="../https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="../js/map-custom.js"></script>
<!--===============================================================================================-->
	<script src="../js/main.js"></script>
</body>
</html>