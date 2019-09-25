<?php
	function getMechImageByName($mechname) {
		$image = "Generic.png";
		$dir = 'images/mechs/';
		$files = glob($dir.'*.png');
		foreach ($files as &$img) {

			$imagenametrimmed = basename(strtolower(str_replace(' ', '', trim($img))), ".png");
			$imagename = basename(str_replace(' ', '', trim($img)));
			$mechnametrimmed = strtolower(str_replace(' ', '', trim($mechname)));

			echo $imagenametrimmed." | ".$mechnametrimmed."<br>";

			if (strpos($mechnametrimmed, $imagenametrimmed) !== false) {
				$image = $imagename;
				break;
			}
		}
		echo "Found: ".$image;
		return $image;
	}

	$name = getMechImageByName("Vulture (Mad Dog) G");
?>
