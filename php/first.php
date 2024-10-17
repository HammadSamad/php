<?php 
$firstName = "Farhan";
$lastName = "Khan";
$age = 20;
echo "First Name $firstName" ."<br>";
echo "Last Name $lastName" ."<br>";
echo "$firstName"." "." $lastName". "<br>";
echo "Age $age" ."<br>";
echo 5 + 2 + true . "<br>";
echo 2 + 2 + false . "<br>";
echo "this is number of value boolean." .true . "<br>";
echo "this is number of value boolean." .false . "<br>";
echo "Hello " . true . " world. \n" ."<br>";
print("Hello " . false . " World. \n") ."<br>";
$UserName = "AHMAD RAZA";
$UserName1 = "shahid khan";
$Phone = "0323-4212342";
$city = "Multan";
echo "$UserName" ."<br>"; 
echo "$UserName1" ."<br>"; 
echo "$Phone" ."<br>";
echo "$city" ."<br>";
// echo strtolower($UserName);
// echo strtoupper($UserName1);
// echo trim($UserName, "ARZ")
// echo str_pad($UserName,12, "-");
// echo strrev($city) ."<br>";
// echo str_replace("-","", $Phone);
// echo str_shuffle($UserName1);
// echo strcmp($UserName, $UserName1) ."<br>";
// echo strcmp($UserName, $city) ."<br>";
// echo strlen($UserName) ."<br>";
// echo strpos(strtoupper($UserName),strtoupper("M") ) ."<br>";
// echo substr($UserName,0,3);
// echo substr(string: $UserName,offset: 1,length: 5)."<br>";
// $array = ["ahmad","yasir","shahid","faraz"];
// for ($i = 0; $i < 4; $i++) {
//     echo $array[$i] ."<br>";
// };
// $result = explode(separator: " ", string: $UserName);
// $result1 = explode(separator: " ", string: $UserName1);
// for($i = 0; $i < Count(value: $result); $i++){
//     echo $result[$i];
// };
// foreach($result1 as $el){
//     echo $el;
// }
// $array = ["fahad ","shahid"," ahmad"];
// $result = implode("<br>", $array);
// echo "$result" ."<br>";
$p = "Aptech Learning Center ";
echo strpos(strtoupper($p), strtoupper("g"));
// foreach($p as $elem){
//     echo $elem;
// }
// for($i = 0; $i < strlen($p); $i++){
//     echo $p;
// }
?>