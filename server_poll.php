<?php

//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require('./db.php');

	$pid = isset($_SESSION["playerid"]) ? filter_var($_SESSION["playerid"], FILTER_VALIDATE_INT) : "(not found)";
	$gid = isset($_SESSION["gameid"]) ? filter_var($_SESSION["gameid"], FILTER_VALIDATE_INT) : "(not found)";
	$gts_s = isset($_SESSION["gameTimestamp"]) ? filter_var($_SESSION["gameTimestamp"], FILTER_VALIDATE_INT) : "(not found)";

	date_default_timezone_set('Europe/Berlin');
	$cts=time();

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<head>\n";
	echo "	<title>ASCard Server poll</title>\n";
	echo "	<meta http-equiv='refresh' content='2'>\n";
	echo "</head>\n";
	echo "<body>\n";
	echo "	<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>";

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

	echo "pid: ".$pid."<br>\n";
	echo "gid: ".$gid."/".$currentGameId."<br>\n";
	echo "".$gts_s." gts_s (session)<br>\n";
	echo "".$gts_d." gts_d (db)<br>\n";
	echo "".$cts." cts (now)<br>\n";

	echo "	</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
