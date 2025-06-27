<?php require "connection/connection.php" ?>
<?php
	session_start();
	$slideViewQuery = "SELECT * FROM `slider`";
	$slideViewPrepare = $connect->prepare($slideViewQuery);
	$slideViewPrepare->execute();
	$slideData = $slideViewPrepare->fetchALL(PDO::FETCH_ASSOC);

?>
<?php
	// Fetch available categories (tags) from the database
	$filterCategoryQuery = "SELECT * FROM `categories`";
	$filterCategoryQueryPrepare = $connect->prepare($filterCategoryQuery);
	$filterCategoryQueryPrepare->execute();
	$filterCategoryData = $filterCategoryQueryPrepare->fetchAll(PDO::FETCH_ASSOC);

	// Get the selected category from the request (for filtering)
	$selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home</title>
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
    

    <!-- Custom CSS -->
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

<body class="animsition">

    <!-- Header -->
    <?php require "partials/navbar.php" ?>

    <!-- Cart -->
    <?php
	//  require "pages/navcart.php" 
	?>
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                <?php foreach ($slideData as $slides){ ?>
                <div class="item-slick1"
                    style="background-image: url(../adminPanel/html/images/<?=$slides['slider_image']?>);">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
                                <span class="ltext-101 cl2 respon2">
                                    <?=$slides['first_text']?>
                                </span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn"
                                data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                    <?=$slides['second_text']?>
                                </h2>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
                                <a href="product.php"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="item-slick1" style="background-image: url(images/slide-02.jpg);">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rollIn" data-delay="0">
                                <span class="ltext-101 cl2 respon2">
                                    Men New-Season
                                </span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="lightSpeedIn"
                                data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                    Jackets & Coats
                                </h2>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="slideInUp" data-delay="1600">
                                <a href="product.php"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-slick1" style="background-image: url(images/slide-03.jpg);">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft"
                                data-delay="0">
                                <span class="ltext-101 cl2 respon2">
                                    Men Collection 2018
                                </span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight"
                                data-delay="800">
                                <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                    New arrivals
                                </h2>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
                                <a href="product.php"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Shop Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Banner -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="row">
                <?php foreach ($filterCategoryData as $catData){ ?>
                <div class="col-md-6 col-xl-4 p-b-30 m-lr-auto">
                    <!-- Block1 -->
                    <div class="block1 wrap-pic-w">
                        <!-- <img src="../adminPanel/html/images/678ce4109b6cd.jpg" alt="IMG-BANNER"> -->
                        <img style="aspect-ratio: 4 / 4" src="../adminPanel/html/images/<?= $catData['category_image'] ?>" alt="IMG-BANNER">

                        <a href="product.php?category=<?= $catData['category_id'] ?>"
                            class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                            <div class="block1-txt-child1 flex-col-l">
                                <span class="block1-name ltext-102 trans-04 p-b-8">
                                    <?= $catData['category_name'] ?>
                                </span>

                            </div>

                            <div class="block1-txt-child2 p-b-4 trans-05">
                                <div class="block1-link stext-101 cl0 trans-09">
                                    Shop Now
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php } ?>


            </div>
        </div>
    </div>


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
    $('.js-addwish-b2').on('click', function(e) {
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



    <script>
    function updateQuantity(change, button) {
        // Find the associated input field
        const qtyInput = button.parentElement.querySelector('.quantity');

        // Parse the current quantity value
        let currentQty = parseInt(qtyInput.value, 10) || 1;

        // Update the quantity with the change
        currentQty += change;

        // Prevent negative or zero quantity
        if (currentQty < 1) currentQty = 1;

        // Set the updated quantity
        qtyInput.value = currentQty;
    }





    document.getElementById('add-to-cart').addEventListener('click', function(e) {
        e.preventDefault();

        // Get the quantity and product ID
        const quantity = document.getElementById('quantity').value;
        const productId = document.getElementById('product_id').value;

        // Send the data via AJAX
        $.ajax({
            url: 'addToCart.php', // PHP file to handle insertion
            type: 'POST',
            data: {
                quantity: quantity,
                product_id: productId
            },
            success: function(response) {
                // Display the alert message from the PHP response
                if (response.status === "success") {
                    alert(response.message); // Success message
                } else if (response.status === "error") {
                    alert(response.message); // Error message
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ', error);
                alert('Failed to communicate with the server.');
            }
        });
    });



    // load more

    // function loadMore() {
    // 	var start = parseInt($("#start").val());
    // 	var perpage = 8;
    // 	start = start + perpage;
    // 	$("#start").val(start);
    // 	$.ajax({
    // 		url: "load_more_products.php",
    // 		method: "POST",
    // 		data: {
    // 			starting: start,
    // 			limit: perpage
    // 		},
    // 		success: function(response) {
    // 			console.log(response);
    // 			if (response != '') {
    // 				$("#product-list").append(response);
    // 			} else {
    // 				$("#loadMoreBtn").slideUp(10);
    // 			}
    // 		},
    // 		error: function(xhr, status, error) {
    // 			console.error('AJAX Error: ', error);
    // 			alert('Failed to load more products.');
    // 		}
    // 	});
    // }
    </script>


</body>

</html>