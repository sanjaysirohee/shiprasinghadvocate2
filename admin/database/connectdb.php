<?php

$baseurl = $_SERVER['SERVER_NAME'];
if($baseurl=='localhost')
{
define("HOSTNAME","localhost");
define("USERNAME","root");
define("PASSWORD","");
define("DATABASE","shiprasinghadvocatedb");
}else{
define("HOSTNAME","localhost");
define("USERNAME","veloxnc1_veloxndbun");
define("PASSWORD","india@vbd121");
define("DATABASE","veloxnc1_veloxndb");
}

$con=new mysqli(HOSTNAME,USERNAME,PASSWORD,DATABASE) or die("Unable to connect");
?>
