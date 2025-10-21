<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require('./logger.php');
	require('./db.php');

	$pid = isset($_SESSION["playerid"]) ? filter_var($_SESSION["playerid"], FILTER_VALIDATE_INT) : "not found";
	$gid = isset($_SESSION["gameid"]) ? filter_var($_SESSION["gameid"], FILTER_VALIDATE_INT) : "not found";
	$gts_s = isset($_SESSION["gameTimestamp"]) ? filter_var($_SESSION["gameTimestamp"], FILTER_VALIDATE_INT) : "not found";

	if ($pid === "not found") {
		echo "LOGIN EXPIRED. REDIRECT TO LOGIN...<br>\n";
		echo "<script>top.location.assign('./login.php?auto=1');</script>";
	}

	$cts=time();

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<head>\n";
	echo "	<title>ASCard Server poll</title>\n";
	//echo "	<meta http-equiv='refresh' content='2'>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "	<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

	echo "pid: ".$pid." --- ";

	$currentGameId = -1;
    $sql_currentGame = "SELECT SQL_NO_CACHE gameid FROM asc_player WHERE playerid=".$pid.";";
    $result_currentGame = mysqli_query($conn, $sql_currentGame);
    if (mysqli_num_rows($result_currentGame) > 0) {
        while($rowCurrentGame = mysqli_fetch_assoc($result_currentGame)) {
            $currentGameId = $rowCurrentGame["gameid"];
        }
    }
    mysqli_free_result($result_currentGame);

    $sql_currentGameTimestamp = "SELECT SQL_NO_CACHE Updated FROM asc_game WHERE gameid=".$currentGameId.";";
    $result_currentGameTimestamp = mysqli_query($conn, $sql_currentGameTimestamp);
    if (mysqli_num_rows($result_currentGameTimestamp) > 0) {
        while($rowCurrentGameTimestamp = mysqli_fetch_assoc($result_currentGameTimestamp)) {
            $gts_d = strtotime($rowCurrentGameTimestamp["Updated"]);
        }
    }
    mysqli_free_result($result_currentGameTimestamp);

	echo "gid: ".$gid." (session) / ".$currentGameId." (db)<br>\n";
	echo "".$gts_s." gts_s (session)<br>\n";
	echo "".$gts_d." gts_d (db)<br>\n";
	echo "".$cts." cts (now)<br>\n";

	if ($gid == 0) {
		$_SESSION['gameid'] = $currentGameId;
		//echo "<script>alert('A game has been created for you!');</script>\n";
		echo "<script>top.window.location = './gui_message_game_created.php'</script>\n";
	}

	if ($gid != 0 && $gid != $currentGameId) {
		// The gameid from the db and in the current session are not the same
		// The logged in user might have been kicked from a game!

		// Set the gameid in the session to the id that came from the database
		$_SESSION['gameid'] = $currentGameId;
		//echo ("<script>alert('Changed game id to ".$currentGameId."');</script>");
		echo "<script>top.window.location = './gui_message_game_removed.php'</script>\n";
	}

	if ($gts_d > $gts_s) {
		$_SESSION["gameTimestamp"] = $gts_d;

		//echo "<script>alert('new game found, refresh!');</script>\n";
		echo "<script>top.location.reload();</script>";
	}

	echo "	</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
