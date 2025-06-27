<?php require "connection/connection.php";
session_start(); ob_start()?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Check Out</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
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
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--===============================================================================================-->


    <style>
        .p-t-60,
        .p-tb-60,
        .p-all-60 {
            padding-top: 40px;
        }

        .col,
        .col-1,
        .col-10,
        .col-11,
        .col-12,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-auto,
        .col-lg,
        .col-lg-1,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-auto,
        .col-md,
        .col-md-1,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-auto,
        .col-sm,
        .col-sm-1,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-auto,
        .col-xl,
        .col-xl-1,
        .col-xl-10,
        .col-xl-11,
        .col-xl-12,
        .col-xl-2,
        .col-xl-3,
        .col-xl-4,
        .col-xl-5,
        .col-xl-6,
        .col-xl-7,
        .col-xl-8,
        .col-xl-9,
        .col-xl-auto {
            padding-right: 0px;
            padding-left: 15px;
        }

        .p-r-30,
        .p-lr-30,
        .p-all-30 {
            padding-right: 0px;
        }

        .wrap-slick3 {
            width: 35rem;
            padding-left: 25px;
        }

        .col,
        .col-1,
        .col-10,
        .col-11,
        .col-12,
        .col-2,
        .col-3,
        .col-4,
        .col-5,
        .col-6,
        .col-7,
        .col-8,
        .col-9,
        .col-auto,
        .col-lg,
        .col-lg-1,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9,
        .col-lg-auto,
        .col-md,
        .col-md-1,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9,
        .col-md-auto,
        .col-sm,
        .col-sm-1,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9,
        .col-sm-auto,
        .col-xl,
        .col-xl-1,
        .col-xl-10,
        .col-xl-11,
        .col-xl-12,
        .col-xl-2,
        .col-xl-3,
        .col-xl-4,
        .col-xl-5,
        .col-xl-6,
        .col-xl-7,
        .col-xl-8,
        .col-xl-9,
        .col-xl-auto {
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

        .p-b-30,
        .p-tb-30,
        .p-all-30 {
            padding-bottom: 40px;
        }

        .p-t-33,
        .p-tb-33,
        .p-all-33 {
            padding-top: 20px;
        }

        .BGimage {
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

        .form-group input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .container {
            max-width: 95%;
        }




        .order-container {
            background-color: #fff;
            width: 30%;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 0.5px solid #eee;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .order-summary th,
        .order-summary td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .order-summary tfoot td {
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #ddd;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
        }

        .payment-method {
            margin-bottom: 20px;
        }

        .payment-method input[type="radio"] {
            margin-right: 10px;
        }

        .payment-method p {
            margin: 5px 0 0 25px;
            font-size: 14px;
            color: #666;
        }

        .terms {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .terms input[type="checkbox"] {
            margin-right: 10px;
        }

        .terms a {
            color: #007bff;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .pay-now {
            background-color: #717fe0;
            color: #fff;
            font-size: 16px;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            text-transform: uppercase;
        }

        .pay-now:hover {
            background-color: #000;
        }


        .size-210 {
            width: 100%;
        }

        .qty-btn {
            width: 45px;
            height: 100%;
            cursor: pointer;
            justify-content: center;
            -ms-align-items: center;
            align-items: center;
            transition: all 0.4s;
        }
    </style>
</head>



<?php

// 1. Check if the user is logged in
// if (!isset($_SESSION['userId'])) {
//     header("Location: pages/login.php");
//     exit();
// }

// 2. Get user id from session
$id = $_SESSION['userId'];

// 3. Check if the user has any product in the cart
$cartViewQuery = 'SELECT * FROM `carts` JOIN products ON products.product_id = carts.prod_id WHERE user_id = :id';
$cartViewPrepare = $connect->prepare($cartViewQuery);
$cartViewPrepare->bindParam(':id', $id, PDO::PARAM_INT);
$cartViewPrepare->execute();
$viewCartData = $cartViewPrepare->fetchAll(PDO::FETCH_ASSOC);

// If the cart is empty, redirect to the product page
// if (empty($viewCartData)) {
//     header("Location: product.php");
//     exit();
// }

// 4. Fetch the user’s address, phone number, and credit card details
$addressdataQuery = "SELECT * FROM `user_address` WHERE `user_id` = :id";
$addressdataPrepare = $connect->prepare($addressdataQuery);
$addressdataPrepare->bindParam(':id', $id, PDO::PARAM_INT);
$addressdataPrepare->execute();
$addressData = $addressdataPrepare->fetch(PDO::FETCH_ASSOC);

$phoneNumberDataQuery = "SELECT * FROM `users` WHERE user_id = :id";
$phoneNumberDataPrepare = $connect->prepare($phoneNumberDataQuery);
$phoneNumberDataPrepare->bindParam(':id', $id, PDO::PARAM_INT);
$phoneNumberDataPrepare->execute();
$phoneNumberData = $phoneNumberDataPrepare->fetch(PDO::FETCH_ASSOC);

$creditCardDataQuery = "SELECT * FROM `creditcard` WHERE user_id = :id";
$creditCardDataPrepare = $connect->prepare($creditCardDataQuery);
$creditCardDataPrepare->bindParam(':id', $id, PDO::PARAM_INT);
$creditCardDataPrepare->execute();
$creditCardData = $creditCardDataPrepare->fetch(PDO::FETCH_ASSOC);

// 5. Fetch the subtotal of the cart
$subTotalQuery = 'SELECT ROUND(SUM(products.product_price * carts.quantity), 2) as subTotal FROM `carts` JOIN products ON products.product_id = carts.prod_id WHERE user_id = :id';
$subTotalPrepare = $connect->prepare($subTotalQuery);
$subTotalPrepare->bindParam(':id', $id, PDO::PARAM_INT);
$subTotalPrepare->execute();
$subTotal = $subTotalPrepare->fetch(PDO::FETCH_ASSOC);

if(!empty($addressData['address'])){
    $address = $addressData['address'];
}else{
    $address = "";
}

if(!empty($phoneNumberData['phone_number'])){
    $phoneNumber = $phoneNumberData['phone_number'];
}else{
    $phoneNumber = "";
}

if(!empty($creditCardData['cardNumber'])){
    $creditCard = $creditCardData['cardNumber'];
}else{
    $creditCard = "";
}

if(!empty($creditCardData['cvv'])){
    $cvv = $creditCardData['cvv'];
}else{
    $cvv = "";
}

if(!empty($creditCardData['expiryDate'])){
    $expiryDate = $creditCardData['expiryDate'];
}else{
    $expiryDate = "";
}

// 6. Check if the user submitted the form
if (isset($_POST['Btn'])) {
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];
    $paymentCard = $_POST['paymentCard'];
    $cvv = $_POST['cvv'];
    $expiryDate = $_POST['expiry'];

    // Update or Insert the address
    if (!empty($addressData['address'])) {
        $addressUpdateQuery = "UPDATE `user_address` SET `address` = :address WHERE `user_id` = :id";
        $addressUpdatePrepare = $connect->prepare($addressUpdateQuery);
        $addressUpdatePrepare->bindParam(':address', $address, PDO::PARAM_STR);
        $addressUpdatePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($addressUpdatePrepare->execute()) {
            // echo "<script>alert('Address Updated Successfully')</script>";
            echo "<script>alert('Data Updated Successfully')</script>";
        }
    } else {
        $addressInsertQuery = "INSERT INTO `user_address` (`address`, `user_id`) VALUES (:address, :user_id)";
        $addressInsertPrepare = $connect->prepare($addressInsertQuery);
        $addressInsertPrepare->bindParam(':address', $address, PDO::PARAM_STR);
        $addressInsertPrepare->bindParam(':user_id', $id, PDO::PARAM_INT);
        
        if ($addressInsertPrepare->execute()) {
            // echo "<script>alert('Address Inserted Successfully')</script>";
            echo "<script>alert('Data Inserted Successfully')</script>";
        }
    }

    // Update the phone number
    $phoneNumberInsertQuery = "UPDATE `users` SET `phone_number` = :phoneNumber WHERE user_id = :id";
    $phoneNumberInsertPrepare = $connect->prepare($phoneNumberInsertQuery);
    $phoneNumberInsertPrepare->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_INT);
    $phoneNumberInsertPrepare->bindParam(':id', $id, PDO::PARAM_INT);
    
    if ($phoneNumberInsertPrepare->execute()) {
        // echo "<script>alert('Phone Number Updated Successfully')</script>";
    }
    // Check and update credit card details
    $checkCardQuery = "SELECT COUNT(*) FROM `creditcard` WHERE `user_id` = :id";
    $checkCardPrepare = $connect->prepare($checkCardQuery);
    $checkCardPrepare->bindParam(':id', $id, PDO::PARAM_INT);
    $checkCardPrepare->execute();
    $cardExists = $checkCardPrepare->fetchColumn();

    if ($cardExists) {
        // Update existing credit card data
        $paymentCardUpdateQuery = "UPDATE `creditcard` SET `cardNumber` = :paymentCard, `cvv` = :cvv, `expiryDate` = :expiryDate WHERE `user_id` = :id";
        $paymentCardUpdatePrepare = $connect->prepare($paymentCardUpdateQuery);
        $paymentCardUpdatePrepare->bindParam(':paymentCard', $paymentCard, PDO::PARAM_STR);
        $paymentCardUpdatePrepare->bindParam(':cvv', $cvv, PDO::PARAM_INT);
        $paymentCardUpdatePrepare->bindParam(':expiryDate', $expiryDate, PDO::PARAM_STR);
        $paymentCardUpdatePrepare->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($paymentCardUpdatePrepare->execute()) {
            // echo "<script>alert('Data Updated Successfully')</script>";
        }
    } else {
        // Insert new credit card data
        $paymentCardInsertQuery = "INSERT INTO `creditcard` (`cardNumber`, `cvv`, `expiryDate`, `user_id`) VALUES (:paymentCard, :cvv, :expiryDate, :user_id)";
        $paymentCardInsertPrepare = $connect->prepare($paymentCardInsertQuery);
        $paymentCardInsertPrepare->bindParam(':paymentCard', $paymentCard, PDO::PARAM_STR);
        $paymentCardInsertPrepare->bindParam(':cvv', $cvv, PDO::PARAM_INT);
        $paymentCardInsertPrepare->bindParam(':expiryDate', $expiryDate, PDO::PARAM_STR);
        $paymentCardInsertPrepare->bindParam(':user_id', $id, PDO::PARAM_INT);
        
        if ($paymentCardInsertPrepare->execute()) {
            // echo "<script>alert('Data Inserted Successfully')</script>";
        }
    }
}


// 7. Checkout process
if (isset($_POST['checkOutBtn'])) {
    if (empty($viewCartData)) {
        echo "<script>alert('Please add a product to your cart.')</script>";
        exit();
    }

    $userId = $_SESSION['userId'];
    $orderId = rand(1000000000000001, 9999999999999999);
    $totalAmount = $subTotal['subTotal'] + 50;
    $paymentMethod = $_POST['paymentMethod'];
    
    $orderInsertQuery = "INSERT INTO `orders` (`order_id`, `user_id`, `total_amount`, `payment_method_id`) VALUES (:orderId, :userId, :totalAmount, :paymentMethod)";
    $orderInsertPrepare = $connect->prepare($orderInsertQuery);
    $orderInsertPrepare->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $orderInsertPrepare->bindParam(':userId', $userId, PDO::PARAM_INT);
    $orderInsertPrepare->bindParam(':totalAmount', $totalAmount, PDO::PARAM_INT);
    $orderInsertPrepare->bindParam(':paymentMethod', $paymentMethod, PDO::PARAM_INT);
    


    if ($paymentMethod == 1 || $paymentMethod == 2) {
		// ✅ Payment Validation
		if (
			($paymentMethod == 1 && $address && $phoneNumber) || 
			($paymentMethod == 2 && $creditCard && $cvv && $expiryDate)
		) {
			// ✅ Insert Order First
			if ($orderInsertPrepare->execute()) {
				foreach ($viewCartData as $cart) {
					$prodId = $cart['product_id'];
					$quantity = $cart['quantity'];
					$stockQty = $cart['stock_quantity']; // ✅ Correct stock quantity
					$qtyMin = $stockQty - $quantity;
	
					// ✅ Insert Order Details
					$orderCartInsertQuery = "INSERT INTO `order_product` (`order_id`, `prod_id`, `user_id`, `quantity`) 
											 VALUES (:orderId, :prodId, :userId, :quantity)";
					$orderCartInsertPrepare = $connect->prepare($orderCartInsertQuery);
					$orderCartInsertPrepare->bindParam(':orderId', $orderId, PDO::PARAM_INT);
					$orderCartInsertPrepare->bindParam(':prodId', $prodId, PDO::PARAM_INT);
					$orderCartInsertPrepare->bindParam(':userId', $userId, PDO::PARAM_INT);
					$orderCartInsertPrepare->bindParam(':quantity', $quantity, PDO::PARAM_INT);
	
					if ($orderCartInsertPrepare->execute()) {
						// ✅ Update Product Stock Quantity
						$prodQuantityUpdateQuery = "UPDATE `products` SET `stock_quantity` = :qtyMin WHERE `product_id` = :product_id";
						$prodQuantityUpdatePrepare = $connect->prepare($prodQuantityUpdateQuery);
						$prodQuantityUpdatePrepare->bindParam(':qtyMin', $qtyMin, PDO::PARAM_INT);
						$prodQuantityUpdatePrepare->bindParam(':product_id', $prodId, PDO::PARAM_INT);
						$prodQuantityUpdatePrepare->execute();
					}
				}
	
				// ✅ Empty Cart After Order Placement
				$clearCartQuery = "DELETE FROM carts WHERE user_id = :userId";
				$clearCartPrepare = $connect->prepare($clearCartQuery);
				$clearCartPrepare->bindParam(':userId', $userId, PDO::PARAM_INT);
				$clearCartPrepare->execute();
	
				// ✅ Security Fix for Order ID Alert
				$safeOrderId = htmlspecialchars($orderId);
				echo "<script>alert('Your order has been placed successfully. Your Order ID is $safeOrderId.')</script>";
			} else {
				echo "<script>alert('Error placing order. Please try again.')</script>";
			}
		} else {
			echo "<script>alert('". ($paymentMethod == 1 ? 'Please fill the address and phone number' : 'Please fill the credit card details') ."')</script>";
		}
	}
}
$shipmentViewQuery = "SELECT * FROM shipment";
    $shipmentViewPrepare = $connect->prepare($shipmentViewQuery);
    $shipmentViewPrepare->execute();
    $shipmentData = $shipmentViewPrepare->fetchAll(PDO::FETCH_ASSOC);
	$shipmentPrice = $shipmentData[0]['Shipment_price'];
    // echo $shipmentPrice;
?>




<body class="animsition">

    <!-- Header -->
    <?php require "partials/lightnavbar.php" ?>

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Checkout
        </h2>
    </section>

    <?php 
        if (isset($_SESSION['userId'])) { ?>
    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-10-lg w-full-md d-flex">


                    <div class="size-210 bor10 flex-w flex-col-m p-lr-50 p-tb-30 p-lr-15-lg w-full-md" style="width:70%">

                        <h1 class="mtext-105 cl2 p-b-14 text-center"> PAYMENT DETAILS </h1>

                        <div class="p-t-33">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Address</label>
                                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Address" required name="address" spellcheck="true" value="<?= $address ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Phone No.</label>
                                    <input type="number" class="form-control" id="exampleInputPassword1" placeholder="Phone No." required name="phoneNumber" value="<?= $phoneNumber ?>">
                                </div>

                                <div id="creditCardNumberContainer" style="justify-content: space-between;display:none">
                                    <div class="form-group col-5">
                                        <label for="exampleInputPassword1">Card Number</label>
                                        <input type="number" class="form-control" id="card_number" maxlength="16" placeholder="Enter Card Number" name="paymentCard" value="<?= $creditCard ?>">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="exampleInputPassword1">CVV</label>
                                        <input type="number" class="form-control" id="cvv" maxlength="3" placeholder="Enter CVV"  name="cvv" value="<?= $cvv ?>">
                                    </div>
                                    <div class="form-group col-2">
                                        <label for="expiry">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry" name="expiry" placeholder="DD/MM/YYYY" value="<?= $expiryDate ?>">
                                    </div>
                                </div>

                        <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center" name="Btn" id="Btn-submit">
                            <?php 
                                if (empty($addressData['address'])) {
                                    echo "Submit your address first";
                                } else {
                                    echo "Update";
                                } 
                            ?>
                        </button>

                        </form>
                    </div>
                </div>



                <div class="order-container">
                    <h2>Your Order</h2>
                    <div class="order-summary">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($viewCartData as $cData) {
                                    echo "<tr>";
                                    echo "<td>" . mb_strimwidth($cData['product_name'] , 0, 15, "...") . " x " . $cData['quantity'] . "</td>";
                                    echo "<td>$" . ($cData['quantity'] * $cData['product_price']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>Subtotal</td>
                                    <td>$<?= $subTotal['subTotal'] ?></td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td>$<?=$shipmentPrice?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>$<?= $subTotal['subTotal'] + $shipmentPrice ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <form class="payment-options" method="POST">
                        <div class="payment-method d-flex">
                            <input type="radio" id="cash-payment" name="paymentMethod" value="1" checked>
                            <label for="check-payment" style="margin-bottom: 0%;">Cash On Delivery</label>
                        </div>

                        <div class="payment-method d-flex">
                            <input type="radio" id="paypal" name="paymentMethod" value="2">
                            <label for="paypal" style="margin-bottom: 0%;">PayPal</label>
                        </div>

                        <div class="terms">
                            <input type="checkbox" id="terms" name="terms" required>
                            <label for="terms">I’ve read and accept the <a href="#">terms & conditions</a>*</label>
                        </div>
                        
                        <div id="paymentMethodContainer">
                            <?php 
                            if ($address && $phoneNumber) {
                                echo "<button type='submit' class='pay-now text-center' name='checkOutBtn'>Pay Now</button>";
                            } else {
                                echo "<div class='pay-now text-center' style='background-color: #666; cursor: not-allowed;'>Submit your address first</div>";
                            }
                            ?>
                            
                            </div>
                        
                    </form>
                </div>




            </div>
        </div>
    </section>

<?php } else { ?>
<div class="container" style="display: flex; align-items: center; justify-content: center; height: 35%;">
    <div class="text-container"
        style="display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 25px;">
        <div>
            <h3>Please login first!</h3>
        </div>
        <a href="pages/login.php"
            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center">Login
            >></a>
    </div>
</div>
<?php } ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        let countryId = document.getElementById('countryId');
        let cityId = document.getElementById('citySelectAdd');


        console.log(countryId);

        function countryFunc() {

            $.ajax({
                url: 'countryDependent.php',
                data: {
                    countryId: countryId.value
                },
                type: 'POST',
                success: (data) => {

                    $('#citySelectAdd').html(data)

                }
            })
        }
    </script>
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
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
    <!--===============================================================================================-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!--===============================================================================================-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <!--===============================================================================================-->


    <script>
        document.getElementById('card_number').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 16); // Allows only digits and limits to 16 characters
        });


        document.getElementById('cvv').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 3); // Allows only digits and limits to 3 characters
        });

        document.getElementById('expiry').addEventListener('input', function() {
            let input = this.value.replace(/\D/g, ''); // Remove all non-digit characters
            if (input.length > 8) {
                input = input.slice(0, 8); // Limit to 8 digits
            }

            // Automatically add slashes for DD/MM/YYYY format
            if (input.length > 4) {
                this.value = `${input.slice(0, 2)}/${input.slice(2, 4)}/${input.slice(4)}`;
            } else if (input.length > 2) {
                this.value = `${input.slice(0, 2)}/${input.slice(2)}`;
            } else {
                this.value = input;
            }
        });


        let payPalPayment = document.getElementById('paypal');

        let Btn = document.getElementById('Btn-submit');
        let paymentMethodCont = document.getElementById('paymentMethodContainer');


        payPalPayment.addEventListener('change', function(e) {
            if (this.checked) {
                let creditCardNumberContainer = document.getElementById('creditCardNumberContainer');
                console.log("Paypal")
                creditCardNumberContainer.classList.add('d-flex');

                Btn.innerHTML = `
                    <?php 
                    if (empty($addressData['address']) && empty($creditCardData['cardNumber'])) {
                        echo "Submit your address and credit card details first";
                    } elseif (empty($addressData['address'])) {
                        echo "Submit your address first";
                    } elseif (empty($creditCardData['cardNumber'])) {
                        echo "Submit your credit card details first";
                    } else {
                        echo "Update";
                    } 
                    ?>
                `

                paymentMethodCont.innerHTML = `
                    <?php 
                    if ($creditCard && $cvv && $expiryDate) {
                        echo "<button type='submit' class='pay-now text-center' name='checkOutBtn'>Pay Now</button>";
                    } else {
                        echo "<div class='pay-now text-center' style='background-color: #666; cursor: not-allowed;'>Submit your card details first</div>";
                    }
                   ?>
                `

            }

        });

        let cashPayment = document.getElementById('cash-payment');

        cashPayment.addEventListener('change', function(e) {
            if (this.checked) {
                let creditCardNumberContainer = document.getElementById('creditCardNumberContainer');
                console.log("cashPayment")
                creditCardNumberContainer.classList.remove('d-flex');
                creditCardNumberContainer.style.display = 'none';

                Btn.innerHTML = `
                    <?php 
                    if (empty($addressData['address'])) {
                        echo "Submit your address first";
                    } else {
                        echo "Update";
                    } 
                    ?>
                `
                paymentMethodCont.innerHTML = `
                    <?php 
                    if ($address && $phoneNumber) {
                        echo "<button type='submit' class='pay-now text-center' name='checkOutBtn'>Pay Now</button>";
                    } else {
                        echo "<div class='pay-now text-center' style='background-color: #666; cursor: not-allowed;'>Submit your address first</div>";
                    }
                    ?>
                `
                
                

            }

        });


        $(document).ready(function() {
    // Set up the datepicker
    $("#expiry").datepicker({
        dateFormat: "dd/mm/yy", // Format for date selection
        minDate: 0, // Prevent selecting past dates
        changeMonth: true,
        changeYear: true,
        yearRange: "c:c+10" // Limit to current and next 10 years
    });

    // Get the expiry date from PHP
    var expiryDate = "<?= $expiryDate ?>";

    // Set expiry date in datepicker if available
    if (expiryDate) {
        $("#expiry").datepicker("setDate", expiryDate);
    }
});



    </script>





</body>

</html>