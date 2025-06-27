<?php require "connection/connection.php" ?>



<?php 
session_start();
	$viewCartQuery = "SELECT * FROM carts JOIN products ON carts.prod_id = products.product_id WHERE user_id = :user_id";
	// $viewCartQuery = "SELECT * FROM carts JOIN products ON carts.prod_id = products.product_id JOIN orderitems ON products.product_id = orderitems.product_id";
	$viewCartPrepare = $connect->prepare($viewCartQuery);
	$viewCartPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
	$viewCartPrepare->execute();  
	$viewCartData = $viewCartPrepare->fetchAll(PDO::FETCH_ASSOC);


    $subTotalQuery = 'SELECT ROUND(SUM(products.product_price * carts.quantity),2) as subTotal FROM `carts` JOIN products ON products.product_id = carts.prod_id WHERE user_id = :user_id';
    $subTotalPrepare = $connect->prepare($subTotalQuery);
	$subTotalPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
    $subTotalPrepare->execute();
    $subTotal = $subTotalPrepare->fetch(PDO::FETCH_ASSOC);
	// print_r($subTotal);

    $shipmentViewQuery = "SELECT * FROM shipment";
    $shipmentViewPrepare = $connect->prepare($shipmentViewQuery);
    $shipmentViewPrepare->execute();
    $shipmentData = $shipmentViewPrepare->fetchAll(PDO::FETCH_ASSOC);
	$shipmentPrice = $shipmentData[0]['Shipment_price'];
    // echo $shipmentPrice;
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shoping Cart</title>
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
    <style>
    .qty-btn {
        width: 45px;
        height: 100%;
        cursor: pointer;
        justify-content: center;
        -ms-align-items: center;
        align-items: center;
        transition: all 0.4s;
    }

    .size-209 {
        width: 50%;
        margin-left: 15px;
        margin-bottom: 3px;
    }

    .size-208 {
        width: fit-content;
        margin-bottom: 3px;
    }
    </style>
</head>

<body class="animsition">

    <!-- Header -->
    <?php require "partials/lightnavbar.php" ?>

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Shoping Cart
            </span>
        </div>
    </div>

    <?php 
        if (isset($_SESSION['userId'])) { ?>


    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart" id="cart-table">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Quantity</th>
                                    <th class="column-5">Total</th>
                                </tr>



                                <?php if (empty($viewCartData)) { ?>
                                <p>Your cart is empty</p>
                                <?php } else { ?>
                                <?php foreach ($viewCartData as $cartData) { ?>
                                <tr class="table_row" id="cart-row-<?= $cartData['cart_id'] ?>"
                                    data-cart-id="<?= $cartData['cart_id'] ?>"
                                    data-product-price="<?= $cartData['product_price'] ?>"
                                    data-max-stock="<?= $cartData['stock_quantity'] ?>"
                                    data-cart-id="<?= $cartData['cart_id'] ?>"
                                    data-product-price="<?= $cartData['product_price'] ?>">
                                    <td class="column-1">
                                        <a href="delete_qty_cart.php?id=<?= $cartData['cart_id'] ?>">
                                            <div class="how-itemcart1">
                                                <img name="cardCross"
                                                    src="../adminPanel/html/images/<?= explode(",", $cartData['product_images'])[0] ?>"
                                                    alt="IMG">
                                            </div>
                                        </a>
                                    </td>
                                    <td class="column-2"><?= mb_strimwidth($cartData['product_name'] , 0, 30, "...") ?></td>
                                    <td class="column-3">$ <?= $cartData['product_price'] ?></td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <button type="button" class="qty-btn"
                                                onclick="updateQuantity('decrease', <?= $cartData['cart_id'] ?>)">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </button>

                                            <input class="mtext-104 cl3 txt-center num-product qty"
                                                id="qty-<?= $cartData['cart_id'] ?>" type="number" name="qty"
                                                value="<?= $cartData['quantity']?>"
                                                onchange="updateTotal(<?= $cartData['cart_id'] ?>)">

                                            <button type="button" class="qty-btn"
                                                onclick="updateQuantity('increase', <?= $cartData['cart_id'] ?>)">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="column-5" id="total-<?= $cartData['cart_id'] ?>">$
                                        <?= $cartData['quantity'] * $cartData['product_price'] ?></td>

                                </tr>
                                <?php } ?>
                                <?php } ?>

                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>

                        <div class="flex-w flex-t bor12 p-b-13 flex-col">
                                <div class="size-208">
                                    <span class="stext-110 cl2"><strong>Subtotal: </strong></span>
                                    <span class="mtext-110 cl2 subtotal-value">$<?=$subTotal['subTotal'] ?? 0?></span>
                                </div>
                                <div class="size-208">
                                    <span class="stext-110 cl2"><strong style="width: 100%;">Shipment Price:</strong></span>
                                    <span class="mtext-110 cl2 shipment-value">$<?=$shipmentPrice?></span>
                                </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2"><strong>Total:</strong></span>
                            </div>
                            <div class="size-209 p-t-1">
                                <span
                                    class="mtext-110 cl2 total-value">$<?=$subTotal['subTotal'] + $shipmentPrice?></span>
                            </div>
                        </div>

                        <a href="check-out.php"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </form>


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
    function updateQuantity(action, cartId) {
        const qtyInput = document.getElementById(`qty-${cartId}`);
        const totalCell = document.getElementById(`total-${cartId}`);
        const productPrice = parseFloat(document.getElementById(`cart-row-${cartId}`).getAttribute(
            'data-product-price'));
        const maxStock = parseInt(document.getElementById(`cart-row-${cartId}`).getAttribute('data-max-stock'));
        // console.log(maxStock);

        let currentQty = parseInt(qtyInput.value);

        if (action === 'increase') {
            if (currentQty < maxStock) {
                currentQty++;
            } else {
                alert(`You can only add up to ${maxStock} of this product.`);
            }
        } else if (action === 'decrease' && currentQty > 1) {
            currentQty--;
        }

        qtyInput.value = currentQty;
        totalCell.textContent = `$ ${(currentQty * productPrice).toFixed(2)}`;
        sendUpdateToServer(cartId, currentQty);
    }

    function updateTotal(cartId) {
        const qtyInput = document.getElementById(`qty-${cartId}`);
        const totalCell = document.getElementById(`total-${cartId}`);
        const productPrice = parseFloat(document.getElementById(`cart-row-${cartId}`).getAttribute(
            'data-product-price'));
        const maxStock = parseInt(document.getElementById(`cart-row-${cartId}`).getAttribute('data-max-stock'));

        let currentQty = parseInt(qtyInput.value);

        if (currentQty > maxStock) {
            currentQty = maxStock;
            alert(`You can only add up to ${maxStock} of this product.`);
        } else if (currentQty < 1) {
            currentQty = 1;
        }

        qtyInput.value = currentQty;
        totalCell.textContent = `$ ${(currentQty * productPrice).toFixed(2)}`;
        sendUpdateToServer(cartId, currentQty);
    }

	document.addEventListener('DOMContentLoaded', function () {
		updateCartTotals();
	});

    function sendUpdateToServer(cartId, qty) {
        $.ajax({
            url: 'update_quantity_cart.php',
            type: 'POST',
            data: {
                cartId: cartId,
                qty: qty
            },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'error') {
                    alert(res.message);
                } else {
                    console.log('Updated Quantity:', res.message);
                }
            },
            error: function(error) {
                console.error('Error updating quantity:', error);
            }
        });
    }


	function sendUpdateToServer(cartId, qty) {
    $.ajax({
        url: 'update_quantity_cart.php',
        type: 'POST',
        data: { cartId: cartId, qty: qty },
        success: function(response) {
            const res = JSON.parse(response);
            if (res.status === 'success') {
                console.log('Updated Quantity:', res.message);
                // Refresh the cart totals
                updateCartTotals();
            } else {
                alert(res.message);
            }
        },
        error: function(error) {
            console.error('Error updating quantity:', error);
        }
    });
}



    function updateCartTotals() {
        $.ajax({
            url: 'update_cart_totals.php', // Path to the backend PHP file
            type: 'GET', // No data is sent since we're calculating based on session
            success: function(response) {
                const res = JSON.parse(response);

                if (res.status === 'success') {
                    // Update the totals in the DOM
                    document.querySelector('.subtotal-value').textContent = `$${res.subTotal.toFixed(2)}`;
                    document.querySelector('.shipment-value').textContent =
                        `$${res.shipmentPrice.toFixed(2)}`;
                    document.querySelector('.total-value').textContent = `$${res.total.toFixed(2)}`;
                } else {
                    console.error('Error updating cart totals:', res.message);
                }
            },
            error: function(error) {
                console.error('AJAX error:', error);
            }
        });
    }
    </script>





</body>

</html>