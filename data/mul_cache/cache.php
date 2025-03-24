<?php

//	error_reporting(E_ALL);
//	ini_set('error_reporting', E_ALL);

	set_time_limit(600);
	ob_end_flush();
	ob_implicit_flush();

	echo "ASCard App - caching units from MUL<br>";
	echo "-------------------------------------------<br>";
	echo date('M Y') . "<br>";
	echo "-------------------------------------------<br>";
	echo "<br>";

	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
	$context = stream_context_create($opts);

	// Some Units have Technologies=3 (like the Wulfen) --> "Mixed". Technology needs to check for 2,3 for Clan and 1,3 for IS, 57 for Primitive
	// Types=18: BMs
	// Types=19: CV, Combat vehicles / Tanks
	// http://www.masterunitlist.info/Unit/Quicklist?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=30&MaxTons=30&Types=18

	$url_arr = array(
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&Types=21&SubTypes=28',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=20&MaxTons=20&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=25&MaxTons=25&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=30&MaxTons=30&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=35&MaxTons=35&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=40&MaxTons=40&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=45&MaxTons=45&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=50&MaxTons=50&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=55&MaxTons=55&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=60&MaxTons=60&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=65&MaxTons=65&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=70&MaxTons=70&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=75&MaxTons=75&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=80&MaxTons=80&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=85&MaxTons=85&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=90&MaxTons=90&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=95&MaxTons=95&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=100&MaxTons=100&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=105&MaxTons=105&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=110&MaxTons=110&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=115&MaxTons=115&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=120&MaxTons=120&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=125&MaxTons=125&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=130&MaxTons=130&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=135&MaxTons=135&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=140&MaxTons=140&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=145&MaxTons=145&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=150&MaxTons=150&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=155&MaxTons=155&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=160&MaxTons=160&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=165&MaxTons=165&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=170&MaxTons=170&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=175&MaxTons=175&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=180&MaxTons=180&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=185&MaxTons=185&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=190&MaxTons=190&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=195&MaxTons=195&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=200&MaxTons=200&Types=17&Types=18&Types=19',

		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&Types=21&SubTypes=28',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=2&Technologies=3&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=17',



		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&Types=21&SubTypes=28',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=20&MaxTons=20&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=25&MaxTons=25&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=30&MaxTons=30&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=35&MaxTons=35&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=40&MaxTons=40&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=45&MaxTons=45&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=50&MaxTons=50&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=55&MaxTons=55&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=60&MaxTons=60&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=65&MaxTons=65&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=70&MaxTons=70&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=75&MaxTons=75&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=80&MaxTons=80&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=85&MaxTons=85&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=90&MaxTons=90&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=95&MaxTons=95&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=100&MaxTons=100&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=105&MaxTons=105&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=110&MaxTons=110&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=115&MaxTons=115&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=120&MaxTons=120&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=125&MaxTons=125&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=130&MaxTons=130&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=135&MaxTons=135&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=140&MaxTons=140&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=145&MaxTons=145&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=150&MaxTons=150&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=155&MaxTons=155&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=160&MaxTons=160&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=165&MaxTons=165&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=170&MaxTons=170&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=175&MaxTons=175&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=180&MaxTons=180&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=185&MaxTons=185&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=190&MaxTons=190&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=195&MaxTons=195&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=200&MaxTons=200&Types=17&Types=18&Types=19',

		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&Types=21&SubTypes=28',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=17&Types=18&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=18',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=19',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=20&MaxTons=35&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=40&MaxTons=55&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=60&MaxTons=75&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=80&MaxTons=100&Types=17',
		'http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Technologies=1&Technologies=3&Technologies=57&BookAuto=&FactionAuto=&MinTons=105&MaxTons=200&Types=17'
	);

	$filename_arr = array(
		'CLAN_2',
		'CLAN_20',
		'CLAN_25',
		'CLAN_30',
		'CLAN_35',
		'CLAN_40',
		'CLAN_45',
		'CLAN_50',
		'CLAN_55',
		'CLAN_60',
		'CLAN_65',
		'CLAN_70',
		'CLAN_75',
		'CLAN_80',
		'CLAN_85',
		'CLAN_90',
		'CLAN_95',
		'CLAN_100',
		'CLAN_105',
		'CLAN_110',
		'CLAN_115',
		'CLAN_120',
		'CLAN_125',
		'CLAN_130',
		'CLAN_135',
		'CLAN_140',
		'CLAN_145',
		'CLAN_150',
		'CLAN_155',
		'CLAN_160',
		'CLAN_165',
		'CLAN_170',
		'CLAN_175',
		'CLAN_180',
		'CLAN_185',
		'CLAN_190',
		'CLAN_195',
		'CLAN_200',
		'CLAN_BA',
		'CLAN_LIGHT',
		'CLAN_MEDIUM',
		'CLAN_HEAVY',
		'CLAN_ASSAULT',
		'CLAN_SUPERHEAVY',
		'CLAN_LIGHT_BM',
		'CLAN_MEDIUM_BM',
		'CLAN_HEAVY_BM',
		'CLAN_ASSAULT_BM',
		'CLAN_SUPERHEAVY_BM',
		'CLAN_LIGHT_CV',
		'CLAN_MEDIUM_CV',
		'CLAN_HEAVY_CV',
		'CLAN_ASSAULT_CV',
		'CLAN_SUPERHEAVY_CV',
		'CLAN_LIGHT_AF',
		'CLAN_MEDIUM_AF',
		'CLAN_HEAVY_AF',
		'CLAN_ASSAULT_AF',
		'CLAN_SUPERHEAVY_AF',

		'IS_2',
		'IS_20',
		'IS_25',
		'IS_30',
		'IS_35',
		'IS_40',
		'IS_45',
		'IS_50',
		'IS_55',
		'IS_60',
		'IS_65',
		'IS_70',
		'IS_75',
		'IS_80',
		'IS_85',
		'IS_90',
		'IS_95',
		'IS_100',
		'IS_105',
		'IS_110',
		'IS_115',
		'IS_120',
		'IS_125',
		'IS_130',
		'IS_135',
		'IS_140',
		'IS_145',
		'IS_150',
		'IS_155',
		'IS_160',
		'IS_165',
		'IS_170',
		'IS_175',
		'IS_180',
		'IS_185',
		'IS_190',
		'IS_195',
		'IS_200',
		'IS_BA',
		'IS_LIGHT',
		'IS_MEDIUM',
		'IS_HEAVY',
		'IS_ASSAULT',
		'IS_SUPERHEAVY',
		'IS_LIGHT_BM',
		'IS_MEDIUM_BM',
		'IS_HEAVY_BM',
		'IS_ASSAULT_BM',
		'IS_SUPERHEAVY_BM',
		'IS_LIGHT_CV',
		'IS_MEDIUM_CV',
		'IS_HEAVY_CV',
		'IS_ASSAULT_CV',
		'IS_SUPERHEAVY_CV',
		'IS_LIGHT_AF',
		'IS_MEDIUM_AF',
		'IS_HEAVY_AF',
		'IS_ASSAULT_AF',
		'IS_SUPERHEAVY_AF'
	);

	// ---------------------------------------------------

	$jsonFiles = glob('/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/*.json');
	foreach($jsonFiles as $jsonFile) {
		if(is_file($jsonFile)) {
			echo "delete: " . $jsonFile . "<br>";
			unlink($jsonFile);
		}
	}
	$csvFiles = glob('/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/*.csv');
	foreach($csvFiles as $csvFile) {
		if(is_file($csvFile)) {
			echo "delete: " . $csvFile . "<br>";
			unlink($csvFile);
		}
	}

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
			$filename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/".$filename_arr[$key].".json";
			$fileHandle = fopen($filename, 'w');
			fwrite($fileHandle, $content);
			fclose($fileHandle);
			echo "saved.<br>";

			if ($filename_arr[$key] === 'IS_BA'
				|| $filename_arr[$key] === 'IS_LIGHT'
				|| $filename_arr[$key] === 'IS_MEDIUM'
				|| $filename_arr[$key] === 'IS_HEAVY'
				|| $filename_arr[$key] === 'IS_ASSAULT'
				|| $filename_arr[$key] === 'IS_SUPERHEAVY'
				|| $filename_arr[$key] === 'CLAN_BA'
				|| $filename_arr[$key] === 'CLAN_LIGHT'
				|| $filename_arr[$key] === 'CLAN_MEDIUM'
				|| $filename_arr[$key] === 'CLAN_HEAVY'
				|| $filename_arr[$key] === 'CLAN_ASSAULT'
				|| $filename_arr[$key] === 'CLAN_SUPERHEAVY'
				) {

				$dataentry = "";
				$catalogfilename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/catalog.csv";
				$unitsJson = json_decode($content);

				foreach($unitsJson as $unitList) {
					foreach($unitList as $unit) {
						if (!empty($unit->Id) && $unit->Id > 0 && $unit->Id != "") {
							$dataentry = $dataentry.$unit->Id.";"
								.trim($unit->Name).";"
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

//				$filename_sub_csv = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/".$filename_arr[$key].".csv";
//				$fileHandle_sub_csv = fopen($filename_sub_csv, 'w');
//				fwrite($fileHandle_sub_csv, $dataentry);
//				fclose($fileHandle_sub_csv);

				echo "saved.<br>";
				flush();
			}
			echo "catalog saved.";
		}
	}

	echo "<br>";
	echo "Saving cache version... ";
	$cacheversionfilename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/cache.version";
	$cacheversionfileHandle = fopen($cacheversionfilename, 'w');
	fwrite($cacheversionfileHandle, date('M Y'));
	fclose($cacheversionfileHandle);
	echo "saved.<br>";
	echo "<br><br><a href='https://www.ascard.net/app/data/mul_cache/cache_unitdetails_caller.htm'>Update Unitdetails (slow!)</a>";
?>
