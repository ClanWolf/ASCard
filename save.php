<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$pid = $_SESSION['playerid'];

	$index     = isset($_GET["index"]) ? $_GET["index"] : "";
	$h         = isset($_GET["h"]) ? $_GET["h"] : "";
	$a         = isset($_GET["a"]) ? $_GET["a"] : "";
	$s         = isset($_GET["s"]) ? $_GET["s"] : "";
	$e         = isset($_GET["e"]) ? $_GET["e"] : "";
	$fc        = isset($_GET["fc"]) ? $_GET["fc"] : "";
	$mp        = isset($_GET["mp"]) ? $_GET["mp"] : "";
	$w         = isset($_GET["w"]) ? $_GET["w"] : "";

	$e_cv      = isset($_GET["e_cv"]) ? $_GET["e_cv"] : "";
	$fc_cv     = isset($_GET["fc_cv"]) ? $_GET["fc_cv"] : "";
	$w_cv      = isset($_GET["w_cv"]) ? $_GET["w_cv"] : "";
	$ma_cv     = isset($_GET["ma_cv"]) ? $_GET["ma_cv"] : "";
	$mb_cv     = isset($_GET["mb_cv"]) ? $_GET["mb_cv"] : "";
	$mc_cv     = isset($_GET["mc_cv"]) ? $_GET["mc_cv"] : "";

	$mstat     = isset($_GET["mstat"]) ? $_GET["mstat"] : "";
	$mstatstr  = isset($_GET["mstatstr"]) ? $_GET["mstatstr"] : "";
	$uov       = isset($_GET["uov"]) ? $_GET["uov"] : "";
	$mvmnt     = isset($_GET["mvmnt"]) ? $_GET["mvmnt"] : "";
	$wpnsf     = isset($_GET["wpnsf"]) ? $_GET["wpnsf"] : "";

	$currRound = isset($_GET["currentRound"]) ? $_GET["currentRound"] : "";

	$narc      = isset($_GET["narc"]) ? $_GET["narc"] : "";
	$tag       = isset($_GET["tag"]) ? $_GET["tag"] : "";
	$water     = isset($_GET["water"]) ? $_GET["water"] : "";
	$routed    = isset($_GET["routed"]) ? $_GET["routed"] : "";

	$gameid    = isset($_GET["gameid"]) ? $_GET["gameid"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	if (!empty($index)) {
		echo "SAVING DATA...<br>";

		echo "CurrentRound: ".$currRound;

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
		echo $narc."<br>";
		echo $tag."<br>";
		echo $water."<br>";
		echo $routed."<br>";
		echo "<br>";

		$sql = "UPDATE asc_unitstatus SET unit_statusimageurl='".$mstat."',unit_status='".$mstatstr."',heat=".$h.",armor=".$a.",structure=".$s.",crit_engine=".$e.",crit_fc=".$fc.",crit_mp=".$mp.",crit_weapons=".$w.",crit_CV_engine=".$e_cv.",crit_CV_firecontrol=".$fc_cv.",crit_CV_weapons=".$w_cv.",crit_CV_motiveA=".$ma_cv.",crit_CV_motiveB=".$mb_cv.",crit_CV_motiveC=".$mc_cv.",usedoverheat=".$uov.",active_narc=".$narc.", active_tag=".$tag.", active_water=".$water.", active_routed=".$routed." WHERE unitid=".$index." AND round=".$currRound." AND gameid=".$gameid.";";
		echo "Statement: " . $sql;

		if (mysqli_query($conn, $sql)) {
			echo "<br>";
			echo "Record unitstatus updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error unitstatus updating record: " . mysqli_error($conn);
		}

//		$sql2 = "UPDATE asc_unit SET unit_statusimageurl='".$mstat."',unit_status='".$mstatstr."' WHERE unitid=".$index;
//		echo "Statement 2: " . $sql2;
//
//		if (mysqli_query($conn, $sql2)) {
//			echo "<br>";
//			echo "Record (asc_unit) updated successfully";
//			mysqli_commit($conn);
//		} else {
//			echo "<br>";
//			echo "Error (asc_unit) updating record: " . mysqli_error($conn);
//		}

		$sql3 = "UPDATE asc_assign SET round_moved=".$mvmnt.",round_fired=".$wpnsf." WHERE unitid=".$index;
		echo "Statement: " . $sql3;

		if (mysqli_query($conn, $sql3)) {
			echo "<br>";
			echo "Record (asc_assign) updated successfully";
			mysqli_commit($conn);
		} else {
			echo "<br>";
			echo "Error (asc_assign) updating record: " . mysqli_error($conn);
		}

		// Check if all units are destroyed
		$sql4 = "SELECT SQL_NO_CACHE * FROM asc_unitstatus WHERE playerid=".$pid." AND active_bid=1 AND gameid=".$gameid." AND round=".$currRound." AND unit_status NOT LIKE '%destroyed%'";
		echo "Statement: " . $sql4;
		$result4 = mysqli_query($conn, $sql4);
		if (mysqli_num_rows($result4) > 0) {
			// There are units left that are not destroyed so the player is still in game
			$sql7 = "UPDATE asc_player SET active_ingame=1 WHERE playerid=".$pid;
			echo "Statement: " . $sql7;

			if (mysqli_query($conn, $sql7)) {
				echo "<br>";
				echo "Record (player active in game) updated successfully";
				mysqli_commit($conn);
			} else {
				echo "<br>";
				echo "Error (player active in game) updating record: " . mysqli_error($conn);
			}
		} else {
			// All units of this player in this game have been destroyed
			$sql5 = "UPDATE asc_player SET active_ingame=0 WHERE playerid=".$pid;
			echo "Statement: " . $sql5;

			if (mysqli_query($conn, $sql5)) {
				echo "<br>";
				echo "Record (player active in game) updated successfully";
				mysqli_commit($conn);
			} else {
				echo "<br>";
				echo "Error (player active in game) updating record: " . mysqli_error($conn);
			}
		}
	} else {
		echo "WAITING FOR SAVE OPERATION...<br>";
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
