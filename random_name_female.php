<?php
	$f_contents = file("data/names/names_female.lst");
	$line = $f_contents[array_rand($f_contents)];
	$data = $line;
	echo $data;
?>
