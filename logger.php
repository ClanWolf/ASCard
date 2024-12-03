<?php
	if (!file_exists('logs')) {
		mkdir('logs', 0777, true);
	}

	// write a line to log
	function logMsg($msg) {
		$logfilename = "logs/logfile.txt";
		$logfile=fopen($logfilename, "a");
		fputs($logfile,
			date("d.m.Y, H:i:s", time()).
			" ".
			$msg."\n"
		);
		fclose($logfile);
	}

	// log the access to a file
	$logfilename = "logs/logfile.txt";
	$logfile=fopen($logfilename, "a");
	if(isset($_SERVER['HTTP_REFERER'])) {
		$ref = $_SERVER['HTTP_REFERER'];
	} else {
		$ref = "no referer";
	}
	fputs($logfile,
		date("d.m.Y, H:i:s", time()).
		", ".$_SERVER['REMOTE_ADDR'].
		", ".$_SERVER['REQUEST_METHOD'].
		", ".$_SERVER['PHP_SELF'].
		", ".$_SERVER['HTTP_USER_AGENT'].
		", ".$ref."\n"
	);
	fclose($logfile);
?>
