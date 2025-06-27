<?php 
require "connection/connection.php"; 
session_start(); 
$isOrderFound = true;

if (isset($_POST['Btn'])) {
    $search = $_POST['search'];
    $searchValue = "%" . $search . "%";

    $viewOrderQuery = "SELECT * FROM orders WHERE order_id LIKE :search AND user_id = :user_id";

    $viewOrder = $connect->prepare($viewOrderQuery);
    $viewOrder->bindParam(':search', $searchValue, PDO::PARAM_STR);
    $viewOrder->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
    $viewOrder->execute();
    $ordersData = $viewOrder->fetch(PDO::FETCH_ASSOC);

    // echo "<pre>";
    // print_r($ordersData);
    // echo "</pre>";

    if($ordersData){

        $order_id = $ordersData['order_id'];
        $viewProductQuery = "SELECT * FROM order_product JOIN products ON order_product.prod_id = products.product_id WHERE order_id = :order_id";
        $viewProduct = $connect->prepare($viewProductQuery);
        $viewProduct->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $viewProduct->execute();
        $productsData = $viewProduct->fetchAll(PDO::FETCH_ASSOC);

        // echo "<pre>";
        // print_r($productsData);
        // echo "</pre>";

        $viewUserQuery = "SELECT * FROM users LEFT JOIN user_address ON user_address.user_id = users.user_id LEFT JOIN creditcard ON creditcard.user_id = users.user_id LEFT JOIN countries ON users.country_id = countries.country_id LEFT JOIN cities ON users.city_id = cities.city_id WHERE users.user_id = :user_id";
        $viewUser = $connect->prepare($viewUserQuery);
        $viewUser->bindParam(':user_id', $ordersData['user_id'], PDO::PARAM_INT);
        $viewUser->execute();
        $userData = $viewUser->fetch(PDO::FETCH_ASSOC);

        $addressD = $userData['address'];
        $cityD = $userData['city_name'];
        $countryD = $userData['country_name'];
        $paymentMethodD = $ordersData['payment_method_id'];
        $orderDispatchStatus = $ordersData['dispatch_status'];
        $cardNumD = $userData['cardNumber'];

        // echo $orderDispatchStatus;

        // echo "<pre>";
        // print_r($userData);
        // echo "</pre>";

    }else{
    echo "<script>alert('No Order Found!')</script>";
    $isOrderFound = false;
    }
}







?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Track Order</title>
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
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--===============================================================================================-->
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:weight@100;200;300;400;500;600;700;800&display=swap");

    .search {
        position: relative;
        box-shadow: 0 0 40px rgba(51, 51, 51, .1);
    }

    .search input {
        height: 50px;
        text-indent: 25px;
        border: 2px solid #d6d4d4;
    }

    .search input:focus {
        box-shadow: none;
        border: 2px solid #696cff;
    }

    .search .fa-search {
        position: absolute;
        top: 20px;
        left: 16px;
    }

    .search button {
        position: absolute;
        top: 5px;
        right: 5px;
        height: 40px;
        width: 100px;
        background: black;
    }


    .progress-container {
        width: 80%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        flex-direction: row;
        /* Default is horizontal */
    }

    .track-progress-bar {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 10px;
        background: #ccc;
        z-index: 1;
    }

    .progress-bar-fill {
        height: 10px;
        background: #4CAF50;
        z-index: 2;
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
    }

    .progress-step {
        width: 60px;
        height: 60px;
        background: #ccc;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        position: relative;
        z-index: 3;
    }

    .progress-step.active {
        background: #4CAF50;
    }

    .step-label {
        position: absolute;
        top: 70px;
        font-size: 17px;
        font-weight: 700;
        text-align: center;
        width: max-content;
        left: 50%;
        transform: translateX(-50%);
    }

    .progress-wrapper {
        margin-top: 29px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 100%;
        height: auto;
        padding: 65px 0;
        background: #f2f2f2;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    .pro-h3 {
        text-align: center;
        font-size: 1.7rem;
        margin-bottom: 2.7rem;
    }

    .T-first {
        left: 4%;
    }

    .T-second {
        left: 50.6%;
    }

    .T-third {
        left: 97.5%;
    }

    .I-first {
        left: -5px;
    }

    .I-third {
        left: 5px;
    }

    .bar-fill-second {
        width: 49%;
    }

    .order-detail-container {
        width: 100%;
        margin-top: 20px;
        padding: 20px;
        background: #f2f2f2;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    .order-list {
        margin-top: 20px;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #ddd;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-info {
        display: flex;
        align-items: center;
    }

    .order-image {
        width: 70px;
        height: 70px;
        margin-right: 15px;
    }

    .order-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-details {
        max-width: 400px;
    }

    .order-details p {
        margin: 0;
        font-size: 14px;
        color: #566a7f;
    }

    .order-status {
        background-color: #f0f0f0;
        color: #555;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
    }

    /* Media Query for screen width 440px or less */
    @media (max-width: 440px) {
        .progress-container {
            flex-direction: column;
            height: 300px;
            /* Adjust height as needed */
            position: relative;
            align-items: baseline;
        }

        .track-progress-bar {
            width: 10px;
            height: 100%;
            left: 13%;
            top: 0;
            transform: translateX(-50%);
        }

        .progress-bar-fill {
            width: 10px;
            height: 100%;
            top: 0;
            left: 13%;
            transform: translateX(-50%);
        }

        .progress-step {
            width: 60px;
            height: 60px;
        }

        .step-label {
            position: absolute;
            left: 70px;
            top: 50%;
            transform: translateY(-50%);
        }

        .T-first {
            top: 9%;
            left: 33%;
        }

        .T-second {
            top: 49%;
            left: 33%;
        }

        .T-third {
            top: 90%;
            left: 33%;
        }

        .I-first {
            left: 0;
            top: -2px;
        }

        .I-third {
            left: 0;
            top: 2px;
        }

        .bar-fill-second {
            width: 10px;
        }
    }

    @media (max-width: 350px) {
        .track-progress-bar {
            left: 16%;
        }

        .progress-bar-fill {
            left: 16%;
        }

        .T-first,
        .T-second,
        .T-third {
            left: 41%;
        }

    }
    </style>
</head>

<body class="animsition">

    <!-- Header -->
    <?php require "partials/lightnavbar.php" ?>


    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Track Order
        </h2>
    </section>

    <?php if (isset($_SESSION['userId'])) {  ?>
    <!-- Content page -->
    <section class="bg0 p-t-75 p-b-120">
        <div class="container" style="width: 85%;">

            <div class="d-flex justify-content-center align-items-center">
                <div class="col-md-12">
                    <div class="search">
                        <form action="" Method="POST">
                            <i class="fa fa-search"></i>
                            <input type="Number" class="form-control" placeholder="Search your Order Id" name="search" id="orderSearch" oninput="validateOrderId(this)">
                            <button class="btn btn-primary" style="border-color: transparent;" type="submit" name="Btn">Search</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php if ($isOrderFound){?>


            <?php if (isset($ordersData)){?>

            <?php if ($orderDispatchStatus === 'pending') { ?>
            <!-- Div 1: In Processing -->
            <div class="progress-wrapper">
                <h3 class="pro-h3">We're processing your order</h3>
                <div class="progress-container">
                    <div class="track-progress-bar"></div>
                    <div class="progress-bar-fill" style="width: 0;"></div>
                    <div class="progress-step active I-first"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <div class="progress-step"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <div class="progress-step I-third"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <span class="step-label T-first">In Processing</span>
                    <span class="step-label T-second">Dispatched</span>
                    <span class="step-label T-third">Delivered</span>
                </div>
            </div>
            <?php } else if ($orderDispatchStatus === 'dispatched') { ?>
            <!-- Div 2: On Its Way -->
            <div class="progress-wrapper">
                <h3 class="pro-h3">Your order is on its way</h3>
                <div class="progress-container">
                    <div class="track-progress-bar"></div>
                    <div class="progress-bar-fill bar-fill-second"></div>
                    <div class="progress-step active I-first"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <div class="progress-step active"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <div class="progress-step I-third"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <span class="step-label T-first">In Processing</span>
                    <span class="step-label T-second">Dispatched</span>
                    <span class="step-label T-third">Delivered</span>
                </div>
            </div>
            <?php } else if ($orderDispatchStatus === 'delivered') { ?>
            <!-- Div 3: Delivered -->
            <div class="progress-wrapper">
                <h3 class="pro-h3">Your order is delivered</h3>
                <div class="progress-container">
                    <div class="track-progress-bar"></div>
                    <div class="progress-bar-fill"></div>
                    <div class="progress-step active I-first"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <div class="progress-step active"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <div class="progress-step active I-third"><i class="fa-solid fa-check fa-2xl"></i></div>
                    <span class="step-label T-first">In Processing</span>
                    <span class="step-label T-second">Dispatched</span>
                    <span class="step-label T-third">Delivered</span>
                </div>
            </div>
            <?php } ?>


            <div class="order-detail-container">
                <div class="row">
                    <div class="column">
                        <h2>Order Summary</h2>
                        <ul>
                            <li><strong>Order ID:</strong> <?= $ordersData['order_id'] ?> </li>
                            <li><strong>Order Date:</strong> <?= $ordersData['order_date'] ?> </li>
                            <?php if ($paymentMethodD == '1') { ?>
                            <li><strong>Payment Method:</strong> Cash On Delivery</li>
                            <?php } else if ($paymentMethodD == '2') { ?>
                            <li><strong>Payment Method:</strong> PayPal</li>
                            <li><strong>Card Number:</strong> <?= $cardNumD ?></li>
                            <?php } ?>
                            <li><strong>Phone Number:</strong><?= $userData['phone_number']?></li>
                            <li><strong>Address:</strong>
                                <?= htmlspecialchars($addressD . ', ' . $cityD . ', ' . $countryD) ?> </li>
                            <li><strong>Total Products:</strong><?= count($productsData) ?></li>
                            <li><strong>Total Price:</strong> <?= $ordersData['total_amount'] ?></li>
                        </ul>
                    </div>
                </div>
            </div>


            <div class="order-detail-container">
                <div class="row">
                    <div class="column">
                        <h2>Order Products</h2>
                        <?php foreach ($productsData as $prodData) { ?>
                        <div class="order-item">
                            <div class="order-info">
                                <div class="order-image">
                                    <img src="../adminPanel/html/images/<?= explode(",", $prodData['product_images'])[0] ?>"
                                        alt="Product Image">
                                </div>
                                <div class="order-details">
                                    <p><strong><?= htmlspecialchars($prodData['product_name']) ?></strong></p>
                                    <p>$ <?= htmlspecialchars($prodData['product_price']) ?> ×
                                        <?= htmlspecialchars($prodData['quantity']) ?> = <strong>
                                            <?= $prodData['quantity'] * $prodData['product_price'] ?></strong></p>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                </div>
            </div>
            <?php }}?>
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
                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center">Login>>
            </a>
        </div>
    </div>
    <?php } ?>

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
    $(".js-select2").each(function() {
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
    $('.js-pscroll').each(function() {
        $(this).css('position', 'relative');
        $(this).css('overflow', 'hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function() {
            ps.update();
        })
    });
    </script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
    <!--===============================================================================================-->
    <script>
function validateOrderId(input) {
    let value = input.value;

    // Convert value to a string to check length
    let length = value.length;

    // If value length is less than 16 or greater than 16, trim it
    if (length < 16) {
        input.setCustomValidity("Order ID must be at least 16 digits.");
    } else if (length >= 16) {
        input.value = value.slice(0, 16); // Trim to 16 digits
        input.setCustomValidity(""); // Clear error
    } else {
        input.setCustomValidity(""); // Clear error
    }
}
</script>
</body>

</html>