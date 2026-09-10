<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();
	// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	require('./db.php');

	if (
		(isset($_SESSION['playerid']) && $_SESSION['playerid'] > 0) &&
		(isset($_SESSION['gameid']) && $_SESSION['gameid'] > 0) &&
		(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 1)
	 ) {
		// playerid and gameid are present and set, continue
		logMsg("playerid: ".$_SESSION['playerid']);
		logMsg("gameid: ".$_SESSION['gameid']);
		logMsg("isAdmin: ".$_SESSION['isAdmin']);
	} else {
		header("Location: ./login.php?auto=1");
		logMsg("No admin privileges, rejected!");
		logMsg("Not logged in... redirecting.");
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_games'])) {
		if (isset($_POST['game_ids']) && is_array($_POST['game_ids'])) {
			foreach ($_POST['game_ids'] as $gameid) {
				$gameid               = (int)$gameid;
				$lockedVal            = isset($_POST['locked'][$gameid]) ? 1 : 0;
				$showInScoreboardVal  = isset($_POST['showInScoreboard'][$gameid]) ? 1 : 0;
				$repairActiveVal      = isset($_POST['repairActive'][$gameid]) ? 1 : 0;
				// $finishedVal          = isset($_POST['finished'][$gameid]) ? 1 : 0;

				$updateSQL  = "UPDATE asc_game SET locked = $lockedVal, ";
				$updateSQL .= "   showInScoreboard = $showInScoreboardVal, ";
				$updateSQL .= "   repairActive = $repairActiveVal ";
				// $updateSQL .= "   finished = $finishedVal ";
				$updateSQL .= "WHERE gameid = $gameid";

				mysqli_query($conn, $updateSQL);
			}
			echo "<p style='color: green; font-weight: bold;'>Änderungen erfolgreich gespeichert!</p>";
		}
	}

	echo "<form action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' method='POST'>";
	echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
	echo "<tr>\n";
	echo "<th>ID</th>\n";
	echo "<th>Titel</th>\n";
	echo "<th>Locked</th>\n";
	echo "<th>In Scoreboard</th>\n";
	echo "<th>Repair Active</th>\n";
	// echo "<th>Finished</th>\n";
	echo "</tr>\n";

	$selectGames = "SELECT * FROM asc_game ORDER BY gameid ASC;";
	$result_selectGames = mysqli_query($conn, $selectGames);

	if (mysqli_num_rows($result_selectGames) > 0) {
		while($row77 = mysqli_fetch_assoc($result_selectGames)) {
			$gameid           = $row77["gameid"];
			$gametitle        = $row77["title"];
			$locked           = $row77["locked"];
			$showInScoreboard = $row77["showInScoreboard"];
			$repairActive     = $row77["repairActive"];
			$finished         = $row77["finished"];

			$lockedChecked           = ($locked == 1) ? "checked" : "";
			$showInScoreboardChecked = ($showInScoreboard == 1) ? "checked" : "";
			$repairActiveChecked     = ($repairActive == 1) ? "checked" : "";
			$finishedChecked         = ($finished == 1) ? "checked" : "";

			echo "<tr>\n";
			echo "<td>".$gameid."<input type='hidden' name='game_ids[]' value='".$gameid."'></td>\n";
			echo "<td>".htmlspecialchars($gametitle)."</td>\n";

			echo "<td align='center'><input type='checkbox' name='locked[".$gameid."]' value='1' ".$lockedChecked."></td>\n";
			echo "<td align='center'><input type='checkbox' name='showInScoreboard[".$gameid."]' value='1' ".$showInScoreboardChecked."></td>\n";
			echo "<td align='center'><input type='checkbox' name='repairActive[".$gameid."]' value='1' ".$repairActiveChecked."></td>\n";
			// echo "<td align='center'><input type='checkbox' name='finished[".$gameid."]' value='1' ".$finishedChecked."></td>\n";
			echo "</tr>\n";
		}
	}

	echo "</table>";
	echo "<br><button type='submit' name='save_games'>Änderungen speichern</button>";
	echo "</form>";
?>
