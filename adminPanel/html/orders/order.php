<?php
require "../connection/connection.php";

// Start the admin session
session_name('adminPanel');
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['apUserId'])) {
    header("location:../auth-login-basic.php");
    exit();
}

// Fetch all orders (no user_id filter)
$viewOrderQuery = "SELECT * FROM orders 
                   JOIN order_product ON orders.order_id = order_product.order_id 
                   JOIN products ON order_product.prod_id = products.product_id";
$viewOrder = $connect->prepare($viewOrderQuery);
$viewOrder->execute();
$ordersData = $viewOrder->fetchAll(PDO::FETCH_ASSOC);

// Fetch all deleted orders (no user_id filter)
$viewDeleteOrderQuery = "SELECT * FROM orders 
                         JOIN delete_order ON orders.order_id = delete_order.order_id 
                         JOIN products ON delete_order.prod_id = products.product_id";
$viewDeleteOrder = $connect->prepare($viewDeleteOrderQuery);
$viewDeleteOrder->execute();
$deleteOrderData = $viewDeleteOrder->fetchAll(PDO::FETCH_ASSOC);

// Merge orders and deleted orders
$allOrder = array_merge($deleteOrderData, $ordersData);
shuffle($allOrder);

// Fetch all reviews (no user_id filter)
$viewReviewProdQuery = "SELECT * FROM `reviews` 
                        JOIN `products` ON products.product_id = reviews.product_id";
$viewReviewProd = $connect->prepare($viewReviewProdQuery);
$viewReviewProd->execute();
$viewReviewProdData = $viewReviewProd->fetchAll(PDO::FETCH_ASSOC);
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

    <title>View Order</title>

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

    <style>
        .status-form {
    display: inline-block;
    margin-left: 10px;
}

.status-button {
    padding: 5px 10px;
    margin: 2px;
    border: 1px solid #ccc;
    background-color: #717fe0;
    color: white;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
}

.status-button:hover {
    background-color: #5a6abf;
}
.orders-container {
    width: 92%;
    margin: auto;
    background-color: #fff;
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

          <?php require '../partials/navbaar.php'  ?>


          <!-- / Navbar -->

          <!-- Content wrapper -->
          <!-- <div class="content-wrapper"> -->
            <!-- Content -->

            <!-- <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-md-12">

                  <div class="card mb-4">
                    <h5 class="card-header">Product Details</h5> -->
                    <!-- Account -->
                    
                    <!-- <hr class="my-0" /> -->
    <h5 class="card-header">View Orders</h5>


    <?php 
        if(!isset($_SESSION['userid'])){
    ?>

    <section class="bg0 p-t-35 p-b-35">
        <div class="conatiner">
        <div class="orders-container">
    <div class="tabs d-flex flex-wrap">
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
                        $productImage = "../images/" . explode(",", $order['product_images'])[0];
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
                        <p>$ <?= $order['product_price'] ?> × <?= $order['quantity'] ?> = <?= $order['quantity'] * $order['product_price'] ?></p>
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

<span><?= ucfirst($order['dispatch_status']) ?></span>
<!-- Dynamic Button -->
<?php if ($order['dispatch_status'] == 'pending'): ?>
    <!-- Show "Dispatch" Button for Pending Orders -->
    <form action="update_status.php" method="POST" class="status-form">
        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
        <input type="hidden" name="status" value="dispatched">
        <button type="submit" class="status-button">Dispatch</button>
    </form>
<?php elseif ($order['dispatch_status'] == 'dispatched'): ?>
    <!-- Show "Delivered" Button for Dispatched Orders -->
    <form action="update_status.php" method="POST" class="status-form">
        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
        <input type="hidden" name="status" value="delivered">
        <button type="submit" class="status-button">Delivered</button>
    </form>
<?php elseif ($order['dispatch_status'] == 'canceled'): ?>
    <!-- No Button for Canceled Orders -->
    <span>Canceled</span>
<?php endif; ?>
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
                            $productImage = "../images/" . explode(",", $order['product_images'])[0];
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
                            <p>$ <?= $order['product_price'] ?> × <?= $order['quantity'] ?> = <?= $order['quantity'] * $order['product_price'] ?></p>
                            <p>Order Date: <?= $order['order_date'] ?></p>
                        </div>
                    </div>
                </div>
        <?php } } ?>
    </div>

    <!-- To Pay -->
    <div id="to-pay" class="order-list" style="display: none;">
        <?php foreach ($ordersData as $order) { 
            if ($order['payment_status'] === 'paid') { ?>
                <div class="order-item">
                    <div class="order-info">

                        <a href="delete_order.php?id=<?= $order['prod_id'] ?>">
                            <div class="header-cart-item-img order-image">
                                <img src="../images/<?= explode(",", $order['product_images'])[0] ?>" alt="IMG">
                            </div>
                        </a>

                        <div class="order-details">
                            <p><strong>Order ID: <?= $order['order_id'] ?></strong></p>
                            <p><?= $order['product_name'] ?></p>
                            <p>$ <?= $order['product_price'] ?> × <?= $order['quantity'] ?> = <?= $order['quantity'] * $order['product_price'] ?></p>
                            <p>Order Date: <?= $order['order_date'] ?></p>
                            <p>Payment Status: <?= $order['payment_status'] ?> </p>
                        </div>
                    </div>
                </div>
        <?php } } ?>
    </div>

    <!-- To Receive -->
    <div id="to-receive" class="order-list" style="display: none;">
        <?php foreach ($ordersData as $order) { 
            if ($order['dispatch_status'] == 'delivered') { ?>
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-image">
                            <img src="../images/<?= explode(",", $order['product_images'])[0] ?>" alt="Product Image">
                        </div>
                        <div class="order-details">
                            <p><strong>Order ID: <?= $order['order_id'] ?></strong></p>
                            <p><?= $order['product_name'] ?></p>
                            <p>$ <?= $order['product_price'] ?> × <?= $order['quantity'] ?> = <?= $order['quantity'] * $order['product_price'] ?></p>
                            <p>Order Date: <?= $order['order_date'] ?></p>
                        </div>
                    </div>
                </div>
        <?php } } ?>
    </div>

    <!-- Cancelled -->
    <div id="Cancelled" class="order-list" style="display: none;">
        <?php foreach ($deleteOrderData as $deleteOrder) { ?>
                <div class="order-item">
                    <div class="order-info">
                        <div class="order-image">
                            <img src="../images/<?= explode(",", $deleteOrder['product_images'])[0] ?>" alt="Product Image">
                        </div>
                        <div class="order-details">
                            <p><strong>Order ID: <?= $deleteOrder['order_id'] ?></strong></p>
                            <p><?= $deleteOrder['product_name'] ?></p>
                            <p>$ <?= $deleteOrder['product_price'] ?> × <?= $deleteOrder['quantity'] ?> = <?= $deleteOrder['quantity'] * $deleteOrder['product_price'] ?></p>
                            <p>Order Date: <?= $deleteOrder['order_date'] ?></p>
                        </div>
                    </div>
                </div>
        <?php } ?>
    </div>

    <!-- To Review -->
    <div id="to-review" class="order-list" style="display: none;">
        <?php foreach ($viewReviewProdData as $ReviewProdData) { ?>
                    <div class="order-item">
                        <div class="order-info">
                            <div class="order-image">
                                <img src="../images/<?= explode(",", $ReviewProdData['product_images'])[0] ?>" alt="Product Image">
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <?php }  ?>
        
        
        
        
        
    <!-- </div> -->
     <!-- <br> -->
    <?php require "../partials/footer.php" ?>
</div>
</div>
</div>




<!-- Footer -->


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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusForms = document.querySelectorAll('.status-form');

    statusForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form submission

            const formData = new FormData(form);

            fetch('update_status.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Optional: Handle success message
                // Reload the page to reflect the updated status
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
  </body>
</html>
