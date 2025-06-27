
<?php
 session_name('adminPanel');

session_start();


if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}

?>



<?php require '../connection/connection.php' ?>



<?php



    $viewCreditCardQuery = "SELECT * FROM `creditcard`";
    $viewCreditCardPrepare = $connect->prepare($viewCreditCardQuery);
    $viewCreditCardPrepare->execute();
    $CreditCardData = $viewCreditCardPrepare->fetchAll(PDO::FETCH_ASSOC);

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

    <title>View Credit Card</title>

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
.table-container {
        overflow: visible !important;
    }

    .table {
        overflow: visible !important;
    }

    .table tbody {
        overflow: visible !important;
    }

    /* Ensure the dropdown menu is not constrained by the table */
    .dropdown-menu {
        position: absolute !important;
        z-index: 1000; /* Ensure the dropdown appears above other elements */
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

            <!-- <div class="container-xxl flex-grow-1 container-p-y">

              <div class="row">
                <div class="col-md-12">

                  <div class="card mb-4">
                    <h5 class="card-header">Product Details</h5> -->
                    <!-- Account -->
                    
                    <!-- <hr class="my-0" /> -->
                    <div class="card-body">
                    <div class="card">
                <h5 class="card-header">View Credit Card</h5>
                <div class="table-container">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>#SNo.</th>
                        <th>Card Number</th>
                        <th>Cvv</th>
                        <th>Expiry Date</th>
                        <th>User</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php 
                        foreach($CreditCardData as $cData){
                            
                            ?>

                            <tr>
                                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?= $cData['creditCardId'] ?></strong></td>
                                <td><?= $cData['cardNumber'] ?></td>
                                <td><?= $cData['cvv'] ?></td>
                                <td><?= $cData['expiryDate'] ?></td>
                                <td><?= $cData['user_id'] ?></td>
                                <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                    <a class="dropdown-item" href="editCreditcard.php?id=<?= $cData['creditCardId'] ?>"
                                        ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                    >
                                    <a class="dropdown-item" href="deleteCreditcard.php?id=<?= $cData['creditCardId'] ?>"
                                        ><i class="bx bx-trash me-1"></i> Delete</a
                                    >
                                    </div>
                                </div>
                                </td>
                        </tr>
                        
                      <?php }?>
                      
                    </tbody>
                  </table>
                </div>
              </div>
                    </div>
                    <!-- /Account -->
                  </div>
                  <?php  require '../partials/footer.php'  ?>
                  
                </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->

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
