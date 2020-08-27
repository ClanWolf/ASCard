<?php
  echo "ASCard App - creating unit cache (from MUL)";

  $Clan_0-2 = file_get_contents('http://www.masterunitlist.info/Unit/QuickList?Name=&HasBV=false&MinBV=&MaxBV=&MinIntro=&MaxIntro=&MinCost=&MaxCost=&HasRole=&HasBFAbility=&MinPV=&MaxPV=&Role=None+Selected&Technologies=2&BookAuto=&FactionAuto=&Types=21&SubTypes=28');

  if ($Clan_0-2 === FALSE) {
    
  }

  echo $Clan_0-2;
  $filename = "Clan_0-2.json";
  $fileHandle = fopen($filename, 'w');
  fwrite($fileHandle, $Clan_0-2);
  fclose($fileHandle);
?>
