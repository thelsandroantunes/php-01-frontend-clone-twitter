<?php

	/*ob_start();
	session_start();
	
	$timezone = date_default_timezone_set("America/Manaus");
	$con = mysqli_connect("localhost","root","","twitter");

	if (mysqli_connect_errno())
	{
		echo "Falha na conexão:".mysqli_connect_errno();
	}*/

	$dsn = 'mysql:host=localhost;dbname=twitter';
	$user = 'root';
	$pass = '';

	try
	{
		$pdo = new PDO($dsn, $user, $pass);
	}
	catch(PDOExceptio $e)
	{
		echo 'Falha na conexão ' . $e0>getMessage();
	}



?>