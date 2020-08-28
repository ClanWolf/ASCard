<?php
	echo "ASCard App - caching units from MUL<br>";
	echo "-------------------------------------------<br>";
	echo date('M Y') . "<br>";
	echo "-------------------------------------------<br>";
	echo "<br>";

	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
	$context = stream_context_create($opts);

	$url_arr = array(
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&Types=21&SubTypes=28',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=20&MaxTons=20&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=25&MaxTons=25&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=30&MaxTons=30&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=35&MaxTons=35&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=40&MaxTons=40&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=45&MaxTons=45&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=50&MaxTons=50&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=55&MaxTons=55&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=60&MaxTons=60&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=65&MaxTons=65&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=70&MaxTons=70&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=75&MaxTons=75&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=80&MaxTons=80&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=85&MaxTons=85&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=90&MaxTons=90&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=95&MaxTons=95&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&MinTons=100&MaxTons=100&Types=18',

		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&Types=21&SubTypes=28',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=20&MaxTons=20&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=25&MaxTons=25&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=30&MaxTons=30&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=35&MaxTons=35&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=40&MaxTons=40&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=45&MaxTons=45&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=50&MaxTons=50&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=55&MaxTons=55&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=60&MaxTons=60&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=65&MaxTons=65&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=70&MaxTons=70&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=75&MaxTons=75&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=80&MaxTons=80&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=85&MaxTons=85&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=90&MaxTons=90&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=95&MaxTons=95&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=1&BookAuto=&FactionAuto=&MinTons=100&MaxTons=100&Types=18'
	);

	$filename_arr = array(
		'Clan_2.json',
		'Clan_20.json',
		'Clan_25.json',
		'Clan_30.json',
		'Clan_35.json',
		'Clan_40.json',
		'Clan_45.json',
		'Clan_50.json',
		'Clan_55.json',
		'Clan_60.json',
		'Clan_65.json',
		'Clan_70.json',
		'Clan_75.json',
		'Clan_80.json',
		'Clan_85.json',
		'Clan_90.json',
		'Clan_95.json',
		'Clan_100.json',

		'IS_2.json',
		'IS_20.json',
		'IS_25.json',
		'IS_30.json',
		'IS_35.json',
		'IS_40.json',
		'IS_45.json',
		'IS_50.json',
		'IS_55.json',
		'IS_60.json',
		'IS_65.json',
		'IS_70.json',
		'IS_75.json',
		'IS_80.json',
		'IS_85.json',
		'IS_90.json',
		'IS_95.json',
		'IS_100.json'
	);

	// ---------------------------------------------------

	foreach ($url_arr as $key => &$url_value) {
		// echo $url_value . "<br>";
		// echo $filename_arr[$key] . "<br>";

		$content = file_get_contents($url_value, false, $context);

		if ($content === FALSE) {
			echo "Error while saving " . $filename_arr[$key];
		} else {
			echo "Saving " . $filename_arr[$key] . "... ";
			// echo $content;
			$filename = "/var/www/vhosts/clanwolf.net/httpdocs/apps/ASCard/cache/mul/" . $filename_arr[$key];
			$fileHandle = fopen($filename, 'w');
			fwrite($fileHandle, $content);
			fclose($fileHandle);
			echo "saved.<br>";
		}
	}

	echo "<br>";
	echo "Saving cache version... ";
	$cacheversionfilename = "/var/www/vhosts/clanwolf.net/httpdocs/apps/ASCard/cache/mul/cache.version";
	$cacheversionfileHandle = fopen($cacheversionfilename, 'w');
	fwrite($cacheversionfileHandle, date('M Y'));
	fclose($cacheversionfileHandle);
	echo "saved.<br>";
?>
