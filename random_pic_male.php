<?php
	$dir = 'images/pilots/';
	$files = glob($dir.'m_*.png');
	$file = array_rand($files);
	echo $files[$file];
?>
