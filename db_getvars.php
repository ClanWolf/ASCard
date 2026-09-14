<?php
	$repairMode = 0;
	if (isset($gid)) {
		$selectRepairMode = "SELECT * FROM asc_game WHERE gameid = ".$gid.";";
		$result_selectRepairMode = mysqli_query($conn, $selectRepairMode);
		if (mysqli_num_rows($result_selectRepairMode) > 0) {
			while($row77 = mysqli_fetch_assoc($result_selectRepairMode)) {
				$repairMode = $row77["repairActive"];
			}
		}
	}

	$currentlyAvailableSupportPoints = 48;
	// Get Support points
?>
