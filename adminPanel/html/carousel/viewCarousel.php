



<?php require '../connection/connection.php' ?>



<?php
 session_name('adminPanel');
session_start();
if(!isset($_SESSION['apUserId']))
{
	header("location:../auth-login-basic.php");
}

$viewCarousel = "SELECT * FROM `slider`";
$viewPrepare = $connect->prepare($viewCarousel);
$viewPrepare->execute();
$viewData = $viewPrepare->fetchAll(PDO::FETCH_ASSOC);

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

    <title>View Carousel</title>

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

.ratio{
  aspect-ratio: 8/4;
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
                    <h5 class="card-header">View Carousel</h5>
                    <!-- Account -->
                    
                    <hr class="my-0" />
                    <div class="card-body">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($viewData as $index => $data) { ?>
            <li data-bs-target="#carouselExample" data-bs-slide-to="<?= $index ?>" class="<?= $index == 0 ? 'active' : '' ?>"></li>
        <?php } ?>
    </ol>

    <!-- Carousel inner -->
    <div class="carousel-inner">
        <?php foreach ($viewData as $index => $data) { ?>
            <div class="carousel-item <?= $index == 0 ? 'active' : '' ?>">
                <img class="d-block w-100 ratio" src="../images/<?= $data['slider_image'] ?>" alt="Slide <?= $index + 1 ?>" />
                <div class="carousel-caption d-none d-md-block">
                    <h3><?= htmlspecialchars($data['first_text']) ?></h3>
                    <p><?= htmlspecialchars($data['second_text']) ?></p>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Controls -->
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </a>
</div>
<?php if($viewData) { ?>
  <a href="deleteCarousel.php?id=<?= $data['slider_id'] ?>" onclick="return confirm('Are you sure you want to delete this image?')" class="btn btn-icon btn-primary w-25 mt-2" style="color: white"><span class="bx bx-trash"></span> &nbsp; Delete</a>
<?php } ?>
</div>
</div>
<!-- /Account -->
                  
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
