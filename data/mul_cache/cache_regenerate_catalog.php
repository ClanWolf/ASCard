<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	set_time_limit(600);
	ob_end_flush();
	ob_implicit_flush();

	// Delete existing CSV files
	$csvFiles = glob('/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/*.csv');
	foreach($csvFiles as $csvFile) {
		if(is_file($csvFile)) {
			echo "delete: " . $csvFile . "<br>";
			unlink($csvFile);
		}
	}

	// ---------------------------------------------------
	// Scan all JSON files in the cache directory
	$jsonFiles = glob('/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/*.json');
	
	// Define which exact filenames to include (type categories, not tonnage ranges)
	$validFilenames = array(
		'IS_BA', 'IS_CI', 'IS_LIGHT', 'IS_MEDIUM', 'IS_HEAVY', 'IS_ASSAULT', 'IS_SUPERHEAVY',
		'CLAN_BA', 'CLAN_CI', 'CLAN_LIGHT', 'CLAN_MEDIUM', 'CLAN_HEAVY', 'CLAN_ASSAULT', 'CLAN_SUPERHEAVY'
	);

	foreach ($jsonFiles as $jsonFile) {
		// Extract filename without path and extension
		$basename = basename($jsonFile, '.json');
		
		// Check if this is one of our valid filenames
		if (in_array($basename, $validFilenames)) {
			// Read the JSON file
			$content = file_get_contents($jsonFile);
			if ($content === false) {
				echo "Failed to read: " . $jsonFile . "<br>";
				continue;
			}

			$dataentry = "";
			$catalogfilename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/catalog.csv";
			$unitsJson = json_decode($content);
			foreach($unitsJson as $unitList) {
				foreach($unitList as $unit) {
					if (!empty($unit->Id) && $unit->Id > 0 && $unit->Id != "") {

						$cleanName1 = str_replace('“', '"', $unit->Name);
						$cleanName = str_replace('”', '"', $cleanName1);

						$dataentry = $dataentry.$unit->Id.";"
							.trim($cleanName).";"
							.$unit->BFType.";"
							.$unit->BFSize.";"
							.$unit->Technology->Id.";"
							.$unit->Tonnage.";"
							.$unit->BattleValue
							.PHP_EOL;
					} else {
						// $dataentry = $dataentry."FAILEDMATCH".PHP_EOL;
					}
				}
			}

			$catalogfileHandle = fopen($catalogfilename, "a");
			fwrite($catalogfileHandle, $dataentry);
			fclose($catalogfileHandle);

			echo "saved.<br>";
			flush();
		}
		echo "catalog saved.";
	}
?>
