<?php
	// ini_set('display_errors', 1);
	// ini_set('display_startup_errors', 1);
	// error_reporting(E_ALL);

	// session_start();

	if (!file_exists('logs')) {
		mkdir('logs', 0777, true);
	}

	$pid    = isset($_SESSION["playerid"]) ? filter_var($_SESSION["playerid"], FILTER_VALIDATE_INT) : "-";
	$gid    = isset($_SESSION["gameid"]) ? filter_var($_SESSION['gameid'], FILTER_VALIDATE_INT) : "-";
	$hgid   = isset($_SESSION["hostedgameid"]) ? filter_var($_SESSION['hostedgameid'], FILTER_VALIDATE_INT) : "-";

	$pre    = "[".sprintf("%3s", $pid)."|".sprintf("%3s", $gid)."|".sprintf("%3s", $hgid)."] ";

	$logfilename = "logs/ascard_logfile";
	$logfileext = ".txt";
	$log_access = true;

	// roll over
	function rollover() {
		// roll over logfile after 5 mb is reached
		global $logfilename;
		global $logfileext;

		$checkname = $logfilename.$logfileext;
		$checkname1 = $logfilename."_1".$logfileext;
		$checkname2 = $logfilename."_2".$logfileext;
		$checkname3 = $logfilename."_3".$logfileext;
		$checkname4 = $logfilename."_4".$logfileext;

		$size = filesize($logfilename.$logfileext);

		if ($size > 5242880) { // is the current logfile bigger than 5 mb
			if (file_exists($checkname4)) {
				// delete #4 if it exists
				unlink($checkname4);
			}

			if (file_exists($checkname3)) {
				// rename #3 to #4 if it exists
				rename($checkname3, $checkname4);
			}

			if (file_exists($checkname2)) {
				// rename #2 to #3 if it exists
				rename($checkname2, $checkname3);
			}

			if (file_exists($checkname1)) {
				// rename #1 to #2 if it exists
				rename($checkname1, $checkname2);
			}

			if (file_exists($checkname)) {
				// rename current file to #1 if it exists
				rename($checkname, $checkname1);
			}
		}
	}

	// write a line to log
	function logMsg($msg) {
		global $pre;

		rollover();
		$logfile = fopen($logfilename.$logfileext, "a");
		fputs($logfile,
			$pre.
			date("d.m.Y H:i:s", time()).
			" ".
			$msg."\n"
		);
		fclose($logfile);
	}

	// log the access to a file
	if ($log_access) {
		rollover();
		$logfile = fopen($logfilename.$logfileext, "a");
		if(isset($_SERVER['HTTP_REFERER'])) {
			$ref = $_SERVER['HTTP_REFERER'];
		} else {
			$ref = "no referer";
		}

		$refererStr = " ".sprintf("%15s", $_SERVER['REMOTE_ADDR']).
			" ".$_SERVER['REQUEST_METHOD'].
			" ".$_SERVER['PHP_SELF'].
			// " ".$_SERVER['HTTP_USER_AGENT'].
			" ".$ref."\n";

		fputs($logfile,
			$pre.
			date("d.m.Y H:i:s", time()).
			$refererStr
		);
		fclose($logfile);
	}
?>
