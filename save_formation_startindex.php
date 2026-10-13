<?php

	//	ini_set('display_errors', 1);
	//	ini_set('display_startup_errors', 1);
	//	error_reporting(E_ALL);

	date_default_timezone_set('Europe/Berlin');

	session_start();

	require('./logger.php');
	require_once('./db.php');

	$formationid  = isset($_GET["formationid"]) ? (int)$_GET["formationid"] : 0;
	$currentindex = isset($_GET["currentindex"]) ? (int)$_GET["currentindex"] : 0;
	$op           = isset($_GET["op"]) ? $_GET["op"] : "none";

	// echo "FormationId:  ".$formationid."<br>\n";
	// echo "CurrentIndex: ".$currentindex."<br>\n";
	// echo "Operation:    ".$op."<br>\n";

	if (!empty($formationid) && !empty($currentindex)) {
		$newindex = $currentindex;
		if ($op === "up") {
			$newindex++;
		} else if ($op === "down") {
			$newindex--;
		}
		if ($newindex < 0) $newindex = 0;

		$stmt = $conn->prepare("UPDATE asc_formation SET startindex=? WHERE formationid=?");
		$stmt->bind_param("ii", $newindex, $formationid);
		$ok = $stmt->execute();

		header('Content-Type: application/json');

		if ($ok && $stmt->affected_rows > 0) {
			// Success - return only JSON, no page reload
			echo json_encode(['status' => 'ok', 'newindex' => $newindex]);
		} else {
			http_response_code(500);
			logMsg("FormationStartIndex save failed: fid=$formationid new=$newindex");
			echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
		}
	}
?>
