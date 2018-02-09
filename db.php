<?php
	require('./config.php');

	// Create connection
	$conn = mysqli_connect($db_host, $db_user, $db_pass);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>