<?php
	require_once('./db.php');

	var $index = $_GET["index"];
	var $h = $_GET["h"];
	var $a = $_GET["a"];
	var $s = $_GET["s"];
	var $e = $_GET["e"];
	var $fc = $_GET["fc"];
	var $mp = $_GET["mp"];
	var $w = $_GET["w"];

	echo "<div style='color:yellow;'>";
	echo "SAVING MECH DATA...<br>";
	
	echo $index;
	echo $h;
	echo $a;
	echo $s;
	echo $e;
	echo $fc;
	echo $mp;
	echo $w;

	echo "</div>";

	$sql = "UPDATE clanwolf.asc_mechstatus SET heat="+$h+",armor="+$a+",structure="+$s+",crit_engine="+$e+",crit_fc="+$fc+",crit_mp="+$mp+",crit_weapons="+$w+" where mechid="+$index;
	echo $sql;

	// if (mysqli_query($conn, $sql)) {
    	// 	echo "Record updated successfully";
	// } else {
    	// 	echo "Error updating record: " . mysqli_error($conn);
	// }
?>
