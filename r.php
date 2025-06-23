
<?php
	$formation = isset($_GET["f"]) ? $_GET["f"] : 1;
	$unit = isset($_GET["u"]) ? $_GET["u"] : -1;
	$codax = isset($_GET["c"]) ? $_GET["c"] : -1;

	if ($formation > 0 && $unit > 0) {
		header("Location: https://www.ascard.net/app/gui_play_unit.php?formationid=".$formation."&chosenunit=".$unit."");
    	die();
	}

	if ($codax > 0) {
		header("Location: https://www.clanwolf.net/viewpage.php?page_id=6&ID=".$codax."");
    	die();
	}
?>
