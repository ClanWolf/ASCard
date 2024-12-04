<?php
	function getUnitImageByName($unitname) {
		$image = "Generic.png";
		$dir = 'images/units/';
		$files = glob($dir.'*.png');
		foreach ($files as &$img) {

			$imagenametrimmed = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagename = basename(str_replace(' ', '', trim($img)));
			$unitnametrimmed = strtolower(str_replace(' ', '', trim($unitname)));

			echo $imagenametrimmed." | ".$unitnametrimmed."<br>";

			if (strpos($unitnametrimmed, $imagenametrimmed) !== false) {
				$image = $imagename;
				break;
			}
		}
		echo "Found: ".$image;
		return $image;
	}

	$name = getUnitImageByName("Vulture (Mad Dog) G");
?>
