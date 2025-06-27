
<?php require "../connection/connection.php" ?>

<?php
 session_name('adminPanel');

session_start();


if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}

?>
<?php

    $userRoleQuery = "SELECT * FROM `roles`";
    $userRolePrepare = $connect->prepare($userRoleQuery);
    $userRolePrepare->execute();
    $userRoleData = $userRolePrepare->fetchAll(PDO::FETCH_ASSOC);



    $permissionQuery = "SELECT * FROM permissions";
    $permissionPrepare = $connect->prepare($permissionQuery);
    $permissionPrepare->execute();
    $permissionData = $permissionPrepare->fetchAll(PDO::FETCH_ASSOC);
    
    

    

    if (isset($_POST['addUserPermission'])) {
      $permissions = $_POST['permission'];
      $userRole = $_POST['userRole'];
  
      foreach ($permissions as $permissionsId) {
          $userPermissionQuery = "INSERT INTO `permission_role` (`role_id`, `permission_id`) VALUES (:role_id, :permission_id)";
          $userPermissionPrepare = $connect->prepare($userPermissionQuery);
          $userPermissionPrepare->bindParam(':role_id', $userRole, PDO::PARAM_INT);
          $userPermissionPrepare->bindParam(':permission_id', $permissionsId, PDO::PARAM_INT); // Use $permissionsId here
          $userPermissionPrepare->execute();
      }
    echo "<script>alert('User Permission Added Successfully')</script>";
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
                    <h5 class="card-header">Add User Permission</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                      <form id="formAccountSettings" method="POST">
                        <div class="row">

                          <div class="mb-3 col-md-12">
                            <label for="exampleInputName1" class="form-label">User Role</label>
                            <br>
                          <select name="userRole" id=""class="form-control">
                          <option value="" selected disabled>Select User Role</option>

                            <?php
                                foreach($userRoleData as $uD){?>
                                    <option value="<?=$uD['role_id']?>"><?=$uD['role_name']?></option>
                                 
                               <?php } ?> 
                            

                          </select>
                          </div>
                          


                          
                          <div class="mb-3 col-md-6">
                              <label for="language" class="form-label">Permissions</label>
                              <div class="d-block" style="margin-top: 0.4rem">
                                  <?php foreach ($permissionData as $pD) { ?>
                                      <div class="form-check form-switch" style="margin-right: 1.7rem;">
                                          <input class="form-check-input" style="margin-left: -33px;" 
                                                type="checkbox" 
                                                id="flexSwitchCheckDefault<?=$pD['permissions_id']?>" 
                                                name="permission[]" 
                                                value="<?=$pD['permissions_id']?>">
                                          <label class="form-check-label" for="flexSwitchCheckDefault<?=$pD['permissions_id']?>">
                                              <?=$pD['permission_name']?>
                                          </label>
                                      </div>
                                  <?php } ?>
                              </div>
                          </div>

                          
                          


                        </div>
                        <div class="mt-2">
                          <button type="submit" class="btn btn-primary me-2 " name="addUserPermission">Add User Permission</button>
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


  </body>
</html>
