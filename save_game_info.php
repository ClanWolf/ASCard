<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$gid = isset($_GET["gid"]) ? $_GET["gid"] : "";

	echo "<!DOCTYPE html>\n";
	echo "<html lang='en'>\n";
	echo "<body>\n";
	echo "<p style='font-family:Arial,sans-serif;font-size:14px;color:yellow;'>\n";

	echo "UPDATING access code ".$rndint." for game ".$gid."...<br>\n";
	echo "<br>\n";

	if (!empty($gid)) {





	}

	echo "</p>\n";
	echo "</body>\n";
	echo "</html>\n";
?>
