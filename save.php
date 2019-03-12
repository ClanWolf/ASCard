<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);
	require_once('./db.php');

	$index = isset($_GET["index"]) ? $_GET["index"] : "";
	$h     = isset($_GET["h"]) ? $_GET["h"] : "";
	$a     = isset($_GET["a"]) ? $_GET["a"] : "";
	$s     = isset($_GET["s"]) ? $_GET["s"] : "";
	$e     = isset($_GET["e"]) ? $_GET["e"] : "";
	$fc    = isset($_GET["fc"]) ? $_GET["fc"] : "";
	$mp    = isset($_GET["mp"]) ? $_GET["mp"] : "";
	$w     = isset($_GET["w"]) ? $_GET["w"] : "";
	$mstat = isset($_GET("mstat"]) ? $_GET["mstat" : "";

	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING DATA...<br>";

		echo $index;
		echo $h;
		echo $a;
		echo $s;
		echo $e;
		echo $fc;
		echo $mp;
		echo $w;
		echo $mstat;
		echo "<br>";

		$sql = "UPDATE asc_mechstatus SET heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w." WHERE mechid=".$index;
		echo "UPDATE asc_mechstatus<br>SET heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w." WHERE mechid=".$index;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record updated successfully";

			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error updating record: " . mysqli_error($conn);
		}
	} else {
		echo "WAITING FOR SAVE OPERATION...<br>";
	}

	echo "</p>";
?>
