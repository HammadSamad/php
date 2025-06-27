



<?php require '../connection/connection.php' ?>



<?php
 session_name('adminPanel');

session_start();
if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}

$id = $_GET['id'];


        $prodQuery = "SELECT * FROM `categories` JOIN `products` ON products.category_id = categories.category_id WHERE product_id = :id";
        $prodPrepare = $connect->prepare($prodQuery);
        $prodPrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $prodPrepare->execute();
        $singleProdData = $prodPrepare->fetch(PDO::FETCH_ASSOC);
        
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
          $prodColors = $_POST['prodColor'] ?? []; // Default to empty array if not set
          $prodSizes = $_POST['prodSize'] ?? []; // Default to empty array if not set
          $prodImages = $_FILES['prodImage'];

          if (!preg_match("/^(?=.*[A-Za-z])[A-Za-z0-9 .,()-]+$/", $prodName)) {
            echo "<script>alert('Error: Product name must contain at least one letter and can include letters, numbers, spaces, and special characters (, . - ()).');</script>";
        } else {
      
          $uploadedImages = [];
          $uploadDir = "../images/";
          $maxFileSize = 5000000; // 5MB
      
          // Handle file uploads
          if (!empty($prodImages['name'][0])) { // Ensure at least one file is uploaded
              foreach ($prodImages['name'] as $key => $imageName) {
                  if ($prodImages['size'][$key] > $maxFileSize) {
                      echo "<script>alert('Image size should be less than 5MB for each image.')</script>";
                      exit;
                  }
      
                  $ext = pathinfo($imageName, PATHINFO_EXTENSION);
                  $uniqueName = uniqid() . "." . $ext;
                  $destination = $uploadDir . $uniqueName;
      
                  if (move_uploaded_file($prodImages['tmp_name'][$key], $destination)) {
                      $uploadedImages[] = $uniqueName;
                  }
              }
          }
      
          // Convert images array to comma-separated string
          $imageNamesString = !empty($uploadedImages) ? implode(",", $uploadedImages) : $singleProdData['product_images'];
      
          // Ensure colors and sizes are arrays before looping
          if (!empty($prodColors) && !empty($prodSizes)) {
              foreach ($prodColors as $prodColor) {
                  foreach ($prodSizes as $prodSize) {
                      $updateQuery = "UPDATE `products` SET 
                          product_name = :prodName, 
                          product_description = :prodDesc, 
                          product_price = :prodPrice, 
                          stock_quantity = :prodQuantity, 
                          product_images = :imageName 
                          WHERE product_id = :id";
      
                      $updatePrepare = $connect->prepare($updateQuery);
                      $updatePrepare->bindParam(':id', $id, PDO::PARAM_INT);
                      $updatePrepare->bindParam(':prodName', $prodName, PDO::PARAM_STR);
                      $updatePrepare->bindParam(':prodDesc', $prodDesc, PDO::PARAM_STR);
                      $updatePrepare->bindParam(':prodPrice', $prodPrice);
                      $updatePrepare->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);
                      $updatePrepare->bindParam(':imageName', $imageNamesString, PDO::PARAM_STR);
      
                      if ($updatePrepare->execute()) {
                          echo "<script>alert('Product updated successfully!')</script>";
                          header('location:viewProducts.php');
                          exit;
                      }
                  }
              }
          } else {
              // If no colors or sizes are selected, still update the product
              $updateQuery = "UPDATE `products` SET 
                  product_name = :prodName, 
                  product_description = :prodDesc, 
                  product_price = :prodPrice, 
                  stock_quantity = :prodQuantity, 
                  product_images = :imageName 
                  WHERE product_id = :id";
      
              $updatePrepare = $connect->prepare($updateQuery);
              $updatePrepare->bindParam(':id', $id, PDO::PARAM_INT);
              $updatePrepare->bindParam(':prodName', $prodName, PDO::PARAM_STR);
              $updatePrepare->bindParam(':prodDesc', $prodDesc, PDO::PARAM_STR);
              $updatePrepare->bindParam(':prodPrice', $prodPrice);
              $updatePrepare->bindParam(':prodQuantity', $prodQuantity, PDO::PARAM_INT);
              $updatePrepare->bindParam(':imageName', $imageNamesString, PDO::PARAM_STR);
      
              if ($updatePrepare->execute()) {
                  echo "<script>alert('Product updated successfully!')</script>";
                  header('location:viewProducts.php');
                  exit;
              }
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

    <!-- Icons. Uncomment  icon fonts -->
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
                    <h5 class="card-header">Edit Product Details</h5>
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
                              value="<?= $singleProdData['product_name'] ?>"
                            />
                          </div>
                          <div class="mb-3 col-md-12">
                            <label for="lastName" class="form-label">Description</label>
                            <input class="form-control desc" type="text" name="prodDesc" id="lastName" placeholder="Description"
                            value="<?= $singleProdData['product_description'] ?>"/>
                          </div>
                          <div class="mb-3 col-md-6 pric">
                            <label for="email" class="form-label">Price</label>
                            <input
                              class="form-control"
                              type="number"
                              id="email"
                              name="prodPrice"
                              placeholder="Price"
                              value="<?= $singleProdData['product_price'] ?>"
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
                              value="<?= $singleProdData['stock_quantity'] ?>"
                            />
                          </div>
                          
                          <div class="mb-3 col-md-6">
                            <label class="form-label" for="country">Category</label>
                            <select id="country" class="select2 form-select" name="Category_id">
                              <option selected deselected style="font-weight: bolder;" value="<?= $singleProdData['category_id'] ?>"><?= $singleProdData['category_name'] ?></option>
                               
                              <?php foreach ($CategroyData as $c) { 
                                if($c['category_name'] != $singleProdData['category_name']){?>
                                <option value="<?= $c['category_id'] ?>"><?= $c['category_name'] ?></option>
                                <?php }} ?>
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
                              <?php $images = explode(",",$singleProdData['product_images']); foreach($images as $image) { ?>
                                <input type="file" id="fileUpload" name="prodImage[]" accept="image/jpg,image/jpeg,image/png" multiple><?php } ?>
                                <label for="fileUpload">
                                <svg xmlns="http://www.w3.org/2000/svg" height="16" viewBox="0 0 24 24" width="16" fill="white">
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M5 20h14v-2H5v2zM9 8v8h6V8h3L12 3 6 8h3z"/>
                                </svg>
                                Upload
                                </label>
                                <span class="file-name" id="fileName"><?= $singleProdData['product_images'] ?></span>
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
