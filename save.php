<?php
	session_start();
	ini_set("display_errors", 1); error_reporting(E_ALL);

	require('./logger.php');
	require_once('./db.php');

	$index    = isset($_GET["index"]) ? $_GET["index"] : "";
	$h        = isset($_GET["h"]) ? $_GET["h"] : "";
	$a        = isset($_GET["a"]) ? $_GET["a"] : "";
	$s        = isset($_GET["s"]) ? $_GET["s"] : "";
	$e        = isset($_GET["e"]) ? $_GET["e"] : "";
	$fc       = isset($_GET["fc"]) ? $_GET["fc"] : "";
	$mp       = isset($_GET["mp"]) ? $_GET["mp"] : "";
	$w        = isset($_GET["w"]) ? $_GET["w"] : "";
	$mstat    = isset($_GET["mstat"]) ? $_GET["mstat"] : "";
	$mstatstr = isset($_GET["mstatstr"]) ? $_GET["mstatstr"] : "";
	$uov      = isset($_GET["uov"]) ? $_GET["uov"] : "";
	$mvmnt    = isset($_GET["mvmnt"]) ? $_GET["mvmnt"] : "";
	$wpnsf    = isset($_GET["wpnsf"]) ? $_GET["wpnsf"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING DATA...<br>";

		echo $index."<br>";
		echo $h."<br>";
		echo $a."<br>";
		echo $s."<br>";
		echo $e."<br>";
		echo $fc."<br>";
		echo $mp."<br>";
		echo $w."<br>";
		echo $mstat."<br>";
		echo $mstatstr."<br>";
		echo $uov."<br>";
		echo $mvmnt."<br>";
		echo $wpnsf."<br>";
		echo "<br>";

		$sql = "UPDATE asc_mechstatus SET heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w.",usedoverheat=".$uov." WHERE mechid=".$index;
		echo "Statement: " . $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record (asc_mechstatus) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_mechstatus) updating record: " . mysqli_error($conn);
		}

		$sql2 = "UPDATE asc_mech SET mech_statusimageurl='".$mstat."',mech_status='".$mstatstr."' WHERE mechid=".$index;
		echo "<br><br>UPDATE asc_mech SET mech_statusimageurl='".$mstat."',mech_status='".$mstatstr."' WHERE mechid=".$index;

		if (mysqli_query($conn, $sql2)) {
			echo "<br>";
			echo "Record (asc_mech) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_mech) updating record: " . mysqli_error($conn);
		}

		$sql3 = "UPDATE asc_assign SET round_moved=".$mvmnt.",round_fired=".$wpnsf." WHERE mechid=".$index;
		echo "UPDATE asc_assign<br>SET round_moved=".$mvmnt.",round_fired=".$wpnsf." WHERE mechid=".$index;

		if (mysqli_query($conn, $sql3)) {
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

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
