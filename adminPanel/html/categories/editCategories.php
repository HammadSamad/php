



<?php require '../connection/connection.php' ?>



<?php
 session_name('adminPanel');
session_start();
if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}
    $id = $_GET['id'];

    // echo $id;


        $categoryQuery = "SELECT * FROM `categories` WHERE `category_id` = :id";
        $categoryPrepare = $connect->prepare($categoryQuery);
        $categoryPrepare->bindParam(':id', $id, PDO::PARAM_INT);
        $categoryPrepare->execute();
        $categroyData = $categoryPrepare->fetch(PDO::FETCH_ASSOC);
        
        
        if(isset($_POST['btn'])){
  if(empty($_POST['categoryName']))
  {
    echo "<script>alert('Feild is Empty')</script>";
  }
  else
  {
    $categoryName = $_POST['categoryName'];
    $categoryImage = $_FILES['categoryImage'];

    if (!preg_match("/^[A-Za-z ]+$/", $categoryName)) {
      echo "<script>alert('Error: Category Name should only contain alphabets!');</script>";
    } else {

      if($categoryImage ['size'] > 500000){
        echo 'Your Image Size Is To Big';
      }
      else{
        $extenshion = explode('.', $categoryImage ['name']);
        $extenshion = $extenshion [1];
        $imageUniqueName = uniqid();
        $imageName = $imageUniqueName . '.' . $extenshion;
        move_uploaded_file($categoryImage['tmp_name'], "../images/" .$imageName);
        
        $img =empty($categoryImage['name']) ? $categroyData['category_image'] : $imageName;
        

        $categoryQuery= "UPDATE `categories` SET `category_name`= :categoryName, category_image = :category_image WHERE `category_id` = :id";
        $categoryprepare = $connect->prepare($categoryQuery);
        $categoryprepare->bindParam(':categoryName',$categoryName,PDO::PARAM_STR);
        $categoryprepare->bindParam(':category_image',$img,PDO::PARAM_STR);
        $categoryprepare->bindParam(':id',$id,PDO::PARAM_INT);

        if($categoryprepare->execute()){
          echo "<script>alert('Category added successfully!')</script>";
          header("location:viewCategories.php");
        }
      }
    }
  }
}

?>











<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
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

          <?php require '../partials/navbaar.php'  ?>


          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-md-12">

                  <div class="card mb-4">
                    <h5 class="card-header">Edit Category</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST" enctype="multipart/form-data">
                        <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="firstName" class="form-label">Category Name</label>
                            <input
                              class="form-control"
                              type="text"
                              id="firstName"
                              name="categoryName"
                              placeholder="Category Name"
                              required
                              value="<?= $categroyData["category_name"] ;?>"
                            />
                          </div>
                          <div class="mb-3 col-md-12">
                            <label for="firstName" class="form-label">Category Image</label>
                            <br>
                            <img src="../images/<?=$categroyData['category_image']?>" alt="" width="80px" height="80px">
                            <br>
                            <br>
                            <div class="file-upload-container">
                            <input type="file" id="fileUpload" name="categoryImage" accept="image/jpg,image/jpeg,image/png">


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
                          <button type="submit" class="btn btn-primary me-2" name="btn">Edit Category</button>
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
            <?php  require '../partials/footer.php'  ?>

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
