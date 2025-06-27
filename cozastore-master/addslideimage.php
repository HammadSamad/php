<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/feather/feather.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../../vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" type="text/css" href="../../js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png"/>
</head>
<body>
    
<div class="container-scroller">
  <!-- partial:partials/_navbar.php -->
  <?php
  //  require "../partials/_navbar.php" 
   ?>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">
    <!-- partial:partials/_settings-panel.php -->
    <?php
    //  require "../partials/_settings-panel.php" 
     ?>
    <!-- partial -->
    <!-- partial:partials/_sidebar.php -->
    <?php
    //  require "../partials/_sidebar.php" 
     ?>
    <!-- partial -->
     <!-- connection -->
      <!-- connection: connection/connection.php -->
<?php require "connection/connection.php" ?>
<!-- connection -->

<?php

if(isset($_POST['btn']))
{
  $firstText = $_POST['firstText'];
  $secondText = $_POST['secondText'];
  $sliderImage = $_FILES['slider_image'];


  if ($sliderImage['size'] < 5000000) {
    $ext = explode('.', $sliderImage['name']);
    $ext = $ext[1];
    $imageUniqueName = uniqid();
    $imageName = $imageUniqueName. '.'. $ext;
    move_uploaded_file($sliderImage['tmp_name'],'images/' . $imageName);
  
  
$insertQuery = "INSERT INTO `slider` (`slider_image`,`first_text`,`second_text`) VALUES (:imageName,:first_text,:second_text)";

$insertPrepare = $connect->prepare($insertQuery);

$insertPrepare->bindParam(':first_text', $firstText,PDO::PARAM_STR);
$insertPrepare->bindParam(':second_text', $secondText,PDO::PARAM_STR);
$insertPrepare->bindParam(':imageName', $imageName,PDO::PARAM_STR);


if($insertPrepare->execute()){
  echo "<script>alert('Slide added successfully')</script>";
}

}

else{
  echo "<script>alert('Image size should be less than 5MB')</script>";
}

}


?>

     <div class="container">
      <div class="row">
    <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add Product</h4>
                  <p class="card-description">
                  Add Product
                  </p>
                  <form class="forms-sample" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="exampleInputName1">Slider Text</label>
                      <input type="text" class="form-control" id="exampleInputName1" placeholder="Product Name" name="firstText">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Slider Text</label>
                      <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Product Price" name="secondText">
                    <div class="form-group">
                      <label>Slider Image upload</label>
                      <input type="file" name="slider_image" class="file-upload">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button  class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="btn">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- partial -->
          
        </div>

<!-- plugins:js
<script src="../../vendors/js/vendor.bundle.base.js"></script>
  <-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../vendors/chart.js/Chart.min.js"></script>
  <script src="../../vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="../../vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="../../js/dataTables.select.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/settings.js"></script>
  <script src="../../js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <script src="../../js/Chart.roundedBarCharts.js"></script>
  <!-- End custom js for this page-->

</body>
</html>






