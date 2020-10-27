<?php
	$db_host = "localhost";
	$db_username = "cheminvuser";
	$db_pass = "BEXaCom4";
	$db_name = "cheminv";

	$con=mysqli_connect($db_host, $db_username, $db_pass) or die ("Could not connect connect to MySQL Server");
	mysqli_select_db($con, $db_name) or die ("No database");
	mysqli_set_charset($con, 'utf8');
