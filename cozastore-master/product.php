<?php require "connection/connection.php"; session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Product</title>
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
    .category-container {
      width: 82%;
      overflow-x: auto;
      white-space: nowrap;
      display: flex;
      gap: 10px;
      padding-bottom: 5px; /* Scrollbar ke liye space */
      scrollbar-width: thin; /* Firefox */
      scrollbar-color: #888 #f1f1f1; /* Firefox */
    }

    /* ✅ Custom Scrollbar for Webkit (Chrome, Edge, Safari) */
    .category-container::-webkit-scrollbar {
        height: 6px;
    }

    .category-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .category-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .category-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .active-tag {
        font-weight: 600;
        color: #717fe0 !important;
        text-decoration: underline;
        text-decoration-color: #717fe0;
        text-underline-offset: 4px;
        text-decoration-thickness: 2px;
    }
	.hov1:hover {
		color: #717fe0;
		border-color: #717fe0;
	}
    </style>
</head>


<?php
						// Fetch available categories (tags) from the database
						$filterCategoryQuery = "SELECT * FROM `categories`";
						$filterCategoryQueryPrepare = $connect->prepare($filterCategoryQuery);
						$filterCategoryQueryPrepare->execute();
						$filterCategoryData = $filterCategoryQueryPrepare->fetchAll(PDO::FETCH_ASSOC);

						// Get the selected category from the request (for filtering)
						$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;
						?>








<body class="animsition">
	
	<!-- Header -->
	<?php require "partials/lightnavbar.php" ?>

	<!-- Cart -->
	
	
	<!-- Product -->
	
    <?php

// Fetch categories for the filter options
$filterCategoryQuery = "SELECT * FROM categories";
$filterCategoryPrepare = $connect->prepare($filterCategoryQuery);
$filterCategoryPrepare->execute();
$filterCategoryData = $filterCategoryPrepare->fetchAll(PDO::FETCH_ASSOC);

// Fetch available colors for the filter options
$filterColorQuery = "SELECT * FROM colors";
$filterColorPrepare = $connect->prepare($filterColorQuery);
$filterColorPrepare->execute();
$filterColorData = $filterColorPrepare->fetchAll(PDO::FETCH_ASSOC);

// Default filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'default';
$priceFilter = isset($_GET['price']) ? $_GET['price'] : 'all';
$selectedColor = isset($_GET['color']) ? $_GET['color'] : null;
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

// Build the query dynamically based on filters
$mergedFilterQuery = "SELECT * FROM products WHERE 1=1";

// Apply price filter
if ($priceFilter !== 'all') {
    $priceRanges = [
        '0-50' => "product_price BETWEEN 0 AND 50",
        '50-100' => "product_price BETWEEN 50 AND 100",
        '100-150' => "product_price BETWEEN 100 AND 150",
        '150-200' => "product_price BETWEEN 150 AND 200",
        '200' => "product_price > 200"
    ];
    if (isset($priceRanges[$priceFilter])) {
        $mergedFilterQuery .= " AND " . $priceRanges[$priceFilter];
    }
}

// Apply color filter
if (!empty($selectedColor) && $selectedColor !== 'all') {
    $mergedFilterQuery .= " AND product_id IN (
        SELECT product_id FROM product_colors WHERE color_id = :color_id
    )";
}

// Apply category filter
if (!empty($selectedCategory) && $selectedCategory !== 'all') {
    $mergedFilterQuery .= " AND category_id = :category_id";
}

// Apply sorting
switch ($filter) {
    case 'low-to-high':
        $mergedFilterQuery .= " ORDER BY product_price ASC";
        break;
    case 'high-to-low':
        $mergedFilterQuery .= " ORDER BY product_price DESC";
        break;
    default:
        $mergedFilterQuery .= " ORDER BY product_id ASC";
        break;
}

// Prepare the query
$mergedFilterPrepare = $connect->prepare($mergedFilterQuery);

// Bind parameters for color and category if applicable
if (!empty($selectedColor) && $selectedColor !== 'all') {
    $mergedFilterPrepare->bindParam(':color_id', $selectedColor, PDO::PARAM_INT);
}
if (!empty($selectedCategory) && $selectedCategory !== 'all') {
    $mergedFilterPrepare->bindParam(':category_id', $selectedCategory, PDO::PARAM_INT);
}

// Execute the query
$mergedFilterPrepare->execute();
$filteredProducts = $mergedFilterPrepare->fetchAll(PDO::FETCH_ASSOC);

// Handle search functionality
if (isset($_POST['searchBtn']) && !empty($_POST['search'])) {
    $searchValue = $_POST['search'];
    $searchQuery = "SELECT * FROM products WHERE product_name LIKE :searchValue";
    $searchPrepare = $connect->prepare($searchQuery);
    $searchPrepare->bindValue(':searchValue', "%" . $searchValue . "%", PDO::PARAM_STR);
    $searchPrepare->execute();
    $filteredProducts = $searchPrepare->fetchAll(PDO::FETCH_ASSOC);
}
?>

    <section class="bg0 p-t-23 p-b-140">

        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Product Overview
                </h3>
            </div>

            <div class="flex-w flex-sb-m p-b-52">

                <div class="category-container">
                    <a href="?category=all" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 
                        <?= $selectedCategory === null || $selectedCategory === 'all' ? 'active-tag' : '' ?>">
                        All Products
                    </a>
                    <?php foreach ($filterCategoryData as $category) { ?>
                    <a href="?category=<?= $category['category_id'] ?>"
                        class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 <?= $selectedCategory == $category['category_id'] ? 'active-tag' : '' ?>">
                        <?= htmlspecialchars($category['category_name']) ?>
                    </a>
                    <?php } ?>
                </div>

                <div style="display: flex; flex-direction: row;">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>
    
                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>

            </div>

            <!-- Search form -->
            <form method="post" class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <button name="searchBtn" class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search" placeholder="Search">
                </div>
            </form>

            <!-- Filter Options -->
            <div class="dis-none panel-filter w-full p-t-10">
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                    <!-- Price filter -->
                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Sort By</div>
                        <ul>
                            <li class="p-b-6">
                                <a href="?filter=default"
                                    class="filter-link stext-106 trans-04 <?= $filter == 'default' ? 'filter-link-active' : '' ?>">Default</a>
                            </li>
                            <li class="p-b-6">
                                <a href="?filter=low-to-high"
                                    class="filter-link stext-106 trans-04 <?= $filter == 'low-to-high' ? 'filter-link-active' : '' ?>">Price:
                                    Low to High</a>
                            </li>
                            <li class="p-b-6">
                                <a href="?filter=high-to-low"
                                    class="filter-link stext-106 trans-04 <?= $filter == 'high-to-low' ? 'filter-link-active' : '' ?>">Price:
                                    High to Low</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Price Range filter -->
                    <div class="filter-col2 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Price</div>
                        <ul>
                            <li class="p-b-6"><a href="?price=all"
                                    class="filter-link stext-106 trans-04 <?= $priceFilter == 'all' ? 'filter-link-active' : '' ?>">All</a>
                            </li>
                            <li class="p-b-6"><a href="?price=0-50"
                                    class="filter-link stext-106 trans-04 <?= $priceFilter == '0-50' ? 'filter-link-active' : '' ?>">$0.00
                                    - $50.00</a></li>
                            <li class="p-b-6"><a href="?price=50-100"
                                    class="filter-link stext-106 trans-04 <?= $priceFilter == '50-100' ? 'filter-link-active' : '' ?>">$50.00
                                    - $100.00</a></li>
                            <li class="p-b-6"><a href="?price=100-150"
                                    class="filter-link stext-106 trans-04 <?= $priceFilter == '100-150' ? 'filter-link-active' : '' ?>">$100.00
                                    - $150.00</a></li>
                            <li class="p-b-6"><a href="?price=150-200"
                                    class="filter-link stext-106 trans-04 <?= $priceFilter == '150-200' ? 'filter-link-active' : '' ?>">$150.00
                                    - $200.00</a></li>
                            <li class="p-b-6"><a href="?price=200"
                                    class="filter-link stext-106 trans-04 <?= $priceFilter == '200+' ? 'filter-link-active' : '' ?>">$200.00+</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Color filter -->
                    <div class="filter-col3 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Color</div>
                        <ul>
                            <li class="p-b-6"><a href="?color=all"
                                    class="filter-link stext-106 trans-04 <?= $selectedColor === null || $selectedColor === 'all' ? 'filter-link-active' : '' ?>">All</a>
                            </li>
                            <?php foreach ($filterColorData as $color) { ?>
                            <li class="p-b-6">
                                <a href="?color=<?= $color['color_id'] ?>"
                                    class="filter-link stext-106 trans-04 <?= $selectedColor == $color['color_id'] ? 'filter-link-active' : '' ?>">
                                    <?= htmlspecialchars($color['color_name']) ?>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>

                    <!-- Filter by Tag -->

                    <div class="filter-col4 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">
                            Tags
                        </div>
                        <div class="flex-w p-t-4 m-r--5">
                            <!-- "All" option -->
                            <a href="?category=all"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 <?= $selectedCategory === null || $selectedCategory === 'all' ? 'active-tag' : '' ?>">
                                All
                            </a>

                            <!-- Dynamic categories (tags) -->
                            <?php foreach ($filterCategoryData as $category) { ?>
                            <a href="?category=<?= $category['category_id'] ?>"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5 <?= $selectedCategory == $category['category_id'] ? 'active-tag' : '' ?>">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </a>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Display filtered products -->
            <div class="row isotope-grid" id="product-list">
                <?php
					// $limit = 8; // Number of products to display initially
					// $query = "SELECT * FROM products LIMIT :limit";
					// $stmt = $connect->prepare($query);
					// $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
					// $stmt->execute();
					// $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if (!empty($filteredProducts)) {
						foreach ($filteredProducts as $productData) {
				?>
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img style="aspect-ratio: 3 / 3.7" src="../adminPanel/html/images/<?= explode(",", $productData['product_images'])[0] ?>"
                                alt="IMG-PRODUCT">
                            <a href="product-detail.php?id=<?= $productData['product_id'] ?>"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                View
                            </a>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="product-detail.php?id=<?= $productData['product_id'] ?>"
                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    <?=mb_strimwidth($productData['product_name'] , 0, 30, "...")?>
                                </a>
                                <span
                                    class="stext-105 cl3">$<?= htmlspecialchars($productData['product_price']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
					}
					} else {
						echo '<p>No products found.</p>';
					}
				?>
            </div>

        </div>
        <!-- Load more -->
        <!-- <div class="flex-c-m flex-w w-full p-t-45" id="loadMoreBtn">
			<button type="button" onclick="loadMore()" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04" >
				Load More
			</button>
			<input type="hidden" id="start" value="0">
		</div> -->

        <!-- <div class="flex-c-m flex-w w-full p-t-45">
            <a href="javascript:void(0);" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04"
                id="loadMoreBtn">
                Load More
            </a>
        </div> -->

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
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="images/icons/icon-close.png" alt="CLOSE">
				</button>

				<div class="row">
					< class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb">
									<div class="item-slick3" data-thumb="../../sneat-updated12\html\images/<?=$productData['product_images']?>">
										<div class="wrap-pic-w pos-relative">
											<img src="../../sneat-updated12\html\images/<?=$productData['product_images']?>" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../sneat-updated12\html\images/<?=$productData['product_images']?>">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="../../sneat-updated12\html\images/<?=$productData['product_images']?>">
										<div class="wrap-pic-w pos-relative">
											<img src="../../sneat-updated12\html\images/<?=$productData['product_images']?>" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../sneat-updated12\html\images/<?=$productData['product_images']?>">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="../../sneat-updated12\html\images/<?=$productsData['product_images']?>">
										<div class="wrap-pic-w pos-relative">
											<img src="../../sneat-updated12\html\images/<?=$productData['product_images']?>" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="../../sneat-updated12\html\images/<?=$productData['product_images']?>">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								Lightweight Jacket
							</h4>

							<span class="mtext-106 cl2">
								$58.79
							</span>

							<p class="stext-102 cl3 p-t-23">
								Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat ornare feugiat.
							</p>
							
							<!--  -->
							<div class="p-t-33">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Size
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Size S</option>
												<option>Size M</option>
												<option>Size L</option>
												<option>Size XL</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Red</option>
												<option>Blue</option>
												<option>White</option>
												<option>Grey</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>

										<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											Add to cart
										</button>
									</div>
								</div>	
							</div>

							<!--  -->
							<div class="flex-w flex-m p-l-100 p-t-40 respon7">
								<div class="flex-m bor9 p-r-10 m-r-11">
									<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
										<i class="zmdi zmdi-favorite"></i>
									</a>
								</div>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
									<i class="fa fa-facebook"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
									<i class="fa fa-twitter"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
									<i class="fa fa-google-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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
		$(".js-select2").each(function(){
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
		        	enabled:true
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
		$('.js-addwish-b2, .js-addwish-detail').on('click', function(e){
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function(){
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function(){
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function(){
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function(){
				swal(nameProduct, "is added to cart !", "success");
			});
		});
	
	</script>
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
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.querySelector(".category-container");

            container.addEventListener("wheel", function(event) {
                event.preventDefault();
                container.scrollLeft += event.deltaY;
            });
        });
    </script>

</body>
</html>