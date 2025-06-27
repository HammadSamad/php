

<?php require '../connection/connection.php' ?>



<?php
 session_name('adminPanel');

session_start();

if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}

$prodCateQuery = "SELECT * FROM `products` JOIN categories ON products.category_id = categories.category_id";
$prodCatePrepare = $connect->prepare($prodCateQuery);
$prodCatePrepare->execute();
$productsData = $prodCatePrepare->fetchAll(PDO::FETCH_ASSOC);

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

    <title>View Products</title>

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

        

    .file-upload-container {
      position: relative;
      display: flex;
      align-items: center;
      /* justify-content: center; */
      /* display: inline-block; */
    }

    .file-upload-container input[type="file"] {
      display: none; /* Hide the default file input */
    }

    .file-upload-container label {
      display: inline-block;
      background-color: #696cff; /* Purple background */
      color: white;
      font-size: 16px;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      text-align: center;
      margin-bottom: 0;
    }

    .file-upload-container label:hover {
      background-color: #8486ff; /* Darker purple on hover */
    }

    .file-upload-container label svg {
      vertical-align: middle;
      margin-right: 8px;
    }

    .file-name {
      margin-left: 10px;
      font-size: 14px;
      color: #333;
      display: inline-block;
    }





    .pric input[type="number"]::-webkit-inner-spin-button{
        -webkit-appearance: none;
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

          <?php require "../partials/navbaar.php" ?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-md-12">

                  <div class="card mb-4">
                    <h5 class="card-header">Products</h5>
                    <!-- Account -->
                    
                    <!-- <hr class="my-0" /> -->
                    <div class="card-body">
                      

                    <div class="row row-cols-1 row-cols-md-2">



                    <?php foreach($productsData as $prodData){ 

                      $images = explode(",",$prodData['product_images'])

                    ?>
                        <!-- ..... -->
                        <div class="col mb-4">
    <div class="card">
        <div id="carousel1_<?= $prodData['product_id'] ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php 
                $isActive = true; // Flag to set the first image as active
                foreach ($images as $image) { 
                ?>
                    <div class="carousel-item <?= $isActive ? 'active' : '' ?>">
                        <img style="aspect-ratio: 3/3;" src="../images/<?= $image ?>" class="d-block w-100" alt="Product Image">
                    </div>
                <?php 
                    $isActive = false; // After the first image, set active to false
                } 
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel1_<?= $prodData['product_id'] ?>" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel1_<?= $prodData['product_id'] ?>" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="card-body">
            <p class="card-text"><strong style="color: black;">Product Id: </strong><?= $prodData['product_id'] ?></p>
            <h5 class="card-title"> <strong style="color: black;">Name: </strong> <?= $prodData['product_name'] ?></h5>
            <h6><strong style="color: black;">Price: </strong>$ <?= $prodData['product_price'] ?></h6>
            <p class="card-text"><strong style="color: black;">Description: </strong><?= $prodData['product_description'] ?></p>
            <p><strong style="color: black;">Category Name: </strong><?= $prodData['category_name'] ?></p>
            <p><strong style="color: black;">In Stock: </strong><?= $prodData['stock_quantity'] ?></p>
            <div>
                <a href="editProducts.php?id=<?= $prodData['product_id'] ?>" class="btn btn-icon btn-primary w-25" style="color: white"><span class="bx bx-edit-alt"></span> &nbsp; Edit</a>
                <a href="deleteProducts.php?id=<?= $prodData['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')" class="btn btn-icon btn-primary w-25" style="color: white"><span class="bx bx-trash"></span> &nbsp; Delete</a>
            </div>
        </div>
    </div>
</div>


                            <?php } ?>
                            
                            <!-- Repeat the same structure for other cards -->
                        </div>


                    </div>
                    <!-- /Account -->
                  </div>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
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

</script>




  </body>
</html>
i