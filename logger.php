<?php
	// write a line to log
	function logMsg($msg) {
		$logdatei=fopen("logs/logfile.txt","a");
		fputs($logdatei,
		      date("d.m.Y, H:i:s", time()) .
		      $msg ."\n"
		);
		fclose($logdatei);
	}

	// log the access to a file
	$logdatei=fopen("logs/logfile.txt","a");
	fputs($logdatei,
		date("d.m.Y, H:i:s",time()) .
		", " . $_SERVER['REMOTE_ADDR'] .
		", " . $_SERVER['REQUEST_METHOD'] .
		", " . $_SERVER['PHP_SELF'] .
		", " . $_SERVER['HTTP_USER_AGENT'] .
		", " . $_SERVER['HTTP_REFERER'] ."\n"
	);
	fclose($logdatei);
?>
