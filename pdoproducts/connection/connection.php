<?php

define("dsn","mysql:local=localhost;dbname=database1");
define("userName","root");
define("password","");

try {
    $connection = new PDO(dsn,userName,password);

} 
catch (PDOException $e) {
    echo $e->getMessage();
}










