<?php
require "connection/connection.php"; 
session_start();


$viewOrderQuery = "SELECT * FROM orders JOIN order_product ON orders.order_id = order_product.order_id JOIN products ON order_product.prod_id = products.product_id WHERE orders.user_id = :user_id";
$viewOrder = $connect->prepare($viewOrderQuery);
$viewOrder->bindParam(':user_id', $_SESSION['userId'] , PDO::PARAM_INT);
$viewOrder->execute();
$ordersData = $viewOrder->fetchAll(PDO::FETCH_ASSOC);


// echo "orders";
// echo "<pre>";
// print_r($ordersData);
// echo "</pre>";

$viewDeleteOrderQuery = "SELECT * FROM orders JOIN delete_order ON orders.order_id = delete_order.order_id JOIN products ON delete_order.prod_id = products.product_id WHERE orders.user_id = :user_id";
$viewDeleteOrder = $connect->prepare($viewDeleteOrderQuery);
$viewDeleteOrder->bindParam(':user_id', $_SESSION['userId'] , PDO::PARAM_INT);
$viewDeleteOrder->execute();
$deleteOrderData = $viewDeleteOrder->fetchAll(PDO::FETCH_ASSOC);

// echo "delete order";
// echo "<pre>";
// print_r($deleteOrderData);
// echo "</pre>";


$allOrder = array_merge($deleteOrderData, $ordersData);
shuffle($allOrder);

usort($allOrder, function ($a, $b) {
    return strtotime($b['order_date']) - strtotime($a['order_date']);
});

// echo "<h3>Sorted Orders (Ascending)</h3>";
// echo "<pre>";
// print_r($allOrder);
// echo "</pre>";


$viewReviewProdQuery = "SELECT * FROM `reviews` JOIN `products` ON products.product_id = reviews.product_id WHERE user_id = :userId";
$viewReviewProd = $connect->prepare($viewReviewProdQuery);
$viewReviewProd->bindParam(':userId', $_SESSION['userId'] , PDO::PARAM_INT);
$viewReviewProd->execute();
$viewReviewProdData = $viewReviewProd->fetchAll(PDO::FETCH_ASSOC);

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
.orders-container {
    width: 92%;
    margin: auto;
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 2px solid #eee
}

.tabs {
    display: flex;
    border-bottom: 2px solid #ddd;
}

.tab {
    padding: 10px 20px;
    cursor: pointer;
    color: #555;
    border-bottom: 2px solid transparent;
}

.tab.active {
    color: #000;
    border-bottom: 2px solid #717fe0;
    font-weight: bold;
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
    width: 80px;
    height: 80px;
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
    color: #555;
}

.order-status {
    background-color: #f0f0f0;
    color: #555;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 14px;
}
</style>

<body class="animsition">

    <?php require "partials/lightnavbar.php" ?>

    <!-- Header -->


    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            My Orders
        </h2>
    </section>

    <?php 
        if (isset($_SESSION['userId'])) { 
            if (!count($allOrder) == 0 || !count($viewReviewProdData) == 0) { ?>


    <section class="bg0 p-t-35 p-b-35">
        <div class="conatiner">

            <div class="orders-container" style="margin-bottom: 1.5rem;">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 style="margin-bottom: 0;">Do you want to track your order now?</h4>
                    <a href="track-order.php"
                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 text-center" style = "width: fit-content;">Track Order</a>
                </div>
            </div>


            <div class="orders-container">
                <div class="tabs">
                    <div class="tab active" data-tab="all">All</div>
                    <div class="tab" data-tab="inProcess">In Process</div>
                    <div class="tab" data-tab="to-pay">To Pay</div>
                    <div class="tab" data-tab="to-receive">To Receive</div>
                    <div class="tab" data-tab="Cancelled">Cancelled</div>
                    <div class="tab" data-tab="to-review">To Review</div>
                </div>

                <!-- All Orders -->
                <div id="all" class="order-list">
                    <?php foreach ($allOrder as $order) { ?>
                    <div class="order-item">
                        <div class="order-info">
                            <?php 
                            // Check if the order is in process
                            $isInProcess = (
                                $order['dispatch_status'] == 'pending'
                            );
                            $isOrdercompleted = (
                                $order['dispatch_status'] == 'delivered'|| $order['dispatch_status'] == 'dispatched'
                            );
                            $isInProcessConf = (
                                $order['payment_status'] == 'pending' || $order['payment_status'] == 'paid' 
                            );

                            // Image source
                            $productImage = "../adminPanel/html/images/" . explode(",", $order['product_images'])[0];
                            ?>

                            <?php if ($isInProcess){ 
                                if($isInProcessConf){    
                            ?>
                            <a href="delete_order.php?id=<?= $order['prod_id'] ?>">
                                <div class="header-cart-item-img order-image">
                                    <img src="<?= $productImage ?>" alt="IMG">
                                </div>
                            </a>
                            <?php }else{?>
                            <div class="order-image">
                                <img src="<?= $productImage ?>" alt="Product Image">
                            </div>
                            <?php }}else if($isOrdercompleted){ ?>
                            <div class="order-image">
                                <img src="<?= $productImage ?>" alt="Product Image">
                            </div>
                            <?php } ?>

                            <div class="order-details">
                                <p><strong>Order ID: <?= $order['order_id'] ?></strong></p>
                                <p><?= $order['product_name'] ?></p>
                                <p>$ <?= $order['product_price'] ?> × <?= $order['quantity'] ?> =
                                    <?= $order['quantity'] * $order['product_price'] ?></p>
                                <p>Order Date: <?= $order['order_date'] ?></p>
                            </div>
                        </div>
                        <div class="order-status">

                            <?php 
                        $isInProcessConf = isset($order['delete_order_id']) ? $order['delete_order_id'] : false;

                        if($isInProcessConf){
                            echo "<span> Cancelled </span>";
                        }else{
                            if ($order['dispatch_status'] == 'delivered') {
                                // Second priority: Completed
                                echo "<span> Completed </span>";
                            }else if($order['dispatch_status'] == 'dispatched'){
                                echo "<span> Dispatched </span>";
                            } else if (
                                $order['payment_status'] == 'pending' || 
                                $order['payment_status'] == 'paid' || 
                                $order['dispatch_status'] == 'pending'                            
                            ) {
                                // Fallback: In Process
                                echo "<span> In Process </span>";
                            }
                        }
                    ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <!-- In Process -->
                <div id="inProcess" class="order-list" style="display: none;">
                    <?php foreach ($ordersData as $order) { 
                    if (in_array($order['dispatch_status'], ['pending', 'dispatched'])) { ?>
                    <div class="order-item">
                        <div class="order-info">

                            <?php 
                            // Check if the order is in process
                            $isInProcess = (
                                $order['dispatch_status'] == 'pending'
                            );
                            $isOrdercompleted = (
                                $order['dispatch_status'] == 'delivered'|| $order['dispatch_status'] == 'dispatched'
                            );
                            $isInProcessConf = (
                                $order['payment_status'] == 'pending' || $order['payment_status'] == 'paid' 
                            );

                            // Image source
                            $productImage = "../adminPanel/html/images/" . explode(",", $order['product_images'])[0];
                        ?>

                            <?php if ($isInProcess){ 
                            if($isInProcessConf){    
                        ?>
                            <a href="delete_order.php?id=<?= $order['prod_id'] ?>">
                                <div class="header-cart-item-img order-image">
                                    <img src="<?= $productImage ?>" alt="IMG">
                                </div>
                            </a>
                            <?php }else{?>
                            <div class="order-image">
                                <img src="<?= $productImage ?>" alt="Product Image">
                            </div>
                            <?php }}else if($isOrdercompleted){ ?>
                            <div class="order-image">
                                <img src="<?= $productImage ?>" alt="Product Image">
                            </div>
                            <?php } ?>


                            <div class="order-details">
                                <p><strong>Order ID: <?= $order['order_id'] ?></strong></p>
                                <p><?= $order['product_name'] ?></p>
                                <p>$ <?= $order['product_price'] ?> × <?= $order['quantity'] ?> =
                                    <?= $order['quantity'] * $order['product_price'] ?></p>
                                <p>Order Date: <?= $order['order_date'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>

                <!-- To Pay -->
                <div id="to-pay" class="order-list" style="display: none;">
                    <?php 
                    $paidOrders = array_filter($ordersData, function($order) {
                        return $order['payment_status'] === 'paid';
                    });

                    if (empty($paidOrders)) { ?>
                    <div class="alert alert-info">
                        <strong>You have not placed any orders yet.</strong>
                    </div>
                    <?php } else { 
                    foreach ($paidOrders as $order) { ?>
                    <div class="order-item">
                        <div class="order-info">

                            <a href="delete_order.php?id=<?= htmlspecialchars($order['prod_id']) ?>">
                                <div class="header-cart-item-img order-image">
                                    <img src="../adminPanel/html/images/<?= explode(",", $order['product_images'])[0] ?>"
                                        alt="IMG">
                                </div>
                            </a>

                            <div class="order-details">
                                <p><strong>Order ID: <?= htmlspecialchars($order['order_id']) ?></strong></p>
                                <p><?= htmlspecialchars($order['product_name']) ?></p>
                                <p>$ <?= htmlspecialchars($order['product_price']) ?> ×
                                    <?= htmlspecialchars($order['quantity']) ?> =
                                    <?= $order['quantity'] * $order['product_price'] ?></p>
                                <p>Order Date: <?= htmlspecialchars($order['order_date']) ?></p>
                                <p>Payment Status: <?= htmlspecialchars($order['payment_status']) ?> </p>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>


                <!-- To Receive -->
                <div id="to-receive" class="order-list" style="display: none;">
                    <?php 
                    $deliveredOrders = array_filter($ordersData, function($order) {
                        return $order['dispatch_status'] == 'delivered';
                    });

                    if (empty($deliveredOrders)) { ?>
                    <div class="alert alert-info">
                        <strong>You have not received any orders yet.</strong>
                    </div>
                    <?php } else { 
                    foreach ($deliveredOrders as $order) { ?>
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-image">
                                <img src="../adminPanel/html/images/<?= explode(",", $order['product_images'])[0] ?>"
                                    alt="Product Image">
                            </div>
                            <div class="order-details">
                                <p><strong>Order ID: <?= htmlspecialchars($order['order_id']) ?></strong></p>
                                <p><?= htmlspecialchars($order['product_name']) ?></p>
                                <p>$ <?= htmlspecialchars($order['product_price']) ?> ×
                                    <?= htmlspecialchars($order['quantity']) ?> =
                                    <?= $order['quantity'] * $order['product_price'] ?></p>
                                <p>Order Date: <?= htmlspecialchars($order['order_date']) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>


                <!-- Cancelled -->
                <div id="Cancelled" class="order-list" style="display: none;">
                    <?php if(empty($deleteOrderData)){ ?>
                    <div class="alert alert-info">
                        <strong>You have not cancelled any orders yet.</strong>
                    </div>
                    <?php }else{ ?>
                    <?php foreach ($deleteOrderData as $deleteOrder) { ?>
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-image">
                                <img src="../adminPanel/html/images/<?= explode(",", $deleteOrder['product_images'])[0] ?>"
                                    alt="Product Image">
                            </div>
                            <div class="order-details">
                                <p><strong>Order ID: <?= $deleteOrder['order_id'] ?></strong></p>
                                <p><?= $deleteOrder['product_name'] ?></p>
                                <p>$ <?= $deleteOrder['product_price'] ?> × <?= $deleteOrder['quantity'] ?> =
                                    <?= $deleteOrder['quantity'] * $deleteOrder['product_price'] ?></p>
                                <p>Order Date: <?= $deleteOrder['order_date'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php }} ?>
                </div>

                <!-- To Review -->
                <div id="to-review" class="order-list" style="display: none;">
                    <?php if(empty($viewReviewProdData)){ ?>
                    <div class="alert alert-info">
                        <strong>You have not reviewed any products yet.</strong>
                    </div>
                    <?php }else{ ?>
                    <?php foreach ($viewReviewProdData as $ReviewProdData) { ?>
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-image">
                                <img src="../adminPanel/html/images/<?= explode(",", $ReviewProdData['product_images'])[0] ?>"
                                    alt="Product Image">
                            </div>
                            <div class="order-details">
                                <p><?= $ReviewProdData['product_name'] ?></p>
                                <p>Review: <?= $ReviewProdData['Review'] ?></p>
                                <span class="fs-18 cl11">
                                    <?php
										for ($i = 0; $i < 5; $i++) {
											if ($i < $ReviewProdData['Rating']) {
												echo '<i class="zmdi zmdi-star"></i>'; // Filled star
											} else {
												echo '<i class="zmdi zmdi-star-outline"></i>'; // Empty star
											}
										}
									?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </section>

    <?php } else { ?>

    <div class="container" style="display: flex; align-items: center; justify-content: center; height: 35%;">
        <div class="text-container"
            style="display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 25px;">
            <div>
                <h4>You’re all set! Start exploring our products and place your first order today. Exciting deals await
                    you!</h4>
            </div>
            <a href="pages/login.php"
                class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail text-center">SHOPING
                >></a>
        </div>
    </div>



    <?php }} else { ?>
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




    <!-- Footer -->

    <?php require "partials/footer.php" ?>
    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!--===============================================================================================-->
    <!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
    <!--===============================================================================================-->
    <!-- <script src="vendor/animsition/js/animsition.min.js"></script> -->
    <!--===============================================================================================-->
    <!-- <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
    <!--===============================================================================================-->
    <!-- <script src="vendor/select2/select2.min.js"></script>
    <script>
    $(".js-select2").each(function() {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
    </script> -->
    <!--===============================================================================================-->
    <!-- <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script> -->
    <!--===============================================================================================-->
    <!-- <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
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
    </script> -->
    <!--===============================================================================================-->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script> -->
    <script src="js/map-custom.js"></script>
    <!--===============================================================================================-->
    <!-- <script src="js/main.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
    const tabs = document.querySelectorAll('.tab');
    const orderLists = document.querySelectorAll('.order-list');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            tabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            tab.classList.add('active');

            // Hide all order lists
            orderLists.forEach(list => (list.style.display = 'none'));

            // Show the relevant order list
            const activeTab = tab.getAttribute('data-tab');
            document.getElementById(activeTab).style.display = 'block';
        });
    });
    </script>

<!--===============================================================================================-->	
<!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
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


</body>

</html>