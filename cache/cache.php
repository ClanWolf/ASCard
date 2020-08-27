<?php
  $Clan_0-2 = file_get_contents('https://www.clanwolf.net/apps/ASCard/cache/cache.php');
  echo $Clan_0-2;

  $filename = "test.json";
  $fileHandle = fopen($filename, 'w');
  fwrite($fileHandle, $Clan_0-2);

  fclose($fileHandle);
?>
