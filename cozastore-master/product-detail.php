<?php require "connection/connection.php"; ?>

<?php
// function getCleanURL() {
//     $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
//     $domain = $_SERVER['HTTP_HOST'];
//     $path = strtok($_SERVER['REQUEST_URI'], '?'); // Remove Query
//     return filter_var($protocol . "://" . $domain . $path, FILTER_SANITIZE_URL);
// }

?>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        let cleanURL = "<?php //echo getCleanURL(); ?>";

        // Agar URL already clean nahi hai to replace karo
        if (window.location.href !== cleanURL) {
            window.history.replaceState({}, document.title, cleanURL);
        }
    });
</script> -->


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Detail</title>
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

    .related-products {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: space-around;
    }

    .related-products .item-slick2 {
        flex: 1 1 calc(25% - 15px);
        /* 4 items per row */
        max-width: calc(25% - 15px);
        box-sizing: border-box;
    }
    </style>
</head>


<?php
session_start();

$product_id = intval($_GET['id']);
$currentUser = $_SESSION['userId'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Btn'])) {
    try {
        // Validate product ID
        if ($product_id <= 0) {
            throw new Exception("Invalid product ID.");
        }

        // Check if user is logged in
        if (!$currentUser) {
            header('Location: pages/login.php');
            exit("Please log in to add products to your cart.");
        }

        // Fetch product stock
        $stockQuery = "SELECT stock_quantity FROM products WHERE product_id = :product_id";
        $stockStmt = $connect->prepare($stockQuery);
        $stockStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stockStmt->execute();
        $stock = $stockStmt->fetch(PDO::FETCH_ASSOC);

        if (!$stock) {
            throw new Exception("Product not found.");
        }

        $stockQuantity = $stock['stock_quantity'];
        $quantityToAdd = intval($_POST['quantity'] ?? 1);

        // Validate requested quantity
        if ($quantityToAdd <= 0 || $quantityToAdd > $stockQuantity) {
            throw new Exception("Invalid quantity. Please select a valid quantity within available stock.");
        }

        // Check if product is already in the cart
        $cartQuery = "SELECT quantity FROM `carts` WHERE prod_id = :product_id AND user_id = :user_id";
        $cartStmt = $connect->prepare($cartQuery);
        $cartStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $cartStmt->bindParam(':user_id', $currentUser, PDO::PARAM_INT);
        $cartStmt->execute();
        $cartItem = $cartStmt->fetch(PDO::FETCH_ASSOC);

        if ($cartItem) {
            // Update quantity in the cart
            $newQuantity = $cartItem['quantity'] + $quantityToAdd;
            if ($newQuantity > $stockQuantity) {
                throw new Exception("Requested quantity exceeds available stock.");
            }

            $updateQuery = "UPDATE `carts` SET quantity = :new_quantity WHERE prod_id = :product_id AND user_id = :user_id";
            $updateStmt = $connect->prepare($updateQuery);
            $updateStmt->bindParam(':new_quantity', $newQuantity, PDO::PARAM_INT);
            $updateStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $updateStmt->bindParam(':user_id', $currentUser, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                echo "<script>alert('Product quantity updated successfully!')</script>";
            } else {
                throw new Exception("Failed to update product quantity in the cart.");
            }
        } else {
            // Insert new product into the cart
            $insertQuery = "INSERT INTO `carts` (prod_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)";
            $insertStmt = $connect->prepare($insertQuery);
            $insertStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $insertStmt->bindParam(':quantity', $quantityToAdd, PDO::PARAM_INT);
            $insertStmt->bindParam(':user_id', $currentUser, PDO::PARAM_INT);

            if ($insertStmt->execute()) {
                echo "<script>alert('Product added to cart successfully!')</script>";
            } else {
                throw new Exception("Failed to add product to the cart.");
            }
        }
    } catch (Exception $e) {
        echo "<script>alert('Error: {$e->getMessage()}')</script>";
    }
}

// Fetch related products
$currentProductId = $product_id;
$relatedProductsQuery = "SELECT * FROM products WHERE category_id = 
    (SELECT category_id FROM products WHERE product_id = :currentProductId) 
    AND product_id != :currentProductId LIMIT 4";
$relatedProductsStmt = $connect->prepare($relatedProductsQuery);
$relatedProductsStmt->bindParam(':currentProductId', $currentProductId, PDO::PARAM_INT);
$relatedProductsStmt->execute();
$relatedProducts = $relatedProductsStmt->fetchAll(PDO::FETCH_ASSOC);
?>















<body class="animsition">

    <!-- Header -->
    <?php require "partials/lightnavbar.php" ?>





    <?php
    // <!-- fetching all products sizes -->
	$product_id = $_GET['id']; // Replace with the actual product ID

	$sizeViewQuery = "SELECT s.size_id, s.size_name, ps.id AS product_size_id, ps.product_id FROM sizes s JOIN product_sizes ps ON s.size_id = ps.size_id WHERE ps.product_id = :product_id";
	$sizeViewPrepare = $connect->prepare($sizeViewQuery);
	$sizeViewPrepare->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$sizeViewPrepare->execute();
	$sizeData = $sizeViewPrepare->fetchAll(PDO::FETCH_ASSOC);
	


    // <!-- fetching all products colors -->
	
	$colorViewQuery = "SELECT c.color_id, c.color_name, pc.id AS product_color_id, pc.product_id FROM colors c JOIN product_colors pc ON c.color_id = pc.color_id WHERE pc.product_id = :product_id";
	$colorViewPrepare = $connect->prepare($colorViewQuery);
	$colorViewPrepare->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$colorViewPrepare->execute();
	$colorData = $colorViewPrepare->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	// <!-- fetching specific products data -->
	$prodId = $_GET['id'];
	$productViewQuery = "SELECT * FROM `products` JOIN categories ON products.category_id = categories.category_id  WHERE product_id= :id";
	$productViewPrepare = $connect->prepare($productViewQuery);
	$productViewPrepare->bindParam(':id', $prodId,PDO::PARAM_INT);
	$productViewPrepare->execute();
	$productsData = $productViewPrepare->fetch(PDO::FETCH_ASSOC);



	
	
	// review


	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Rbtn'])) {
		if (!isset($_SESSION['userId'])) {
			echo "<script>alert('You must be logged in to leave a review.');</script>";
		} else {
			$R_userId = $_SESSION['userId'];
			$R_productId = filter_input(INPUT_POST, 'productIdR', FILTER_VALIDATE_INT);
			$R_rating = filter_input(INPUT_POST, 'ratingR', FILTER_VALIDATE_INT);
			$R_review = trim($_POST['reviewR']);
			$R_name = trim($_POST['nameR']);
			$R_email = filter_input(INPUT_POST, 'emailR', FILTER_VALIDATE_EMAIL);
	
			// Validate Input Fields
			if (!$R_productId || !$R_rating || !$R_review || !$R_name || !$R_email) {
				echo "<script>alert('All fields are required and must be valid.');</script>";
			} else {
                if (!preg_match("/^[A-Za-z ]+$/", $R_name)) {
                    echo "<script>alert('Error: Name should only contain alphabets!');</script>";
                } else {
                    // Check if the user has placed any order
                    $checkOrderQuery = "SELECT * FROM `orders` JOIN `order_product` ON orders.user_id = order_product.user_id WHERE orders.user_id = :R_userId AND order_product.prod_id = :R_productId LIMIT 1;";
                    $checkOrderStmt = $connect->prepare($checkOrderQuery);
                    $checkOrderStmt->bindParam(':R_userId', $R_userId, PDO::PARAM_INT);
                    $checkOrderStmt->bindParam(':R_productId', $R_productId, PDO::PARAM_INT);
                    $checkOrderStmt->execute();
                    $checkOrderData = $checkOrderStmt->fetch(PDO::FETCH_ASSOC);

                    if (!$checkOrderData) {
                        echo "<script>alert('You can only review products you have purchased.');</script>";
                    } else {
                        // Check if the user has already reviewed this product
                        $checkReviewQuery = "SELECT * FROM `reviews` WHERE user_id = :R_userId AND product_id = :R_productId LIMIT 1";
                        $checkReviewStmt = $connect->prepare($checkReviewQuery);
                        $checkReviewStmt->execute(['R_userId' => $R_userId, 'R_productId' => $R_productId]);
        
                        if ($checkReviewStmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<script>alert('You have already reviewed this product.');</script>";
                        } else {
                            // Insert review into the database
                            $insertReviewQuery = "INSERT INTO `reviews` (`user_id`, `Review`, `Rating`, `Name`, `Email`, `product_id`) VALUES (:R_userId, :R_review, :R_rating, :R_name, :R_email, :R_productId)";
                            $insertReviewStmt = $connect->prepare($insertReviewQuery);
        
                            if ($insertReviewStmt->execute([
                                'R_userId' => $R_userId,
                                'R_productId' => $R_productId,
                                'R_rating' => $R_rating,
                                'R_review' => $R_review,
                                'R_name' => $R_name,
                                'R_email' => $R_email
                            ])) {
                                echo "<script>alert('Review submitted successfully!')</script>";
                            } else {
                                echo "<script>alert('Error submitting review. Please try again later.');</script>";
                            }
                        }
                    }
                }
			}
		}
	}
	

	$currentUser = $_SESSION['userId'] ?? null;
	$userData = ['first_name' => '', 'last_name' => '', 'user_email' => ''];
	if ($currentUser) {
		$viewUserQuery = "SELECT first_name, last_name, user_email FROM `users` WHERE user_id = :user_id";
		$viewUserStmt = $connect->prepare($viewUserQuery);
		$viewUserStmt->execute(['user_id' => $currentUser]);
		$userData = $viewUserStmt->fetch(PDO::FETCH_ASSOC) ?? $userData;
	}
	$userDataName = trim($userData['first_name'] . ' ' . $userData['last_name']);





	// Fetch product reviews
	$reviewQuery = "SELECT * FROM `reviews` WHERE product_id = :product_id LIMIT 3";
	$reviewStmt = $connect->prepare($reviewQuery);
	$reviewStmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$reviewStmt->execute();
	$reviewsData = $reviewStmt->fetchAll(PDO::FETCH_ASSOC);




	?>



    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.php" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="product.php" class="stext-109 cl8 hov-cl1 trans-04">
                <?= $productsData['category_name'] ?>
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                <?= $productsData['product_name'] ?>
            </span>
        </div>
    </div>




    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                <?php
									$thumImagesArray = explode(",", $productsData['product_images']);
									foreach ($thumImagesArray as $image) {
									?>
                                <div class="item-slick3" data-thumb="../adminPanel/html/images/<?= $image ?>">
                                    <div class="wrap-pic-w pos-relative">
                                        <img style="aspect-ratio: 3 / 3.7" src="../adminPanel/html/images/<?=$image?>"
                                            style="aspect-ratio: 0.95/1;" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="../adminPanel/html/images/<?= $image ?>">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            <?= $productsData['product_name'] ?>
                        </h4>

                        <span class="mtext-106 cl2">
                            $<?= $productsData['product_price'] ?>
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            <?= $productsData['category_name'] ?>
                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            <form method="post" enctype="multipart/form-data">

                                <?php if(!empty($sizeData)){ ?>

                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6">
                                        Size
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select class="js-select2" name="time">
                                                <option>Choose an option</option>
                                                <?php foreach ($sizeData as $sizes) { ?>
                                                <option value="<?=$sizes['size_id']?>"><?=$sizes['size_name']?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>

                                <?php } ?>


                                <?php if(!empty($colorData)){ ?>


                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6">
                                        Color
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select class="js-select2" name="time">
                                                <option>Choose an option</option>
                                                <?php foreach ($colorData as $colors) { ?>
                                                <option value="<?=$colors['color_id']?>"><?=$colors['color_name']?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <button type="button" class="qty-btn" onclick="updateQuantity(-1, this)">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </button>

                                            <input type="number" class="mtext-104 cl3 txt-center num-product quantity"
                                                name="quantity" id="modal-product-quantity" value="1" min="1"
                                                max="<?= htmlspecialchars($stockQuantity) ?>"
                                                data-stock="<?= htmlspecialchars($stockQuantity) ?>">
                                            <button type="button" class="qty-btn" onclick="updateQuantity(1, this)">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </button>
                                        </div>

                                        <button name="Btn" type="submit"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            Add to cart
                                        </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!--  -->
                <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                    <!-- <div class="flex-m bor9 p-r-10 m-r-11">
								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
									<i class="zmdi zmdi-favorite"></i>
								</a>
							</div> -->

                    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                        data-tooltip="Facebook">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                        data-tooltip="Twitter">
                        <i class="fa fa-twitter"></i>
                    </a>

                    <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                        data-tooltip="Google Plus">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        </div>

        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <!-- Tab01 -->
            <div class="tab01">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                    </li>

                    <!--<li class="nav-item p-b-10">
							<a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
						</li> -->

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-t-43">
                    <!-- - -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                <?= $productsData['product_description'] ?>
                            </p>
                        </div>
                    </div>

                    <!-- review -->

                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">
                                    <!-- Review -->

									<?php foreach ($reviewsData as $reviewD) { ?>

                                    <div class="flex-w flex-t p-b-68">
                                        <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                            <img src="images/male-avatar-boy-face-man-user-9.svg" alt="AVATAR">
                                        </div>

                                        <div class="size-207">
                                            <div class="flex-w flex-sb-m p-b-17">
                                                <span class="mtext-107 cl2 p-r-20">
                                                    <?= $reviewD['Name'] ?>
                                                </span>

                                                <span class="fs-18 cl11">
													<?php
														for ($i = 0; $i < 5; $i++) {
															if ($i < $reviewD['Rating']) {
																echo '<i class="zmdi zmdi-star"></i>'; // Filled star
															} else {
																echo '<i class="zmdi zmdi-star-outline"></i>'; // Empty star
															}
														}
													?>
                                                </span>
                                            </div>

                                            <p class="stext-102 cl6">
                                                <?= $reviewD['Review'] ?>
                                            </p>
                                        </div>
                                    </div>
									<?php } ?>

                                    <form class="w-full" method="POST">
                                        <h5 class="mtext-108 cl2 p-b-7">Add a review</h5>
                                        <p class="stext-102 cl6">Your email address will not be published. Required
                                            fields are marked *</p>
                                        <input type="hidden" name="productIdR" value="<?= $_GET['id'] ?? '' ?>">

                                        <div class="flex-w flex-m p-t-50 p-b-23">
                                            <span class="stext-102 cl3 m-r-16">Your Rating</span>
                                            <span class="wrap-rating fs-18 cl11 pointer" id="rating-stars">
                                                <?php for ($i = 1; $i <= 5; $i++) echo "<i data-value='$i' class='item-rating pointer zmdi zmdi-star-outline'></i>"; ?>
                                                <input type="hidden" name="ratingR" id="ratingR" required>
                                            </span>
                                        </div>

                                        <div class="row p-b-25">
                                            <div class="col-sm-12 p-b-5">
                                                <label class="stext-102 cl3" for="name">Name</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text"
                                                    name="nameR" value="<?= htmlspecialchars($userDataName) ?>"
                                                    required>
                                            </div>
                                            <div class="col-12 p-b-5">
                                                <label class="stext-102 cl3" for="review">Your review</label>
                                                <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10"
                                                    id="review" name="reviewR" required></textarea>
                                            </div>
                                            <div class="col-sm-6 p-b-5" style="display: none;">
                                                <label class="stext-102 cl3" for="email">Email</label>
                                                <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
                                                    type="text" name="emailR"
                                                    value="<?= htmlspecialchars($userData['user_email']) ?>">
                                            </div>
                                        </div>
                                        <button type="submit"
                                            class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10"
                                            name="Rbtn">Submit</button>
                                    </form>

                                    <script>
                                    document.querySelectorAll(".item-rating").forEach(star => {
                                        star.addEventListener("click", function() {
                                            let rating = this.getAttribute("data-value");
                                            document.getElementById("ratingR").value = rating;
                                            document.querySelectorAll(".item-rating").forEach(s => s
                                                .classList.replace("zmdi-star", "zmdi-star-outline")
                                                );
                                            for (let i = 0; i < rating; i++) document.querySelectorAll(
                                                ".item-rating")[i].classList.replace(
                                                "zmdi-star-outline", "zmdi-star");
                                        });
                                    });

                                    function validateReviewForm() {
                                        if (!document.getElementById("ratingR").value) {
                                            alert("Please select a rating before submitting!");
                                            return false;
                                        }
                                        return true;
                                    }
                                    </script>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">


            <span class="stext-107 cl6 p-lr-25">
                Categories: <?= $productsData['category_name'] ?>
            </span>
        </div>
    </section>


    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>

            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">

                    <!-- <div class="related-products"> -->
                    <?php foreach ($relatedProducts as $product){ ?>
                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img style="aspect-ratio: 3 / 3.7" src="../adminPanel/html/images/<?= explode(",", $product['product_images'])[0] ?>"
                                    alt="IMG-PRODUCT">

                                <a href="product-detail.php?id=<?= $product['product_id'] ?>"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    View
                                </a>
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="product-detail.php?id=<?= $product['product_id'] ?>"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        <?= htmlspecialchars($product['product_name']) ?>
                                    </a>

                                    <span class="stext-105 cl3">
                                        $<?= number_format($product['product_price'], 2) ?>
                                    </span>
                                </div>

                                <!-- <div class="block2-txt-child2 flex-r p-t-3">
										<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
											<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON">
											<img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON">
										</a>
									</div> -->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- </div> -->

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

    <!-- Modal1 -->


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
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/slick/slick.min.js"></script>
    <script src="js/slick-custom.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/parallax100/parallax100.js"></script>
    <script>
    $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <script>
    $('.gallery-lb').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true
            },
            mainClass: 'mfp-fade'
        });
    });
    </script>
    <!--===============================================================================================-->
    <script src="vendor/isotope/isotope.pkgd.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script>
    $('.js-addwish-b2, .js-addwish-detail').on('click', function(e) {
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function() {
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function() {
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/

    $('.js-addcart-detail').each(function() {
        var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
        $(this).on('click', function() {
            swal(nameProduct, "is added to cart !", "success");
        });
    });
    </script>
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
    <script>
    $(document).on('click', '.js-addwish-b2', function(e) {
        e.preventDefault();
        let productId = $(this).data('product-id'); // Get the product ID from data attribute
        let $icon = $(this); // Reference to the clicked icon

        $.ajax({
            url: 'wishlist-handler.php', // The PHP script that handles the request
            type: 'POST',
            data: {
                product_id: productId
            },
            success: function(response) {
                // Assuming `response` contains JSON with success message
                let result = JSON.parse(response);
                if (result.success) {
                    alert('Product added to wishlist!');
                    $icon.find('.icon-heart1').hide(); // Hide unfilled heart
                    $icon.find('.icon-heart2').show(); // Show filled heart
                } else {
                    alert('Failed to add to wishlist: ' + result.message);
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
            }
        });
    });
    </script>
    <script src="js/main.js"></script>






    <!-- qty work -->
    <script>
    function updateQuantity(change, button) {
        const qtyInput = button.parentElement.querySelector('.quantity');
        let currentQty = parseInt(qtyInput.value, 10) || 1;
        const stockQty = parseInt(qtyInput.getAttribute('data-stock'));
        console.log(stockQty);

        currentQty += change;

        if (currentQty < 1) {
            currentQty = 1;
        }

        if (currentQty > stockQty) {
            currentQty = stockQty;
            // displayMessage(`Maximum stock limit is ${stockQty}`, button.parentElement);
            alert(`Maximum stock limit is ${stockQty}`);
        }

        qtyInput.value = currentQty;
    }

    function displayMessage(msg, container) {
        let messageElem = container.querySelector('.stock-message');
        if (!messageElem) {
            messageElem = document.createElement('div');
            messageElem.className = 'stock-message';
            messageElem.style.color = 'red';
            messageElem.style.fontSize = '12px';
            container.appendChild(messageElem);
        }
        messageElem.textContent = msg;
        setTimeout(() => messageElem.remove(), 3000); // Clear message after 3 seconds
    }

    </script>



</body>

</html>