<?php
	$logfilename = "logs/logfile.txt";

	if (!file_exists('logs')) {
		mkdir('logs', 0777, true);
	}

	// write a line to log
	function logMsg($msg) {
		$logfile=fopen($logfilename, "a");
		fputs($logfile,
		      date("d.m.Y, H:i:s", time()).
		      " ".
		      $msg."\n"
		);
		fclose($logfile);
	}

	// log the access to a file
	$logfile=fopen($logfilename, "a");
	fputs($logfile,
		date("d.m.Y, H:i:s", time()).
		", ".$_SERVER['REMOTE_ADDR'].
		", ".$_SERVER['REQUEST_METHOD'].
		", ".$_SERVER['PHP_SELF'].
		", ".$_SERVER['HTTP_USER_AGENT'].
		", ".$_SERVER['HTTP_REFERER']."\n"
	);
	fclose($logfile);
?>
