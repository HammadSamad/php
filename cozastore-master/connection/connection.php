<?php 

define("dsn","mysql:host=localhost;dbname=shoppingcart");
define("username","root");
define("password","");

try{
    $connect = new PDO(dsn,username,password);
}
catch(PDOException $e){
    echo $e->getMessage();
}

