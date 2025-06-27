<?php require '../connection/connection.php' ;
 session_name('adminPanel');

session_start();

if(!isset($_SESSION['apUserId']))
{
	header("location:../auth=login-basic.php");
}

?>

<?php

        $categoryQuery = "SELECT * FROM `categories`";
        $categoryPrepare = $connect->prepare($categoryQuery);
        $categoryPrepare->execute();
        $CategroyData = $categoryPrepare->fetchAll(PDO::FETCH_ASSOC);
        
        
        $colorQuery = "SELECT * FROM `colors`";
        $colorPrepare = $connect->prepare($colorQuery);
        $colorPrepare->execute();
        $colorData = $colorPrepare->fetchAll(PDO::FETCH_ASSOC);
        
        
        $sizeQuery = "SELECT * FROM `sizes`";
        $sizePrepare = $connect->prepare($sizeQuery);
        $sizePrepare->execute();
        $sizeData = $sizePrepare->fetchAll(PDO::FETCH_ASSOC);
        


if(isset($_POST['btn'])){

  $prodName = $_POST['prodName'];
  $prodDesc = $_POST['prodDesc'];
  $prodPrice = $_POST['prodPrice'];
  $prodQuantity = $_POST['prodQuantity'];
  $CategoryId = $_POST['Category_id'];
  $prodColors = $_POST['prodColor']; // This is now an array
  $prodSizes = $_POST['prodSize']; // This is now an array
  $prodImages = $_FILES['prodImages']; // Multiple images

  if (!preg_match("/^(?=.*[A-Za-z])[A-Za-z0-9 .,()-]+$/", $prodName)) {
      echo "<script>alert('Error: Product name must contain at least one letter and can include letters, numbers, spaces, and special characters (, . - ()).');</script>";
  } else {

  do {
    // Generate the code and number
    $prodCode = rand(10, 99);
    $prodNum = rand(11111, 99999);
    $prodId = $prodCode . $prodNum;

    // Check for uniqueness in the database
    $checkQuery = "SELECT COUNT(*) FROM `product_code_num` WHERE `product_code` = :prodCode AND `product_num` = :prodNum";
    $checkStmt = $connect->prepare($checkQuery);
    $checkStmt->bindParam(':prodCode', $prodCode, PDO::PARAM_INT);
    $checkStmt->bindParam(':prodNum', $prodNum, PDO::PARAM_INT);
    $checkStmt->execute();
    $exists = $checkStmt->fetchColumn();
} while ($exists > 0); 

  // echo $prodCode . "<br>";
  // echo $prodNum . "<br>";
  // echo $prodId . "<br>";

  $prodCodeInsertQuery = "INSERT INTO `product_code_num`(`product_code`,`product_num`) VALUES (:prodCode ,:prodNum)";
  $prodCodeinsertPrepare = $connect->prepare($prodCodeInsertQuery);
  $prodCodeinsertPrepare->bindParam(':prodCode', $prodCode , PDO::PARAM_INT);
  $prodCodeinsertPrepare->bindParam(':prodNum', $prodNum , PDO::PARAM_INT);
  $prodCodeinsertPrepare->execute();

  // Retrieve the last inserted p_c_n_id
  $pcnId = $connect->lastInsertId();

  // Validate and process multiple images
  $imageNames = [];
  foreach ($prodImages['tmp_name'] as $key => $tmpName) {
      if ($prodImages['size'][$key] < 5000000) {
          $ext = pathinfo($prodImages['name'][$key], PATHINFO_EXTENSION);
          $uniqueName = uniqid() . '.' . $ext;
          move_uploaded_file($tmpName, "../images/" . $uniqueName);
          $imageNames[] = $uniqueName;
      } else {
          echo "<script>alert('One or more images exceed the size limit of 5MB');</script>";
      }
  }

  // Join image names into a comma-separated string
  $imageNameString = implode(',', $imageNames);

  // foreach ($prodColors as $prodColor) {
  //     foreach ($prodSizes as $prodSize) {
          $insertQuery = "INSERT INTO `products`(`product_id`,`product_name`,`product_description`, `product_price`,`category_id`,`stock_quantity`,`product_images`, `p_c_n_id`) VALUES (:prodId,:prodName,:prodDesc,:prodPrice,:categoryid,:prodQuantity,:imageNameString,:pcnId)";

          $insertPrepare = $connect->prepare($insertQuery);
          $insertPrepare->bindParam(':prodId', $prodId, PDO::PARAM_INT);
          $insertPrepare->bindParam(':prodName', $prodName, PDO::PARAM_STR);
          $insertPrepare->bindParam(':prodDesc', $prodDesc, PDO::PARAM_STR);
          $insertPrepare->bindParam(':prodPrice', $prodPrice);
          $insertPrepare->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);
          $insertPrepare->bindParam(':categoryid', $CategoryId, PDO::PARAM_INT);
          // $insertPrepare->bindValue(':prodColor', 1, PDO::PARAM_INT);
          // $insertPrepare->bindValue(':prodSize', 1, PDO::PARAM_INT);
          $insertPrepare->bindParam(':imageNameString', $imageNameString, PDO::PARAM_STR);
          $insertPrepare->bindParam(':pcnId', $pcnId, PDO::PARAM_INT);

          if ($insertPrepare->execute()) {
              echo "<script>alert('Product added successfully!')</script>";
          }
          //   }
          // }
          
          
          // Insert product-color mappings into `product_colors` table
    foreach ($prodColors as $prodColor) {
      $colorQuery = "INSERT INTO `product_colors` (`product_id`, `color_id`) VALUES (:prodId, :prodColor)";
      $colorStmt = $connect->prepare($colorQuery);
      $colorStmt->bindParam(':prodId', $prodId, PDO::PARAM_STR);
      $colorStmt->bindParam(':prodColor', $prodColor, PDO::PARAM_INT);
      $colorStmt->execute();
    }

  // Insert product-size mappings into `product_sizes` table
  foreach ($prodSizes as $prodSize) {
      $sizeQuery = "INSERT INTO `product_sizes` (`product_id`, `size_id`) VALUES (:prodId, :prodSize)";
      $sizeStmt = $connect->prepare($sizeQuery);
      $sizeStmt->bindParam(':prodId', $prodId, PDO::PARAM_STR);
      $sizeStmt->bindParam(':prodSize', $prodSize, PDO::PARAM_INT);
      $sizeStmt->execute();
  }


    }
  }

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

    <title>Account settings - Account | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

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
                    <h5 class="card-header">Product Details</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                        <div class="row">
                          <div class="mb-3 col-md-12">
                            <label for="firstName" class="form-label">Product Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="prodName"
                              placeholder="Product Name"
                              autofocus
                              
                            />
                          </div>
                          <div class="mb-3 col-md-12">
                            <label for="lastName" class="form-label">Description</label>
                            <input class="form-control desc" type="text" name="prodDesc" id="lastName" placeholder="Description"/>
                          </div>
                          <div class="mb-3 col-md-6 pric">
                            <label for="email" class="form-label">Price</label>
                            <input
                              class="form-control"
                              type="number"
                              id="email"
                              name="prodPrice"
                              placeholder="Price"
                              
                            />
                          </div>
                          <div class="mb-3 col-md-6">
                            <label for="organization" class="form-label">Quantity</label>
                            <input
                              type="number"
                              class="form-control"
                              id="organization"
                              name="prodQuantity"
                              placeholder="Quantity"
                              min="0"
                              step="1"
                              
                            />
                          </div>
                          
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Category</label>
                            <select id="country" class="select2 form-select" name="Category_id">
                              <option disabled selected>Choose an Category</option>
                              <?php foreach ($CategroyData as $c) { ?>
                                <option value="<?= $c['category_id'] ?>"><?= $c['category_name'] ?></option>
                                <?php } ?>
                            </select>
                          </div>

                          <div class="mb-3 col-md-6">
                            <label for="language" class="form-label">Sizes</label>
                            <div class="d-flex" style="margin-top: 0.4rem">
                                <?php foreach ($sizeData as $size) { ?>
                                    <div class="form-check form-switch" style="margin-right: 1.7rem;">
                                    <input class="form-check-input" style="margin-left: -33px;" type="checkbox" id="flexSwitchCheckDefault1" name="prodSize[]" value="<?= $size['size_id'] ?>">
                                    <label class="form-check-label" for="flexSwitchCheckDefault1"> <?= $size['size_name'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                            </div>
                        
                    
                          <div class="mb-3 col-md-12">
                            <label for="language" class="form-label">Colors</label>
                            <div class="d-flex" style="margin-top: 0.4rem">
                                <?php foreach ($colorData as $color) { ?>
                                    <div class="form-check form-switch" style="margin-right: 1.7rem;">
                                    <input class="form-check-input" style="margin-left: -33px;" type="checkbox" id="flexSwitchCheckDefault1" name="prodColor[]" value="<?= $color['color_id'] ?>">
                                    <label class="form-check-label" for="flexSwitchCheckDefault1"> <?= $color['color_name'] ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                          </div>
                          
                          
                          <div class="mb-3 col-md-12">
                            <label for="language" class="form-label">Product Image</label>
                            <div class="file-upload-container">
                            <input type="file" id="fileUpload" name="prodImages[]" accept="image/jpg,image/jpeg,image/png" multiple>


                                <label for="fileUpload">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 0 24 24" width="16" fill="white">
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 20h14v-2H5v2zM9 8v8h6V8h3L12 3 6 8h3z"/>
                                </svg>
                                Upload
                                </label>
                                <span class="file-name" id="fileName">No file chosen</span>
                            </div>
                          </div>
                          
                          
                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2" name="btn">Submit</button>
                          <!-- <button type="reset" class="btn btn-outline-secondary">Cancel</button> -->
                        </div>
                      </form>
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

    <script>
            const fileInput = document.getElementById("fileUpload");
            const fileNameDisplay = document.getElementById("fileName");

            fileInput.addEventListener("change", () => {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = "No file chosen";
            }
            });
        </script>





  </body>
</html>
