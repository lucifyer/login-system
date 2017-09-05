<?php

// $host = 'shareddb1c.hosting.stackcp.net';
// $user = 'sampleuser';
// $password = 'wrongpassword123';
// $database = 'testdb-32300ab8';


	$host = 'localhost';
	$user = 'root';
	$password = 'incorrect';
	$database = 'testdb';

	$con = mysqli_connect($host,$user,$password,$database);

	if(mysqli_connect_error($con))
	{
		echo "Failed to connect to MySQL".mysqli_connect_error();
	}

?>
