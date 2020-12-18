<?php
	$dir = 'images/pilots/';
	$files = glob($dir.'f_*.png');
	$file = array_rand($files);
	echo $files[$file];
?>
