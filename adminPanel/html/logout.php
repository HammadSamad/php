<?php 

session_name('adminPanel');
    session_start();

    session_destroy();

    header('location:auth-login-basic.php');
    

?>