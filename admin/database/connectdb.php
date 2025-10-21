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
define("USERNAME","shiprasinghadvocate_ssadb");
define("PASSWORD","uy38fyLnM7cQZHWuvjqJ");
define("DATABASE","shiprasinghadvocate_ssadb");
}

$con=new mysqli(HOSTNAME,USERNAME,PASSWORD,DATABASE) or die("Unable to connect");
?>
