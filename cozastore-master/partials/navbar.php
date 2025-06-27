<?php ob_start() ?>

<?php 
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

$viewUserDataQuery = "SELECT * FROM users WHERE user_id = :user_id";
$viewUserDataPrepare = $connect->prepare($viewUserDataQuery);
$viewUserDataPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
$viewUserDataPrepare->execute();
$userData = $viewUserDataPrepare->fetch(PDO::FETCH_ASSOC);
?> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="vendor2/fonts/boxicons.css" />
    <!--===============================================================================================-->
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="vendor2/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="vendor2/css/theme-default.css" class="template-customizer-theme-css" />
    <!--===============================================================================================-->
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="vendor2/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="vendor2/libs/apex-charts/apex-charts.css" />
    
    <!--===============================================================================================-->
<style>
	.dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }

    .dropdown i {
      font-size: 24px;
      cursor: pointer;
    }
    .BG-Color{
        background-color: #000;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        display: flex;
        font-size: 2.1rem;
        color: #ffffff;
        font-weight: 600;
    }
    .dropdown-toggle::after {
        display: none;
    }
    .avatar.avatar-online:after{
        right: -3.5px;
        top: 29px;
    }
    .flex-grow-1 {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }
	.dropdown-menu{
		z-index: 5;
	}
	.container {
        max-width: 97%;
    }
	.p-l-65 {
        padding-left: 55px;
    }
    @media (max-width: 991px) {
        .nav-link {
            padding: 0.5rem 0.8rem;
        }
        .m-r-15 {
            margin-right: 2px;
        }
        .BG-Color {
            width: 35px;
            height: 35px;
            font-size: 2rem;
        }
        .avatar.avatar-online:after {
            right: 0.5px;
            top: 24px;
        }
    }
</style>
   <header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<!-- <div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>

					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m trans-04 p-lr-25">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							My Account
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							EN
						</a>

						<a href="#" class="flex-c-m trans-04 p-lr-25">
							USD
						</a>
					</div>
				</div>
			</div> -->

			<div class="wrap-menu-desktop">
				<nav class="limiter-menu-desktop container">
					
					<!-- Logo desktop -->		
					<a href="index.php" class="logo">
						<img src="images/icons/logo-01.png" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="index.php">Home</a>
							</li>

							<li>
								<a href="product.php">Shop</a>
							</li>

							<!-- <li class="label1" data-label1="hot">
								<a href="shoping-cart.php">Features</a>
							</li>

							<li>
								<a href="blog.php">Blog</a>
							</li> -->

							<li>
								<a href="about.php">About</a>
							</li>

							<li>
								<a href="contact.php">Contact</a>
							</li>
							<li>
								<a href="order.php">Order</a>
							</li>
						</ul>
					</div>	


					<?php
						$countCartQuery = "SELECT COUNT(Prod_id) FROM carts WHERE user_id = :user_id";
						$countCartPrepare = $connect->prepare($countCartQuery);
						$countCartPrepare->bindParam(':user_id', $_SESSION['userId'], PDO::PARAM_INT);
						$countCartPrepare->execute();
						$countCartData = $countCartPrepare->fetch(PDO::FETCH_ASSOC);
						$countProd = $countCartData['COUNT(Prod_id)'];
					?>


					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<!-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div> -->

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="<?= $countProd ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<!-- <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a> -->
						<li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <div class="avatar <?= isset($_SESSION['userId']) ? 'avatar-online' : 'avatar-offline' ?>">
                            <?php
                                $isUserId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
                                if (!$isUserId && !$isUserId !== "0"){
                            ?>
                            <img src="images/icons/guestUser.png" alt class="w-px-40 h-auto rounded-circle" />
                            <?php } else {?>
                                <div class="BG-Color"><?= strtoupper(substr($userData['username'], 0, 1)); ?></div>
                            <?php } ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                                if ($isUserId && $isUserId !== "0"){
                            ?>
                            <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                     <div class="BG-Color"><?= strtoupper(substr($userData['username'], 0, 1)); ?></div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?= strtoupper($userData['username']) ?></span>
                                </div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <div class="dropdown-divider"></div>
                            </li>
                                <li>
                                    <a class="dropdown-item" href="profile-page.php">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                <div class="dropdown-divider"></div>
                                </li>
                            <?php }?>
                            
                            <li>
                                <?php if ($isUserId && $isUserId !== "0"){ ?>
                                    <a class="dropdown-item" href="pages/logout.php">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                <?php } else{?>
                                    <a class="dropdown-item" href="pages/login.php">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Login</span>
                                    </a>
                                    <a class="dropdown-item" href="pages/signup.php">
                                        <i class="bx bx-plus me-2"></i>
                                        <span class="align-middle">Register</span>
                                    </a>
                                <?php }?>
                                
                            </li>
                        </ul>
                        </li>

  					</div>
					</div>
				</nav>
			</div>	
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->		
			<div class="logo-mobile">
				<a href="index.php"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                            <div class="avatar <?= isset($_SESSION['userId']) ? 'avatar-online' : 'avatar-offline' ?>">
                            <?php
                                $isUserId = isset($_SESSION['userId']) ? $_SESSION['userId'] : 0;
                                if (!$isUserId && !$isUserId !== "0"){
                            ?>
                            <img src="images/icons/guestUser.png" alt class="w-px-40 h-auto rounded-circle" />
                            <?php } else {?>
                                <div class="BG-Color"><?= strtoupper(substr($userData['username'], 0, 1)); ?></div>
                            <?php } ?>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <?php
                                if ($isUserId && $isUserId !== "0"){
                            ?>
                            <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                     <div class="BG-Color"><?= strtoupper(substr($userData['username'], 0, 1)); ?></div>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block"><?= strtoupper($userData['username']) ?></span>
                                </div>
                                </div>
                            </a>
                            </li>
                            <li>
                            <div class="dropdown-divider"></div>
                            </li>
                                <li>
                                    <a class="dropdown-item" href="profile-page.php">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">My Profile</span>
                                    </a>
                                </li>
                                <li>
                                <div class="dropdown-divider"></div>
                                </li>
                            <?php }?>
                            
                            <li>
                                <?php if ($isUserId && $isUserId !== "0"){ ?>
                                    <a class="dropdown-item" href="pages/logout.php">
                                        <i class="bx bx-power-off me-2"></i>
                                        <span class="align-middle">Log Out</span>
                                    </a>
                                <?php } else{?>
                                    <a class="dropdown-item" href="pages/login.php">
                                        <i class="bx bx-user me-2"></i>
                                        <span class="align-middle">Login</span>
                                    </a>
                                    <a class="dropdown-item" href="pages/signup.php">
                                        <i class="bx bx-plus me-2"></i>
                                        <span class="align-middle">Register</span>
                                    </a>
                                <?php }?>
                                
                            </li>
                        </ul>
                        </li></li>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<!-- <ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Free shipping for standard order over $100
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						<a href="#" class="flex-c-m p-lr-10 trans-04">
							Help & FAQs
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							My Account
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							EN
						</a>

						<a href="#" class="flex-c-m p-lr-10 trans-04">
							USD
						</a>
					</div>
				</li>
			</ul> -->

			<ul class="main-menu-m">
				<li>
					<a href="index.php">Home</a>
				</li>

				<li>
					<a href="product.php">Shop</a>
				</li>

				<!-- <li>
					<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.php">Blog</a>
				</li> -->

				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>
				<li>
					<a href="order.php">Order</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="images/icons/icon-close2.png" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div>
	</header>
	
	<div class="wrap-header-cart js-panel-cart">
			<div class="s-full js-hide-cart"></div>

			<div class="header-cart flex-col-l p-l-65 p-r-25">
				<div class="header-cart-title flex-w flex-sb-m p-b-8">
					<span class="mtext-103 cl2">
						Your Cart
					</span>

					<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
						<i class="zmdi zmdi-close"></i>
					</div>
				</div>
				
				<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
						<?php
						if(isset($_SESSION['userId']))
						{
							$userId = $_SESSION['userId'];
							$viewCartQuery = "SELECT * FROM carts JOIN products ON carts.prod_id = products.product_id WHERE user_id = :id";
							$viewCartPrepare = $connect->prepare($viewCartQuery);
							$viewCartPrepare->bindParam(':id', $userId , PDO::PARAM_INT);
							$viewCartPrepare->execute();  
							$viewCartData = $viewCartPrepare->fetchAll(PDO::FETCH_ASSOC);

						foreach($viewCartData as $cartData) {
						?>
							<li class="header-cart-item flex-w flex-t m-b-12">
								<a href="delete_qty_cart.php?id=<?= $cartData['cart_id'] ?>">
                                    <div class="header-cart-item-img">
                                        <img src="../adminPanel/html/images/<?= explode(",", $cartData['product_images'])[0] ?>" alt="IMG">
                                    </div>
                                </a>

								<div class="header-cart-item-txt p-t-8">
									<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
									<?= mb_strimwidth($cartData['product_name'] , 0, 22, "...")?>
									</a>
		
									<span class="header-cart-item-info">
									<?=$cartData['product_price']?> × <?=$cartData['quantity']?> = <?=$cartData['quantity']*$cartData['product_price'];?>
									</span>
								</div>
							</li>
						<?php } 
						}else{
							echo "User not logged in";
						}?>
					</ul>


					<?php
						$subTotalQuery = 'SELECT ROUND(SUM(products.product_price * carts.quantity),2) as subTotal FROM `carts` JOIN products ON products.product_id = carts.prod_id WHERE user_id = :id';
						$subTotalPrepare = $connect->prepare($subTotalQuery);
						$subTotalPrepare->bindParam(':id', $userId, PDO::PARAM_INT);
						$subTotalPrepare->execute();
						$subTotal = $subTotalPrepare->fetch(PDO::FETCH_ASSOC);
					?>
					
					<div class="w-full">
						<div class="header-cart-total w-full p-tb-40">
							Total: $<?= !$subTotal['subTotal'] ? 0 : $subTotal['subTotal'] ?>

						</div>

						<div class="header-cart-buttons flex-w w-full">
							<a href="shoping-cart.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
								View Cart
							</a>

							<a href="check-out.php" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
								Check Out
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<script>
		// 	document.addEventListener("DOMContentLoaded", () => {
		// 	const userMenu = document.getElementById("userMenu");
		// 	const isUserId = userMenu.getAttribute("data-isuserid");

		// 	if (isUserId && isUserId !== "0") {
		// 		// User is logged in
		// 		userMenu.innerHTML = `
		// 			<a href="pages/logout.php">Logout</a>
		// 		`;
		// 	} else {
		// 		// User is not logged in
		// 		userMenu.innerHTML = `
		// 			<a href="pages/login.php">Login</a>
		// 			<a href="pages/signup.php">Register</a>
		// 		`;
		// 	}
		// });

		</script>
	
        <!-- Core JS -->
        <!-- build:js assets/vendor2/js/core.js -->
        <script src="vendor2/libs/jquery/jquery.js"></script>
        <script src="vendor2/libs/popper/popper.js"></script>
        <script src="vendor2/js/bootstrap.js"></script>
        <script src="vendor2/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

        <script src="vendor2/js/menu.js"></script>
        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="vendor2/libs/apex-charts/apexcharts.js"></script>