<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$index = isset($_GET["index"]) ? $_GET["index"] : "";
	$mvmt  = isset($_GET["mvmt"]) ? $_GET["mvmt"] : "";
	$wpns  = isset($_GET["wpns"]) ? $_GET["wpns"] : "";

	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING DATA...<br>";

		echo $index;
		echo $mvmt;
		echo $wpns;
		echo "<br>";

		$sql = "UPDATE asc_assign SET round_moved=".$mvmt.",round_fired=".$wpns." WHERE mechid=".$index;
		echo "UPDATE asc_assign<br>SET round_moved=".$mvmt.",round_fired=".$wpns." WHERE mechid=".$index;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record (asc_assign) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_assign) updating record: " . mysqli_error($conn);
		}
	} else {
		echo "WAITING FOR SAVE OPERATION...<br>";
	}

	echo "</p>";
?>
