<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gameToJoinId = isset($_GET["gameToJoinId"]) ? filter_var($_GET["gameToJoinId"], FILTER_VALIDATE_INT) : "";
	$playerId     = isset($_GET["playerId"]) ? filter_var($_GET["playerId"], FILTER_VALIDATE_INT) : "";
	$accessCode   = isset($_GET["accessCode"]) ? filter_var($_GET["accessCode"], FILTER_VALIDATE_INT) : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "UPDATING set status for player ".$playerId." (joining game) ".$gameToJoinId."<br>\n";
	echo "<br>\n";

	echo "Game to join: ".$gameToJoinId."<br>\n";
	echo "PlayerId:     ".$playerId."<br>\n";
	echo "AccessCode:   ".$accessCode."<br>\n";

	if (!empty($gameToJoinId) && !empty($playerId) && !empty($accessCode)) {

		// Select accessCode from the target game
		$sql_asc_accesscode = "SELECT SQL_NO_CACHE accessCode FROM asc_game where gameid=".$gameToJoinId.";";
		$result_asc_accesscode = mysqli_query($conn, $sql_asc_accesscode);
		if (mysqli_num_rows($result_asc_accesscode) > 0) {
			while($row333 = mysqli_fetch_assoc($result_asc_accesscode)) {
				$foundAccessCode = $row333["accessCode"];
			}
		}
		mysqli_free_result($result_asc_accesscode);

		if ($foundAccessCode == $accessCode) {
			$update_player = "UPDATE asc_player SET gameid = ".$gameToJoinId." WHERE playerid=".$playerId;
			if (mysqli_query($conn, $update_player)) {
				echo "<br>";
				echo "Player gameId updated successfully<br>";





				// TODO: Call round_reset to get all unitstatus to the new gameid and round
				echo "<script>\n";
				echo "	top.location.reload();\n";
				echo "</script>\n";





			} else {
				echo "<br>";
				echo "Error updating player gameId: " . mysqli_error($conn) . "<br>";
			}
		} else {
			echo "<br>";
			echo "Accesscode does not match<br>";
			echo "<script>top.window.location = './gui_message_joingame_error_01.php'</script>\n";
		}
	} else {
		echo "<br>";
		echo "No accesscode<br>";
		echo "<script>top.window.location = './gui_message_joingame_error_01.php'</script>\n";
	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
