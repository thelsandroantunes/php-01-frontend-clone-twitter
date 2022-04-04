<?php 

	include("database/connection.php");
	include("classes/User.php");
	include("classes/Follow.php");
	include("classes/Tweet.php");
	
	global $pdo;

	session_start();

	$getFromU = new User($pdo);
	$getFromF = new Follow($pdo);
	$getFromT = new Tweet($pdo);
	
	define("BASE_URL", "http://localhost/WebDeveloper/Twitter-Clone/");
?>