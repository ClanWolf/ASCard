<?php
	require('./config.php');
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
?>