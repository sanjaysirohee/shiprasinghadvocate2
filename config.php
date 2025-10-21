<?php
$baseurl = $_SERVER['SERVER_NAME'];
//echo $baseurl;
if($baseurl=='localhost')
{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shiprasinghadvocatedb";
}else{
 $servername = "localhost";
 $username = "shiprasinghadvocate_ssadb";
 $password = "uy38fyLnM7cQZHWuvjqJ";
 $dbname = "shiprasinghadvocate_ssadb";
}


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>

