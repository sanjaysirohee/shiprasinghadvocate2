<?php
	error_reporting(E_ALL);
	error_reporting(0);
	session_start();
	date_default_timezone_set("Asia/Kolkata");
	define('APP_NAME','AdoPremium');
	define('PROJECT_FOLDER_NAME','/');
	define('ROOT', $_SERVER['DOCUMENT_ROOT']. PROJECT_FOLDER_NAME) ;  // document path while upload on server
	define("BASE_URL","https://" . $_SERVER['HTTP_HOST'].PROJECT_FOLDER_NAME);  // base url for front

	define('BASE_ADMIN_URL', BASE_URL.'admin/');

	define('LOGO', BASE_URL.'assets/images/logo.png');

	/* Server  */
	define('DB_DATABASE','sarojk7j_saroj');
	define('DB_USERNAME','sarojk7j_saroj');
	define('DB_PASSWORD','Saroj##123$');
	/*  local */
// 	define('DB_DATABASE','gunam');
// 	define('DB_USERNAME','root');
// 	define('DB_PASSWORD','');


	include ("phpmailer/class.phpmailer.php");

	include_once(ROOT.'connection.php');
	include_once(ROOT.'function.php');

	// $resultsPerPage = 12;


?>