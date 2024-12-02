<?php

	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);

	echo "ASCard App - caching units from MUL<br>";
	echo "-------------------------------------------<br>";
	echo date('M Y') . "<br>";
	echo "-------------------------------------------<br>";
	echo "<br>";

	$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
	$context = stream_context_create($opts);

	// Some Mechs have Technologies=3 (like the Wulfen) --> "Mixed". Technology needs to check for 2,3 for Clan and 1,3 for IS, 57 for Primitive
	// Types=18: Mechs
	// Types=19: Combat vehicles / Tanks
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
		'Clan_105.json',
		'Clan_110.json',
		'Clan_115.json',
		'Clan_120.json',
		'Clan_125.json',
		'Clan_130.json',
		'Clan_135.json',
		'Clan_140.json',
		'Clan_145.json',
		'Clan_150.json',
		'Clan_155.json',
		'Clan_160.json',
		'Clan_165.json',
		'Clan_170.json',
		'Clan_175.json',
		'Clan_180.json',
		'Clan_185.json',
		'Clan_190.json',
		'Clan_195.json',
		'Clan_200.json',
		'Clan_BA.json',
        'Clan_LIGHT.json',
        'Clan_MEDIUM.json',
        'Clan_HEAVY.json',
        'Clan_ASSAULT.json',
        'Clan_SUPERHEAVY.json',
        'Clan_LIGHT_BM.json',
        'Clan_MEDIUM_BM.json',
        'Clan_HEAVY_BM.json',
        'Clan_ASSAULT_BM.json',
        'Clan_SUPERHEAVY_BM.json',
        'Clan_LIGHT_CV.json',
        'Clan_MEDIUM_CV.json',
        'Clan_HEAVY_CV.json',
        'Clan_ASSAULT_CV.json',
        'Clan_SUPERHEAVY_CV.json',
        'Clan_LIGHT_AF.json',
        'Clan_MEDIUM_AF.json',
        'Clan_HEAVY_AF.json',
        'Clan_ASSAULT_AF.json',
        'Clan_SUPERHEAVY_AF.json',

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
		'IS_100.json',
		'IS_105.json',
		'IS_110.json',
		'IS_115.json',
		'IS_120.json',
		'IS_125.json',
		'IS_130.json',
		'IS_135.json',
		'IS_140.json',
		'IS_145.json',
		'IS_150.json',
		'IS_155.json',
		'IS_160.json',
		'IS_165.json',
		'IS_170.json',
		'IS_175.json',
		'IS_180.json',
		'IS_185.json',
		'IS_190.json',
		'IS_195.json',
		'IS_200.json',
		'IS_BA.json',
		'IS_LIGHT.json',
		'IS_MEDIUM.json',
		'IS_HEAVY.json',
		'IS_ASSAULT.json',
		'IS_SUPERHEAVY.json',
        'IS_LIGHT_BM.json',
        'IS_MEDIUM_BM.json',
        'IS_HEAVY_BM.json',
        'IS_ASSAULT_BM.json',
        'IS_SUPERHEAVY_BM.json',
        'IS_LIGHT_CV.json',
        'IS_MEDIUM_CV.json',
        'IS_HEAVY_CV.json',
        'IS_ASSAULT_CV.json',
        'IS_SUPERHEAVY_CV.json',
        'IS_LIGHT_AF.json',
        'IS_MEDIUM_AF.json',
        'IS_HEAVY_AF.json',
        'IS_ASSAULT_AF.json',
        'IS_SUPERHEAVY_AF.json'
	);

	// ---------------------------------------------------

	$jsonFiles = glob('/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/*.json');
	foreach($jsonFiles as $jsonFile) {
		if(is_file($jsonFile)) {
			echo "delete: " . $jsonFile . "<br>";
			unlink($jsonFile);
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
			$filename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/" . $filename_arr[$key];
			$fileHandle = fopen($filename, 'w');
			fwrite($fileHandle, $content);
			fclose($fileHandle);
			echo "saved.<br>";

//			// Clan
//			if (substr($filename_arr[$key], 0, 4) == 'Clan') {
//				$filename_all_Clan = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_ALL.json";
//				file_put_contents($filename_all_Clan, $content, FILE_APPEND);
//				// echo "saved Clan ALL.<br>";
//
//				if (strpos($filename_arr[$key], '_2') > 0) {
//					// BA
//					$filename_Clan_BA = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_BA.json";
//					file_put_contents($filename_Clan_BA, $content, FILE_APPEND);
//					// echo "saved Clan BA.<br>";
//				} else if (strpos($filename_arr[$key], '_20') > 0 || strpos($filename_arr[$key], '_25') > 0 || strpos($filename_arr[$key], '_30') > 0 || strpos($filename_arr[$key], '_35') > 0) {
//					// LIGHT
//					$filename_Clan_LIGHT = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_LIGHT.json";
//					file_put_contents($filename_Clan_LIGHT, $content, FILE_APPEND);
//					// echo "saved Clan LIGHT.<br>";
//				} else if (strpos($filename_arr[$key], '_40') > 0 || strpos($filename_arr[$key], '_45') > 0 || strpos($filename_arr[$key], '_50') > 0 || strpos($filename_arr[$key], '_55') > 0) {
//					// MEDIUM
//					$filename_Clan_MEDIUM = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_MEDIUM.json";
//					file_put_contents($filename_Clan_MEDIUM, $content, FILE_APPEND);
//					//echo "saved Clan MEDIUM.<br>";
//				} else if (strpos($filename_arr[$key], '_60') > 0 || strpos($filename_arr[$key], '_65') > 0 || strpos($filename_arr[$key], '_70') > 0 || strpos($filename_arr[$key], '_75') > 0) {
//					// HEAVY
//					$filename_Clan_HEAVY = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_HEAVY.json";
//					file_put_contents($filename_Clan_HEAVY, $content, FILE_APPEND);
//					// echo "saved Clan HEAVY.<br>";
//				} else if (strpos($filename_arr[$key], '_80') > 0 || strpos($filename_arr[$key], '_85') > 0 || strpos($filename_arr[$key], '_90') > 0 || strpos($filename_arr[$key], '_95') > 0 || strpos($filename_arr[$key], '_100') > 0) {
//					// ASSAULT
//					$filename_Clan_ASSAULT = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_ASSAULT.json";
//					file_put_contents($filename_Clan_ASSAULT, $content, FILE_APPEND);
//					// echo "saved Clan ASSAULT.<br>";
//				} else {
//					// SUPERHEAVY
//					$filename_Clan_SUPERHEAVY = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/Clan_SUPERHEAVY.json";
//					file_put_contents($filename_Clan_SUPERHEAVY, $content, FILE_APPEND);
//					// echo "saved Clan SUPERHEAVY.<br>";
//				}
//			} else {
//				$filename_all_IS = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_ALL.json";
//				file_put_contents($filename_all_IS, $content, FILE_APPEND);
//                // echo "saved IS ALL.<br>";
//
//				if (strpos($filename_arr[$key], '_2') > 0) {
//					// BA
//					$filename_IS_BA = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_BA.json";
//					file_put_contents($filename_IS_BA, $content, FILE_APPEND);
//					// echo "saved IS BA.<br>";
//				} else if (strpos($filename_arr[$key], '_20') > 0 || strpos($filename_arr[$key], '_25') > 0 || strpos($filename_arr[$key], '_30') > 0 || strpos($filename_arr[$key], '_35') > 0) {
//					// LIGHT
//					$filename_IS_LIGHT = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_LIGHT.json";
//					file_put_contents($filename_IS_LIGHT, $content, FILE_APPEND);
//					// echo "saved IS LIGHT.<br>";
//				} else if (strpos($filename_arr[$key], '_40') > 0 || strpos($filename_arr[$key], '_45') > 0 || strpos($filename_arr[$key], '_50') > 0 || strpos($filename_arr[$key], '_55') > 0) {
//					// MEDIUM
//					$filename_IS_MEDIUM = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_MEDIUM.json";
//					file_put_contents($filename_IS_MEDIUM, $content, FILE_APPEND);
//					// echo "saved IS MEDIUM.<br>";
//				} else if (strpos($filename_arr[$key], '_60') > 0 || strpos($filename_arr[$key], '_65') > 0 || strpos($filename_arr[$key], '_70') > 0 || strpos($filename_arr[$key], '_75') > 0) {
//					// HEAVY
//					$filename_IS_HEAVY = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_HEAVY.json";
//					file_put_contents($filename_IS_HEAVY, $content, FILE_APPEND);
//					// echo "saved IS HEAVY.<br>";
//				} else if (strpos($filename_arr[$key], '_80') > 0 || strpos($filename_arr[$key], '_85') > 0 || strpos($filename_arr[$key], '_90') > 0 || strpos($filename_arr[$key], '_95') > 0 || strpos($filename_arr[$key], '_100') > 0) {
//					// ASSAULT
//					$filename_IS_ASSAULT = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_ASSAULT.json";
//					file_put_contents($filename_IS_ASSAULT, $content, FILE_APPEND);
//					// echo "saved IS ASSAULT.<br>";
//				} else {
//					// SUPERHEAVY
//					$filename_IS_SUPERHEAVY = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/IS_SUPERHEAVY.json";
//					$fileContent = file_get_contents($filename_IS_SUPERHEAVY, true);
//                    $mergedContent = json_encode(array_merge(json_decode($fileContent, true), json_decode($content, true)));
//					$fileHandle = fopen($filename_IS_SUPERHEAVY, 'w');
//					fwrite($fileHandle, $mergedContent);
//					fclose($fileHandle);
//
//					// file_put_contents($filename_IS_SUPERHEAVY, $content, FILE_APPEND);
//					// echo "saved IS SUPERHEAVY.<br>";
//				}
//			}
		}
	}

	echo "<br>";
	echo "Saving cache version... ";
	$cacheversionfilename = "/var/www/vhosts/ascard.net/httpdocs/app/cache/mul/cache.version";
	$cacheversionfileHandle = fopen($cacheversionfilename, 'w');
	fwrite($cacheversionfileHandle, date('M Y'));
	fclose($cacheversionfileHandle);
	echo "saved.<br>";
	echo "<br><br><a href='https://www.ascard.net/app/data/mul_cache/cache_mechdetails_caller.htm'>Update Mechdetails (slow!)</a>";
?>
