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

	$e_cv     = isset($_GET["e_cv"]) ? $_GET["e_cv"] : "";
	$fc_cv    = isset($_GET["fc_cv"]) ? $_GET["fc_cv"] : "";
	$w_cv     = isset($_GET["w_cv"]) ? $_GET["w_cv"] : "";
	$ma_cv    = isset($_GET["ma_cv"]) ? $_GET["ma_cv"] : "";
	$mb_cv    = isset($_GET["mb_cv"]) ? $_GET["mb_cv"] : "";
	$mc_cv    = isset($_GET["mc_cv"]) ? $_GET["mc_cv"] : "";

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

		echo $e_cv."<br>";
		echo $fc_cv."<br>";
		echo $w_cv."<br>";
		echo $ma_cv."<br>";
		echo $mb_cv."<br>";
		echo $mc_cv."<br>";

		echo $mstat."<br>";
		echo $mstatstr."<br>";
		echo $uov."<br>";
		echo $mvmnt."<br>";
		echo $wpnsf."<br>";
		echo "<br>";

		$sql = "UPDATE asc_unitstatus SET heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w.",crit_CV_engine=".$e_cv.",crit_CV_firecontrol=".$fc_cv.",crit_CV_weapons=".$w_cv.",crit_CV_motiveA=".$ma_cv.",crit_CV_motiveB=".$mb_cv.",crit_CV_motiveC=".$mc_cv.",usedoverheat=".$uov." WHERE unitid=".$index;
		echo "Statement: " . $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record (asc_unitstatus) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_unitstatus) updating record: " . mysqli_error($conn);
		}

		$sql2 = "UPDATE asc_unit SET unit_statusimageurl='".$mstat."',unit_status='".$mstatstr."' WHERE unitid=".$index;
		echo "<br><br>UPDATE asc_unit SET unit_statusimageurl='".$mstat."',unit_status='".$mstatstr."' WHERE unitid=".$index;

		if (mysqli_query($conn, $sql2)) {
			echo "<br>";
			echo "Record (asc_unit) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_unit) updating record: " . mysqli_error($conn);
		}

		$sql3 = "UPDATE asc_assign SET round_moved=".$mvmnt.",round_fired=".$wpnsf." WHERE unitid=".$index;
		echo "UPDATE asc_assign<br>SET round_moved=".$mvmnt.",round_fired=".$wpnsf." WHERE unitid=".$index;

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
