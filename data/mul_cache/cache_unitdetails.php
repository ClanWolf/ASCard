<?php
//	echo "ASCard App - caching unit details from MUL<br>";
//	echo "-------------------------------------------<br>";
//	echo date('M Y') . "<br>";
//	echo "-------------------------------------------<br>";
//	echo "<br>";
//
//	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
//	$context = stream_context_create($opts);
//
//	for ($i = 9600; $i <= 9800; $i++ ) {
//        $url_value = "http://www.masterunitlist.info/Unit/QuickDetails?id=" . $i;
//		$content = file_get_contents($url_value, false, $context);
//
//		echo $url_value . ": ";
//
//		if ($content === FALSE) {
//			echo "Error while saving.";
//			echo "<br>";
//		} else {
//			echo "Saving " . $filename_arr[$key] . "... ";
//			// echo $content;
//			$filename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/unitdetails/" . $i . ".json";
//			$fileHandle = fopen($filename, 'w');
//			fwrite($fileHandle, $content);
//			fclose($fileHandle);
//			echo "saved.<br>";
//		}
//	}
?>

<?php
	echo "ASCard App - caching unit details from MUL<br>";
	echo "-------------------------------------------<br>";
	echo date('M Y') . "<br>";
	echo "-------------------------------------------<br>";
	echo "<br>";

	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
	$context = stream_context_create($opts);

    $index = intval($_GET["startindex"]);
	for ($i = $index; $i <= $index+200; $i++ ) {
        $url_value = "http://www.masterunitlist.info/Unit/QuickDetails?id=" . $i;
		$content = file_get_contents($url_value, false, $context);

		echo $url_value . ": ";

		if ($content === FALSE) {
			echo "Error while saving.";
			echo "<br>";
		} else {
			echo "Saving " . $filename_arr[$key] . "... ";
			// echo $content;
			$filename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/unitdetails/" . $i . ".json";
			$fileHandle = fopen($filename, 'w');
			fwrite($fileHandle, $content);
			fclose($fileHandle);
			echo "saved.<br>";
		}
	}
?>