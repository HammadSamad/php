<?php require "../connection/connection.php" ?>

<?php

ob_start();
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$userEmail = $_SESSION['user_Email'];

    $verifyEmailQuery = "SELECT * FROM `users` WHERE `user_email` = :email";
	$verifyEmailPrepare = $connect->prepare($verifyEmailQuery);
	$verifyEmailPrepare->bindParam(':email',$userEmail,PDO::PARAM_STR);
	$verifyEmailPrepare->execute();
	$verifyEmailData = $verifyEmailPrepare->fetch(PDO::FETCH_ASSOC);
	

	if($verifyEmailData['user_id'])
	{		

	$randomCode = rand(1111,9999);
	$_SESSION['forgotOTP'] = $randomCode;
	$_SESSION['userForgotPassId'] = $verifyEmailData['user_id'];

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'zainaijaz51@gmail.com';                     //SMTP username
    $mail->Password   = 'boyfwovazpwdqcpj';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('zainaijaz51@gmail.com', 'Mailer');
    $mail->addAddress($userEmail, 'Joe User');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Forgot Password';
    $mail->Body    = "<!DOCTYPE html>
	<html lang='en'>
	<head>
		<meta charset='UTF-8'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<title>OTP Verification</title>
		<style>
			body {
				font-family: Arial, sans-serif;
				margin: 0;
				padding: 0;
				background-color: #f6f6f6;
			}
			.email-container {
				width: 100%;
				max-width: 600px;
				margin: 0 auto;
				background-color: #ffffff;
				padding: 20px;
				border-radius: 8px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			}
			.email-header {
				text-align: center;
				padding: 10px 0;
				border-bottom: 1px solid #e0e0e0;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 9px;
			}
			.email-header img {
				max-width: 150px;
			}
			.email-body {
				padding: 20px;
			}
			h1 {
				color: #333333;
				font-size: 24px;
				text-align: center;
			}
			p {
				font-size: 16px;
				color: #666666;
				line-height: 1.6;
			}
			.otp-container {
				background-color: #f0f0f0;
				border: 2px solid #e0e0e0;
                padding: 20px 23%;
				text-align: center;
				font-size: 24px;
				font-weight: bold;
				color: #333333;
				margin: 20px 0;
				border-radius: 8px;
                letter-spacing: 80px;
			}
			.cta-button {
				display: block;
				width: 200px;
				margin: 20px auto;
				padding: 12px;
				background-color: #4CAF50;
				color: white;
				text-align: center;
				text-decoration: none;
				border-radius: 5px;
				font-size: 16px;
			}
			.cta-button:hover {
				background-color: #45a049;
			}
			.email-footer {
				text-align: center;
				padding: 10px;
				font-size: 14px;
				color: #999999;
			}
			.email-footer a {
				color: #4CAF50;
				text-decoration: none;
			}
			.email-footer a:hover {
				text-decoration: underline;
			}
            .app-brand-text{
                font-size: 1.5rem;
                font-weight: 900;
                color: #717fe0;
                
            }
		</style>
	</head>
	<body>
		<div class='email-container'>
			<div class='email-header'>
            <span class='app-brand-logo demo'>
                <svg
                  width='25'
                  viewBox='0 0 25 42'
                  version='1.1'
                  xmlns='http://www.w3.org/2000/svg'
                  xmlns:xlink='http://www.w3.org/1999/xlink'
                >
                  <defs>
                    <path
                      d='M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z'
                      id='path-1'
                    ></path>
                    <path
                      d='M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z'
                      id='path-3'
                    ></path>
                    <path
                      d='M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z'
                      id='path-4'
                    ></path>
                    <path
                      d='M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z'
                      id='path-5'
                    ></path>
                  </defs>
                  <g id='g-app-brand' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'>
                    <g id='Brand-Logo' transform='translate(-27.000000, -15.000000)'>
                      <g id='Icon' transform='translate(27.000000, 15.000000)'>
                        <g id='Mask' transform='translate(0.000000, 8.000000)'>
                          <mask id='mask-2' fill='white'>
                            <use xlink:href='#path-1'></use>
                          </mask>
                          <use fill='#696cff' xlink:href='#path-1'></use>
                          <g id='Path-3' mask='url(#mask-2)'>
                            <use fill='#696cff' xlink:href='#path-3'></use>
                            <use fill-opacity='0.2' fill='#FFFFFF' xlink:href='#path-3'></use>
                          </g>
                          <g id='Path-4' mask='url(#mask-2)'>
                            <use fill='#696cff' xlink:href='#path-4'></use>
                            <use fill-opacity='0.2' fill='#FFFFFF' xlink:href='#path-4'></use>
                          </g>
                        </g>
                        <g
                          id='Triangle'
                          transform='translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) '
                        >
                          <use fill='#696cff' xlink:href='#path-5'></use>
                          <use fill-opacity='0.2' fill='#FFFFFF' xlink:href='#path-5'></use>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </span>
              <span class='app-brand-text'>Shopping Cart</span>
			</div>
			<div class='email-body'>
				<h1>OTP Verification</h1>
				<p>Hello, User</p>
				<p>We received a request to verify your identity using a One-Time Password (OTP). Please use the OTP below to complete your verification process:</p>
				<div class='otp-container'>
				 $randomCode
				</div>
				<p>This OTP is valid for the next 10 minutes. If you did not request this, please ignore this email.</p>
				<p>For security reasons, please do not share this OTP with anyone.</p>
			</div>
			<div class='email-footer'>
				<p>© 2024 Shopping Cart. All rights reserved.</p>
			</div>
		</div>
	</body>
	</html>
	";


    $mail->send();
    // echo 'Message has been sent';
	header('location: forgotPassCode.php');
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

	}

	else
	{
		echo "<script>alert('Incorrect email')</script>";
	}
	
	
	


?>