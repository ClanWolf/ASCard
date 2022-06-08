<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 5");
	}
	$pid = $_SESSION['playerid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedMech = $_SESSION['option1'];

	$opt2 = $_SESSION['option2'];
	$showplayerdata_topleft = $opt2;
?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard)</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75, user-scalable=no" />

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="icon" href="./favicon.png" type="image/png">
	<link rel="shortcut icon" href="./images/icon_196x196.png" type="image/png" sizes="196x196">
	<link rel="apple-touch-icon" href="./images/icon_57x57.png" type="image/png" sizes="57x57">
	<link rel="apple-touch-icon" href="./images/icon_72x72.png" type="image/png" sizes="72x72">
	<link rel="apple-touch-icon" href="./images/icon_76x76.png" type="image/png" sizes="76x76">
	<link rel="apple-touch-icon" href="./images/icon_114x114.png" type="image/png" sizes="114x114">
	<link rel="apple-touch-icon" href="./images/icon_120x120.png" type="image/png" sizes="120x120">
	<link rel="apple-touch-icon" href="./images/icon_144x144.png" type="image/png" sizes="144x144">
	<link rel="apple-touch-icon" href="./images/icon_152x152.png" type="image/png" sizes="152x152">
	<link rel="apple-touch-icon" href="./images/icon_180x180.png" type="image/png" sizes="180x180">

	<script type="text/javascript" src="./scripts/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>
	<script type="text/javascript" src="./scripts/functions.js"></script>
	<!-- <script type="text/javascript" src="./scripts/qrcode.js"></script> -->

	<style>
		.options {
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 5px;
			background: rgba(60,60,60,0.75);
			color: #ddd;
			border-color: #aaa;
		}
	</style>
</head>

<body>
	<script>

//		// -------------------------------------------------------------------------------------------------------------
//		function fixHeight() {
//			var calculated_total_height = screen.height*window.devicePixelRatio; // this works with the real y value as a result
//			//var windowWidth = window.innerWidth;
//			//var windowHeight = window.innerHeight;
//			//document.getElementsByTagName('body')[0].style.height = windowHeight + "px";
//			//window.innerHeight = 600;
//			//window.scrollTo(0,1);
//			//$(window).trigger('resize');
//			//document.body.style.height = 780; // window.innerWidth;
//			//console.log("New height: " + windowHeight);
//			//alert("New height: " + windowHeight);
//			//alert("New height: " + calculated_total_height);
//		}
//		$(window).on('orientationchange', function () {
//			$(window).one('resize', function () {
//				setTimeout(fixHeight, 600);
//			});
//		});
//		setTimeout(fixHeight, 600);
//		// -------------------------------------------------------------------------------------------------------------

		var movementcache = 0;
		var firedcache = 0;

		function setFireValues(mv, fired) {
			if (mv == 2) { // Stationary (AMM -1)
				document.getElementById("AMM").innerHTML = "-1";
			} else if (mv == 4) { // Jumped (AMM +2)
				document.getElementById("AMM").innerHTML = "+2";
			} else if (mv == 9) { // Sprinted
             	document.getElementById("AMM").innerHTML = "0";
             } else {
				document.getElementById("AMM").innerHTML = "0";
			}
		}

		function changeMovementFlag(index, fln) {
			if (context != null) {
				playTapSound();
			}

			var list = document.getElementsByClassName("bigcheck");
			var fired = 0;
			var mv = 0;
			var movementdiestring = "";

			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 2) == "MV" && (fln!=5 && fln!=6 && fln!=7 && fln!=8)) { el1.checked = false }
					if (na.substring(0, 4) == "MV" + fln + "_") {
						el1.checked = true;
						mv = fln;
					}

					if ((na.substring(0, 4) == "MV1_") && el1.checked == true) { mv = 1; }
					if ((na.substring(0, 4) == "MV2_") && el1.checked == true) { mv = 2; }
					if ((na.substring(0, 4) == "MV3_") && el1.checked == true) { mv = 3; }
					if ((na.substring(0, 4) == "MV4_") && el1.checked == true) { mv = 4; }
					if ((na.substring(0, 4) == "MV9_") && el1.checked == true) { mv = 9; }

					if (na.substring(0,2) == "WF" && (fln!=1 && fln!=2 && fln!=3 && fln!=4 && fln!=9)) { el1.checked = false }
					if (na.substring(0,4) == "WF" + fln + "_") {
						el1.checked = true;
					}

					if (na == "WF5_WEAPONSFIRED" && el1.checked == true) {
						if (mv == 0) {
							//alert("First movement has to be specified!");
							el1.checked = false;
						} else {
							fired = 1; // not fired on purpose to cool down (or the unit sprinted)
						}
					}
					if (na == "WF6_WEAPONSFIRED" && el1.checked == true) {
						if (mv == 0) {
							//alert("First movement has to be specified!");
							el1.checked = false;
						} else {
							fired = 2; // fired weapons, was before: fired on short range (not anymore, there is just fired or hold fire)
						}
					}
//					if (na == "WF7_WEAPONSFIRED" && el1.checked == true) {
//						if (mv == 0) {
//							//alert("First movement has to be specified!");
//							el1.checked = false;
//						} else {
//							fired = 3; // fired on medium range
//						}
//					}
//					if (na == "WF8_WEAPONSFIRED" && el1.checked == true) {
//						if (mv == 0) {
//							//alert("First movement has to be specified!");
//							el1.checked = false;
//						} else {
//							fired = 4; // fired on long range
//						}
//					}
				}
			})

			var elem = document.getElementById("fire_info_cell_2");
			if (elem == null || elem === undefined) {
				// nothing
			} else {
				if (mv == "0" || mv == "9") {
					elem.className = 'datalabel_disabled_dashed';
				} else {
					elem.className = 'datalabel';
				}
			}

			var clearmovement = false;
			if (movementcache == mv && (fln!=5 && fln!=6 && fln!=7 && fln!=8)) {
				clearMovementFlags(index);
				clearmovement = true;
				fired = 0;
			} else {
				movementcache = mv;
			}

			if (firedcache == fired && (fln!=1 && fln!=2 && fln!=3 && fln!=4 && fln!=9)) {
				clearFiredFlags(index, mv);
				fired = 0;
			} else {
				firedcache = fired;
			}

			if (clearmovement) {
				mv = 0;
				fired = 0;
			}

			if (mv == 9) {
				fired = 1;
			}

			var tmmDiceValue = document.getElementById("TMM").innerHTML;
			if (tmmDiceValue == '0') {
				tmmDiceValue = 6;
			}

			if (mv == "0") { // not moved yet
			    movementdiestring = movementdiestring + "d6_0.png";
			    document.getElementById('INFOMOVED').innerHTML = "MOVE:";
			} else if (mv == "2") { // stationary
			    movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
			    document.getElementById('INFOMOVED').innerHTML = "STATIONARY";
			} else if (mv == "3") { // walked
			    movementdiestring = movementdiestring + "d6_" + tmmDiceValue + ".png";
			    document.getElementById('INFOMOVED').innerHTML = "WALKED";
			} else if (mv == "4") { // jumped
			    movementdiestring = movementdiestring + "rd6_" + tmmDiceValue + ".png";
			    document.getElementById('INFOMOVED').innerHTML = "JUMPED";
			} else if (mv == "9") { // sprinted
				movementdiestring = movementdiestring + "yd6_" + tmmDiceValue + ".png";
                var e1 = document.getElementById("WF5_WEAPONSFIRED");
                var e2 = document.getElementById("WF6_WEAPONSFIRED");
                if (e1 !== undefined && e1 !== null) { e1.checked = true; }
                if (e2 !== undefined && e2 !== null) { e2.checked = false; }
				var e1a = document.getElementById("WF5_WEAPONSFIRED2");
				var e2a = document.getElementById("WF6_WEAPONSFIRED2");
				if (e1a !== undefined && e1a !== null) { e1a.checked = true; }
                if (e2a !== undefined && e2a !== null) { e2a.checked = false; }
                fired = 1; // HOLD FIRE!
                document.getElementById('INFOMOVED').innerHTML = "SPRINTED";
            }

			if (fired == 0) {
                document.getElementById('INFOFIRED').innerHTML = "FIRE:";
            } else if (fired == 1) {
				document.getElementById('INFOFIRED').innerHTML = "HOLD FIRE";
			} else if (fired == 2) {
				document.getElementById('INFOFIRED').innerHTML = "FIRED";
			}

			document.getElementById('movementtokenimage').src="./images/dice/" + movementdiestring;

			setFireValues(mv, fired);
			var url="./save_movement.php?index="+index+"&mvmt="+mv+"&wpns="+fired;
			//console.log("Final 3: " + url);
			window.frames['saveframe'].location.replace(url);
		}

		function setMovementFlags(index, movement, weaponsfired) {
			if (context != null) {
				playTapSound();
			}

			var movementdiestring = "";

			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 2) == "MV") { el1.checked = false }

					if ((na.substring(0, 4) == "MV1_") && movement == 1) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV2_") && movement == 2) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV3_") && movement == 3) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV4_") && movement == 4) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV9_") && movement == 9) { el1.checked = true; }

					// weaponsfired == 0 : not fired yet
					// weaponsfired == 1 : not fired on purpose
					// weaponsfired == 2 : fired

					if (na == "WF5_WEAPONSFIRED" && weaponsfired == 1) { el1.checked = true; }
					if (na == "WF5_WEAPONSFIRED2" && weaponsfired == 1) { el1.checked = true; }
					if (na == "WF6_WEAPONSFIRED" && weaponsfired == 2) { el1.checked = true; }
					if (na == "WF6_WEAPONSFIRED2" && weaponsfired == 2) { el1.checked = true; }
					//if (na == "WF7_WEAPONSFIRED" && weaponsfired == 3) { el1.checked = true; }
					//if (na == "WF8_WEAPONSFIRED" && weaponsfired == 4) { el1.checked = true; }
				}
			})

			var elem = document.getElementById("fire_info_cell_2");
			if (elem == null || elem === undefined) {
				// nothing
			} else {
				if (movement == "0" || movement == "9") {
					elem.className = 'datalabel_disabled_dashed';
				} else {
					elem.className = 'datalabel';
				}
			}

			var tmmDiceValue = document.getElementById("TMM").innerHTML;
			if (tmmDiceValue == '0') {
				tmmDiceValue = 6;
			}

			if (movement == "0") { // not moved yet
			    movementdiestring = movementdiestring + "d6_0.png";
			    document.getElementById('INFOMOVED').innerHTML = "MOVE:";
			} else if (movement == "2") { // stationary
			    movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
			    document.getElementById('INFOMOVED').innerHTML = "STATIONARY";
			} else if (movement == "3") { // walked
			    movementdiestring = movementdiestring + "d6_" + tmmDiceValue + ".png";
			    document.getElementById('INFOMOVED').innerHTML = "WALKED";
			} else if (movement == "4") { // jumped
			    movementdiestring = movementdiestring + "rd6_" + tmmDiceValue + ".png";
			    document.getElementById('INFOMOVED').innerHTML = "JUMPED";
			} else if (movement == "9") {
				movementdiestring = movementdiestring + "yd6_" + tmmDiceValue + ".png";
				var e1 = document.getElementById("WF5_WEAPONSFIRED");
				var e2 = document.getElementById("WF6_WEAPONSFIRED");
                if (e1 !== undefined && e1 !== null) { e1.checked = true; }
                if (e2 !== undefined && e2 !== null) { e2.checked = false; }
				var e1a = document.getElementById("WF5_WEAPONSFIRED2");
				var e2a = document.getElementById("WF6_WEAPONSFIRED2");
				if (e1a !== undefined && e1a !== null) { e1a.checked = true; }
                if (e2a !== undefined && e2a !== null) { e2a.checked = false; }
                fired = 1; // HOLD FIRE!
                document.getElementById('INFOMOVED').innerHTML = "SPRINTED";
			}

			if (weaponsfired == 0) {
				document.getElementById('INFOFIRED').innerHTML = "FIRE:";
			} else if (weaponsfired == 1) {
				document.getElementById('INFOFIRED').innerHTML = "HOLD FIRE";
			} else if (weaponsfired == 2) {
				document.getElementById('INFOFIRED').innerHTML = "FIRED";
			}

			document.getElementById('movementtokenimage').src="./images/dice/" + movementdiestring;

			movementcache = movement;
			firedcache = weaponsfired;
			setFireValues(movement, weaponsfired);
		}

		function clearFiredFlags(index, mv) {
			if (context != null) {
				playTapSound();
			}

			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 2) == "WF") {
						el1.checked = false;
					}
				}
			})

			firedcache = 0;
		}

		function clearMovementFlags(index) {
			if (context != null) {
				playTapSound();
			}

			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if ((na.substring(0, 2) == "MV") || (na.substring(0, 2) == "WF")) {
						el1.checked = false;
					}
				}
			})

			var elem = document.getElementById("fire_info_cell_2");
			if (elem == null || elem === undefined) {
				// nothing
			} else {
				elem.className = 'datalabel_disabled_dashed';
			}

			movementcache = 0;
		}

		function hideInfoBar() {
			$("#infobar").hide();
		}

		function showInfoBar() {
			if($('#infobar').is(':visible')) {
				// the movebar is already open. do nothing
			} else {
				$("#movebar").hide();
				$("#dicebar").hide();
				$("#firebar").hide();
				$("#infobar").show();
			}
		}

		function hideDiceBar() {
			$("#dicebar").hide();
		}

		function showDiceBar() {
			if($('#dicebar').is(':visible')) {
				// the dicebar is already open. do nothing
			} else {
				$("#infobar").hide();
				$("#movebar").hide();
				$("#firebar").hide();
				$("#dicebar").show();

				if (rolling === 0) {
				    playDiceSound();
					for (i = 1; i < 12; i++) {
						rolling++;
						setTimeout("rolldice(i)", i * 80);
					}
				}
			}
		}

		function hideMoveBar() {
			$("#movebar").hide();
		}

		function showMoveBar() {
			if($('#movebar').is(':visible')) {
				// the movebar is already open. do nothing
			} else {
				$("#dicebar").hide();
				$("#infobar").hide();
				$("#firebar").hide();
				$("#movebar").show();
			}
		}

		function hideFireBar() {
			$("#firebar").hide();
		}

		function showFireBar() {
			if($('#firebar').is(':visible')) {
				// the movebar is already open. do nothing
			} else {
				$("#dicebar").hide();
				$("#infobar").hide();
				$("#movebar").hide();
				$("#firebar").show();
			}
		}
	</script>

<?php
	$file = file_get_contents('./version.txt', true);
	$version = $file;
	if (!isset($_GET["unit"])) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
		//die("Check position 1");
	}
	$unitid = $_GET["unit"];
	if (empty($unitid)) {
		echo "<meta http-equiv='refresh' content='0;url=./gui_select_unit.php'> ";
		header("Location: ./gui_select_unit.php");
		//die("Check position 2");
	}
	$chosenMechIndex = $_GET["chosenmech"];
	if (empty($chosenMechIndex)) {
		$chosenMechIndex = 1;
	}
	$movd = $_GET["movd"];
	if (empty($movd)) {
		$movd=0;
	}
	require('./db_getdata.php');

	echo "<script>\n";
	echo "  var chosenmechindex = ".$chosenMechIndex.";\n";
	echo "	var shortdamage = ".$array_DMG_SHORT[$chosenMechIndex].";\n";
	echo "	var mediumdamage = ".$array_DMG_MEDIUM[$chosenMechIndex].";\n";
	echo "	var longdamage = ".$array_DMG_LONG[$chosenMechIndex].";\n";
	echo "	var movementpointsground = ".$array_MV[$chosenMechIndex].";\n";
	if ($array_MVJ[$chosenMechIndex] != null) {
		echo "	var movementpointsjump = ".$array_MVJ[$chosenMechIndex].";\n";
	} else {
		echo "	var movementpointsjump = 0;\n";
	}
	echo "	var maximalarmorpoints = ".$array_A_MAX[$chosenMechIndex].";\n";
	echo "	var maximalstructurepoints = ".$array_S_MAX[$chosenMechIndex].";\n";
	echo "	var originalmechimage = '".$array_MECH_IMG_URL[$chosenMechIndex]."';\n";
	echo "	var deadmechimage = 'skull.png';\n";

	if ($array_TMM[$chosenMechIndex] != null) {
		echo "	var originalTMM = $array_TMM[$chosenMechIndex];\n";
	}
	if ($array_MVMT[$chosenMechIndex] != null) {
		echo "	var movement = $array_MVMT[$chosenMechIndex];\n";
	}
	if ($array_WPNSFIRED[$chosenMechIndex] != null) {
		echo "	var weaponsfired = $array_WPNSFIRED[$chosenMechIndex];\n";
	}
	if ($array_TP[$chosenMechIndex] != null) {
		echo "  var unitType = '$array_TP[$chosenMechIndex]';\n";
	}
	echo "</script>\n";
?>

<iframe name="saveframe" src="./save.php"></iframe>

<div id="cover"></div>

<div id="header">
	<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
		<tr>
			<td nowrap onclick="location.href='./index.html'" width="50px" style="background:rgba(50,50,50,1.0); text-align:center;vertical-align:middle;">
				<div><a style="color:#eee;" href="./index.html"><i class="fas fa-bars" aria-hidden="true"></i></a></div>
			</td>
			<td style="background:rgba(1,1,1,1.0);">
				<table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_active_left' style="background:rgba(1,1,1,1.0);">
					<tr>
						<td nowrap width='20px' align='center' valign='center'>
							<div style='display:inline-block;height:100%;vertical-align:middle;'>
								<span style='font-size:16px;'>RND</span><br>
								<span style='font-size:16px;color:#ff0;'><?php echo $CURRENTROUND ?></span>
							</div>
						</td>
					</tr>
				</table>
			</td>

<?php
	$size = sizeof($array_MECH_MODEL);
	for ($i11 = 1; $i11 <= sizeof($array_MECH_MODEL); $i11++) {
		if ($array_ACTIVE_BID[$i11] == "0") {
        	$size = $size - 1;
        }
	}
	$width = ceil(100 / $size);
	$heatimage = array();
	$currentMechStatusImage = "./images/check_red.png";
	$currentmeli = "";
	$currentPhaseButton = "./images/top-right_phase01.png";

	$currentMechMovement = 0;
	$currentMechFired = 0;

	for ($i4 = 1; $i4 <= sizeof($array_MECH_MODEL); $i4++) {
		$mechstatusimage = "./images/check_red.png";
		$mvmt = $array_MVMT[$i4];
		$wpnsfired = $array_WPNSFIRED[$i4];

		if ($array_TP[$i4] == "BA") {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='21px' width='0px'>";
		} else {
			$heatimage[$i4] = "<img id='heatimage_".$i4."' src='./images/temp_".$array_HT[$i4].".png' height='21px'>";
		}
		if ($mvmt == 0 && $wpnsfired == 0) {
			$mechstatusimage = "./images/check_red.png";
			$phaseButton = "./images/top-right_phase01.png";
		}
		if ($mvmt > 0 && $wpnsfired == 0) {
			$mechstatusimage = "./images/check_yellow.png";
			$phaseButton = "./images/top-right_phase02.png";
		}
		if ($mvmt > 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			$mechstatusimage = "./images/check_green.png";
			$phaseButton = "./images/top-right_phase03.png";
		}
		if ($mvmt == 0 && ($wpnsfired == 1 || $wpnsfired == 2 || $wpnsfired == 3 || $wpnsfired == 4)) {
			// Error! Unit has fired but no movement was specified! Ask again!
		}

		if ($array_MECH_IMG_STATUS[$i4] == "images/DD_04.png") {
			$phaseButton = "./images/top-right_phase00.png";
		}

		$memodel = $array_MECH_MODEL[$i4];
		if ($array_ACTIVE_BID[$i4] == "0") {
			$memodel = "--- BIDDEN AWAY ---";
		}

		if ($array_MECH_NUMBER[$i4] == "") {
			$mn = "-";
		} else {
			$mn = $array_MECH_NUMBER[$i4];
		}

		$meli="./gui_play_mech.php?unit=".$unitid."&chosenmech=".$i4;
		if ($chosenMechIndex == $i4) {
			if ($movd==1) {
				$meli = $meli."&movd=0";
				$locmeli = $meli;
			} else {
				$meli = $meli."&movd=1";
			}
			$currentMechStatusImage = $mechstatusimage;
			$currentmeli = $meli;
			$currentPhaseButton = $phaseButton;

			$currentMechMovement = $mvmt;
			$currentMechFired = $wpnsfired;

			// <td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\">
			echo "<td width='".$width."%' nowrap><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_active_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span><br><img id='mechstatusimagemenu' style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='25px' width='23px'></div></td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$mechstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".$memodel."</span></div></td></tr></table></td>\r\n";
		} else {
			// <td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\">
			if ($array_ACTIVE_BID[$i4] == "1") {
            	echo "<td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span><br><img style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='25px' width='23px'></div></td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$mechstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".$memodel."</span></div></td></tr></table></td>\r\n";
            } else {
                echo "<td style='display:none;visibility:hidden;' width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_normal_play_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><span style='color:#ccffff;font-size:15px;'>&nbsp;&nbsp;".$mn."&nbsp;&nbsp;</span><br><img style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='25px' width='23px'></div></td><td nowrap width='100%'><div><img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$i4].".png' width='18px' height='18px'>&nbsp;<a style='font-size:24px' href='".$meli."'>".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='".$mechstatusimage."' height='21px'>".$heatimage[$i4]."<br><span style='font-size:14px;'>".$memodel."</span></div></td></tr></table></td>\r\n";
			}
		}
	}
?>

			<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
		</tr>
	</table>
</div>

<div id="pilotimage"><?php echo "<img src='".$array_PILOT_IMG_URL[$chosenMechIndex]."' width='80px' height='80px'>" ?></div>
<div id="faction" align="center"><?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='50px' height='50px'>" ?></div>
<div id="mech_number" align="center">#<?= $array_MECH_NUMBER[$chosenMechIndex] ?></div>
<div id="mech"><?php echo "<img id='mechimage' src='".$array_MECH_IMG_URL[$chosenMechIndex]."'>" ?></div>

<div id="topleft">
	<span style="font-size: 18px; color: #eeeeee;"><?php echo "$UNIT"; ?></span>
	<br>
	<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenMechIndex]"; ?></span>
	<br>
	<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_MECH_MODEL[$chosenMechIndex]" ?></span>
</div>

<div id="topright">
	<a onclick=location.href=<?php echo "'$currentmeli'"; ?> href=<?php echo "'$currentmeli'"; ?>>
		<!--<img id='toprightimage' src=<?php echo "'$currentPhaseButton'"; ?> style='height:170px;'> -->
		<img id='toprightimage' src='./images/top-right_02.png' style='height:135px;'>
	</a>
</div>

<?php
	echo "<div id='mechalive_status_div'>\n";
	echo "	<img id='mechalive_status' src='./images/vitalmonitor.gif' width='140px' height='120px'>\n";
	echo "</div>\n";
	echo "<div id='player_image'>\n";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>\n";
	echo "</div>\n";
	echo "<div id='pilotrank'>\n";
	echo "  <img src='./images/ranks/".$factionid."/".$array_PILOT_RANK[$chosenMechIndex].".png' width='30px' height='30px'>\n";
	echo "</div>\n";
	if ($pid == $unitplayerid) {
		// Current Mech is playable by current user
		$playable = true;
	} else {
		$playable = false;
	}

	if ($array_ACTIVE_BID[$chosenMechIndex] == "0") {
		$playable = false;
	}

	if (!$playable) {
		if ($hideNotOwnedMech) {
			echo "<div id='blockNotOwnedMechs'></div>";
		}
	}

	echo "<script type='text/javascript'>\n";
	if ($showplayerdata_topleft == 1) {
        // show top left pilot info
		echo "  $('#pilotimage').show();\n";
		echo "  $('#faction').show();\n";
		echo "  $('#pilotrank').show();\n";
		echo "  $('#topleft').show();\n";
	} else {
		// do not show pilot infor
		echo "  $('#pilotimage').hide();\n";
		echo "  $('#faction').hide();\n";
		echo "  $('#pilotrank').hide();\n";
		echo "  $('#topleft').hide();\n";
	}
	echo "  //console.log('Current structure damage: $array_S[$chosenMechIndex]');\n";
	echo "  setStructuralDamageCache($array_S[$chosenMechIndex]);\n";
	echo "</script>\n";
?>

<div id="pv">
	<span style="font-size: 22px; color: #aaaaaa; vertical-align: middle;">PV:&nbsp;</span>
	<span style="font-size: 36px; color: #da8e25; vertical-align: middle; font-weight: bold;"><?php echo "$array_PV[$chosenMechIndex]"; ?></span>
</div>

<div class="datatable">
	<table width="100%" style="height: 100%;">
		<tr>
			<td width="60%" valign="bottom">

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="12%">TP:</td>
							<td nowrap class="datavalue" width="13%" id="unit_type"><?php echo "$array_TP[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">SZ:</td>
							<td nowrap class="datavalue" width="13%"><?php echo "$array_SZ[$chosenMechIndex]/$array_TON[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">TMM:</td>
							<td nowrap class="datavalue" width="13%" id="TMM"><?php echo "$array_TMM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">MV:</td>
							<td nowrap class="datavalue_thin" style="text-transform: none;" width="12%" id="mv_points"><?php echo "$array_MV[$chosenMechIndex]&rdquo;";
							if ($array_MVJ[$chosenMechIndex] != null) {
								echo "/$array_MVJ[$chosenMechIndex]&rdquo;&nbsp;j";
							} ?></td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="12%" colspan="1">ROLE:</td>
							<td nowrap class="datavalue_thin" width="38%" colspan="3"><?php echo "$array_ROLE[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%" colspan="1">SKILL:</td>
							<td nowrap class="datavalue" width="37%" colspan="3" valign="middle" style="top:0px;bottom:0px;vertical-align:middle;"><?php echo "$array_SKILL[$chosenMechIndex]"; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family:'Pathway Gothic One',sans-serif;font-size:75%;text-transform:uppercase;color:#999;" id="AMM">0</span> <span style="font-family:'Pathway Gothic One',sans-serif;font-size:75%;text-transform:uppercase;color:#999;">(AMM)</span></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="10%" style="text-align: left;">DMG:</td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;" id="minrollshort">S (+0):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgshort_s"><?php echo "$array_DMG_SHORT[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;" id="minrollmedium">M (+2):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgmedium_s"><?php echo "$array_DMG_MEDIUM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;" id="minrolllong">L (+4):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmglong_s"><?php echo "$array_DMG_LONG[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>
<?php
	if ($array_TP[$chosenMechIndex] == "BA") {
		// Do not show the heat block for all Battle Armor units
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	} else {
		echo "				<div class='dataarea'>\r\n";
	}
?>
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%">OV:</td>
							<!-- <td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_OV[$chosenMechIndex]"; ?></td> -->
							<td nowrap width="30%" style="color: #222;">
<?php
	for ($i1 = 1; $i1 <= $array_OV[$chosenMechIndex]; $i1++) {
		echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='UOV".$i1."' id='UOV".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
							<td nowrap class="datalabel" width="10%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:</td>
							<td nowrap width="35%" style="text-align: right;" id="ht_field">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H1" id="H1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H2" id="H2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H3" id="H3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H4" id="H4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<!-- <td class="datalabel" width="5%" style="text-align: right;">&nbsp;&nbsp;&nbsp;(SD)</td> -->
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap width="5%" class="datalabel">A:</td>
							<td nowrap width="95%" style="color: #222;">
<?php
	for ($i1 = 1; $i1 <= $array_A_MAX[$chosenMechIndex]; $i1++) {
		echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='A".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
						</tr>
						<tr>
							<td nowrap width="5%" class="datalabel">S:</td>
							<td nowrap width="95%" style="color: #aaa;">
<?php
	for ($i2 = 1; $i2 <= $array_S_MAX[$chosenMechIndex]; $i2++) {
		echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='S".$i2."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;\r\n";
	}
?>
							</td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap width="10%" class="datalabel" width="100%">SP:</td>
							<td nowrap width="90%" class="datavalue_thin" style="text-align: left;">
								<table>
									<tr>
										<td nowrap width="99%" class="datavalue_thin" style="text-align: left;" id="sa_field">
											<?php echo "$array_SPCL[$chosenMechIndex]"; ?>
										</td>
										<td nowrap width="1%" class="datavalue_thin" style="text-align: right;" align="right">
											<a href="https://www.clanwolf.net/apps/ASCard/gui_show_specialabilities.php"><i class="fas fa-info-circle"></i></a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>

			</td>
			<td width="40%" valign="bottom" align="right">

			<!--
				<table width="100%">
					<tr>
						<td nowrap rowspan="2" style="vertical-align: bottom;" valign="bottom" class="datalabel" width="1%">&nbsp;&nbsp;<a href=<?php echo "'$currentmeli'"; ?>"><img src=<?php echo "'$currentMechStatusImage'"; ?>" style='height:120px;'></a></td>
						<td align="left">
							<div id="phasebutton" name="phasebutton"><a href=<?php echo "'$currentmeli'"; ?>><img src=<?php echo "'$currentPhaseButton'"; ?> style='height:140px;'></a></div>
						</td>
						<td align="right" valign="bottom">
<?php
	if ($array_TP[$chosenMechIndex] != "BA") {
		echo "		            	<div id='criticalhit'></div>\r\n";
	} else {
		echo "		        		<div id='criticalhit' style='display:none;'></div>\r\n";
	}
?>
							<div id="dice" valign="middle" align="center">
								<img id="die1" src="./images/dice/d6_0.png" width="65px" height="65px">
								<img id="die2" src="./images/dice/d6_0.png" width="65px" height="65px">
							</div>
						</td>
					</tr>
				</table>
			-->
				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap rowspan="2" style="vertical-align: middle;" valign="middle" align="center" width="15%">
                               	<div style="padding: 0 15 0 15;" id="phasebutton" name="phasebutton"><a href=<?php echo "'$currentmeli'"; ?>><img src=<?php echo "'$currentPhaseButton'"; ?> style='height:50px;'></a></div>
                            </td>
                            <td id="INFOMOVED" nowrap class="datalabel">MOVED:&nbsp;</td>
                            <td nowrap class="datalabel_thin">
                                <label class='bigcheck'><input type='checkbox' class='bigcheck' name='MV2_moved2_standstill' id='MV2_moved2_standstill' value='no'/><span class='bigcheck-target'></span></label>
                                <label class='bigcheck'><input type='checkbox' class='bigcheck' name='MV3_moved3_moved' id='MV3_moved3_moved' value='no'/><span class='bigcheck-target'></span></label>
                                <label class='bigcheck'><input type='checkbox' class='bigcheck' name='MV9_moved9_sprinted' id='MV9_moved9_sprinted' value='no'/><span class='bigcheck-target'></span></label>
                                <label class='bigcheck'><input type='checkbox' class='bigcheck' name='MV4_moved4_jumped' id='MV4_moved4_jumped' value='no'/><span class='bigcheck-target'></span></label>
                            </td>
                            <td rowspan="2" align="right" width="1%" valign="top">
                                <div id="movementtoken" valign="top" align="right">
                                    <a href=<?php echo "'$currentmeli'"; ?>"><img valign="top" id="movementtokenimage" src="./images/dice/yd6_4.png" height="35px"></a>
                                </div>
                            </td>
                        </tr>
						<tr>
							<td id="INFOFIRED" nowrap  width="15%" class="datalabel">FIRED:&nbsp;</td>
							<td nowrap width="70%" class="datalabel_thin">
								<label class='bigcheck'><input type='checkbox' class='bigcheck' name='WF5_WEAPONSFIRED2' id='WF5_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label>
								<label class='bigcheck'><input type='checkbox' class='bigcheck' name='WF6_WEAPONSFIRED2' id='WF6_WEAPONSFIRED2' value='no'/><span class='bigcheck-target'></span></label>
							</td>

							<td align="middle" width="98%" valign="middle"></td>
						</tr>
					</table>
				</div>
<?php
	if ($array_TP[$chosenMechIndex] == "BA") {
		// Do not show the heat block for all Battle Armor units
		echo "				<div class='dataarea' style='display:none;'>\r\n";
	} else {
		echo "				<div class='dataarea'>\r\n";
	}
?>

					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">ENGN:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_1" id="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_2" id="CD_E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">+1 HT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FCTL:</td>
							<td nowrap width="90%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_1" id="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_2" id="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_3" id="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_4" id="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">+2 TO-HIT</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_1" id="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_2" id="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_3" id="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_4" id="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">1/2 MV</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">WPNS:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_1" id="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_2" id="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_3" id="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_4" id="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">-1 DMG</td>
						</tr>
					</table>
				</div>
			</td>
			<td valign='bottom'>
				<a onclick='showInfoBar();' id="InfoButton" href='#'><img src='./images/selector_02-info.png' width='50px'></a><br>
				<a onclick='showDiceBar();' id="DiceButton" href='#'><img src='./images/selector_01-dice.png' width='50px'></a><br>
				<a onclick='showMoveBar();' id="MoveButton" href='#'><img id='roundphaseshortcutimage' src='./images/selector_04-movement.png' width='50px'></a>
			</td>
		</tr>
	</table>
</div>

<div name='bgrightbar' id='bgrightbar'></div>

<div name='infobar' id='infobar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideInfoBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='infopanel' id='infopanel'>
		<table width="220px">
			<tr>
				<td id='pilotinfo' align="right" valign="bottom">
					<span style="font-size: 18px; color: #eeeeee;"><?php echo "$UNIT"; ?></span><br>
					<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenMechIndex]"; ?></span><br>
					<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_MECH_MODEL[$chosenMechIndex]" ?></span><br><br>
					<!-- Mechwarriors are highly trained and effective warriors.<br><br> -->
					<div id="pilotinfo" valign="bottom" align="right">
						<table cellspacing="0" cellpadding="0">
							<tr>
								<td rowspan="2">
									<?php echo "<img src='".$array_PILOT_IMG_URL[$chosenMechIndex]."' width='84px' height='84px' style='border: 1px solid #000000;'>" ?>
								</td>
								<td style='background-color:#000000;' align='right'>
									<?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='40px' height='40px' style='border: 1px solid #000000;'>" ?>
								</td>
							</tr>
							<tr>
								<td valign='bottom' align='right'>
									<img src='./images/ranks/<?php echo $factionid ?>/<?php echo $array_PILOT_RANK[$chosenMechIndex] ?>.png' style='border: 1px solid #000000;' width='40px' height='40px'>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<div name='movebar' id='movebar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideMoveBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='movepanel' id='movepanel'>
		<table width="100%">
			<tr>
				<td id='moveinfo' align="right" valign="bottom">
					<div id="moveinfo" valign="bottom" align="left">
						<table cellspacing="5" cellpadding="0" width="100%">
							<!--
							<tr>
								<td id="phasemovebutton1" class='phase_button_normal'>
									<a href="#" onclick="">Immobile</a>
								</td>
							</tr>
							-->
							<tr>
								<td id="phasemovebutton2" class='phase_button_normal'>Stationary</td>
							</tr>
							<tr>
								<td id="phasemovebutton3" class='phase_button_normal'>Walked</td>
							</tr>
							<tr>
								<td id="phasemovebutton9" class='phase_button_normal'>Sprinted</td>
							</tr>
							<tr>
								<td id="phasemovebutton4" class='phase_button_normal'>Jumped</td>
							</tr>
						</table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php
	if ($currentMechMovement > 0) {
		echo "<script type='text/javascript'>\n";
		echo "  document.getElementById('phasemovebutton".$currentMechMovement."').className='phase_button_selected';\n";
		echo "</script>\n";
	}
?>

<div name='firebar' id='firebar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideFireBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='firepanel' id='firepanel'>
		<table width="100%">
			<tr>
				<td id='fireinfo' align="right" valign="bottom">
					<div id="fireinfo" valign="bottom" align="left">
						<table cellspacing="5" cellpadding="0" width="100%">
							<tr>
								<td class='phasefirebutton1'>No Fire</td>
							</tr>
							<tr>
								<td class='phasefirebutton2'>Fired Short Range</td>
							</tr>
							<tr>
								<td class='phasefirebutton3'>Fired Medium Range</td>
							</tr>
							<tr>
								<td class='phasefirebutton4'>Fired Long Range</td>
							</tr>
						</table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php
	if ($currentMechFired > 0) {
//		echo "<script type='text/javascript'>\n";
//		echo "  document.getElementById('phasefirebutton".$currentMechFired."').className='phase_button_selected';\n";
//		echo "</script>\n";
	}
?>

<div name='dicebar' id='dicebar'>
	<div name='barclosebutton' id='barclosebutton'>
		<a href='#' onclick='hideDiceBar();'><img src='.\images\selector_03-close.png' width='50px'></a>
	</div>
	<div name='dicepanel' id='dicepanel'>
		<table width="220px">
			<tr>
				<td align="right" valign="bottom">
<?php
	if ($array_TP[$chosenMechIndex] != "BA") {
		echo "                  <div id='criticalhit'></div>\r\n";
	} else {
		echo "                  <div id='criticalhit' style='display:none;'></div>\r\n";
	}
?>
					<div id="dice" valign="middle" align="center">
						<img id="die1" src="./images/dice/d6_0.png" width="65px" height="65px">
						<img id="die2" src="./images/dice/d6_0.png" width="65px" height="65px">
					</div>
				</td>
			</tr>
		</table>
	</div>
</div>

<script type="text/javascript">
	$("#infobar").hide();
	$("#dicebar").hide();
	$("#movebar").hide();
	$("#firebar").hide();
	setCircles(<?=$array_HT[$chosenMechIndex]?>,<?=$array_A[$chosenMechIndex]?>,<?=$array_S[$chosenMechIndex]?>,<?=$array_ENGN[$chosenMechIndex]?>,<?=$array_FRCTRL[$chosenMechIndex]?>,<?=$array_MP[$chosenMechIndex]?>,<?=$array_WPNS[$chosenMechIndex]?>,<?=$array_USEDOVERHEAT[$chosenMechIndex]?>);
</script>

<div id="footer"></div>

<div id="bottomleft"><img src="./images/bottom-left.png" width="200px"></div>

<div align="center" id="settings">
	<!-- <a href="https://www.clanwolf.net/static/files/Rulebooks/CAT35860%20-%20AlphaStrike%20CommandersEdition.pdf" target="_blank"><i class="fas fa-bookmark"></i></a>&nbsp;&nbsp; -->
	<!-- <a href="#" onclick="javascript:window.location.reload(true)"><i class="fas fa-redo"></i></a>&nbsp;&nbsp; -->
	<a href="javascript:changeWallpaper()"><i class="fas fa-image"></i></a>&nbsp;&nbsp;
	<a href="javascript:textSize(0)"><i class="fas fa-minus-square"></i></a>&nbsp;&nbsp;
	<a href="javascript:textSize(1)"><i class="fas fa-plus-square"></i></a>&nbsp;&nbsp;
	<a href="./gui_edit_option.php"><i class="fas fa-cog"></i></a>
</div>

<div id="version">
	<?php echo "$version"; ?>
</div>

<div id="bottomright"><img src="./images/bt-logo2.png" width="250px"></div>

<?php
	// Show AMM
	echo "<script>\n";
	echo "	setMovementFlags($array_MECH_DBID[$chosenMechIndex], movement, weaponsfired);\n";
	echo "	setFireValues(movement, weaponsfired);\n";
	echo "</script>\n";

	if ($movd==1) {
		if ($playable) {
			echo "<div id='editMovementValues' style='display:none;'>\n";
			//echo "	<br>\n";
			echo "	<br>\n";
			echo "	<table width='100%'>\n";
			echo "		<tr>\n";
			echo "			<td width='30%'></td>\n"; // onclick=\"location.href='".$locmeli."'\"
			echo "			<td width='40%'>\n";
			echo "				<div>\n";
			echo "					<table width='100%' class='options' style='margin-left: auto;margin-right: auto;' cellspacing=4 cellpadding=4 border=0px>\n";
//			echo "						<tr>\n";
//			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
//			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 1);' type='checkbox' class='bigcheck' name='MV1_IMMOBILE' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datalabel'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;Immobile\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;\n";
//			echo "							</td>\n";
//			echo "							<td nowrap align='left' class='datavalue_small'>\n";
//			echo "								&nbsp;&nbsp;&nbsp;TMM -4\n";
//			echo "							</td>\n";
//			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 2);' type='checkbox' class='bigcheck' name='MV2_STANDSTILL' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Stationary\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;AMM -1\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM 0\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 3);' type='checkbox' class='bigcheck' name='MV3_MOVED' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Walked\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM #\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 9);' type='checkbox' class='bigcheck' name='MV9_SPRINTED' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Sprinted\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;NO FIRE\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel' style='vertical-align:top;'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 4);' type='checkbox' class='bigcheck' name='MV4_JUMPED' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Jumped\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;AMM +2\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datavalue_small'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM ";

			if ($array_TP[$chosenMechIndex] == "BA") {
				// BA do not use the modifier for jumping
				echo "#+SPCL\n";
			} else {
				echo "#+1+SPCL\n";
			}

			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap colspan='4'><hr></td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
 			echo "							<td id='fire_info_cell_2' nowrap colspan='4' align='left' class='datalabel_disabled_dashed'>\n";
			echo "							    <table width='100%' cellspacing='1'>\n"; // style='background-color:#754743;'
			echo "									<tr>\n";
			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 5);' type='checkbox' class='bigcheck' name='WF5_WEAPONSFIRED' id='WF5_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
 			echo "										</td>\n";
			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 6);' type='checkbox' class='bigcheck' name='WF6_WEAPONSFIRED' id='WF6_WEAPONSFIRED'value='yes'/><span class='bigcheck-target'></span></label>\n";
 			echo "										</td>\n";
//			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 7);' type='checkbox' class='bigcheck' name='WF7_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
// 			echo "										</td>\n";
//			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 8);' type='checkbox' class='bigcheck' name='WF8_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
// 			echo "										</td>\n";
			echo "									</tr>\n";
			echo "									<tr>\n";
			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
			echo "											HOLD FIRE\n";
 			echo "										</td>\n";
			echo "										<td colspan='1' width='50%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
			echo "											FIRED\n";
 			echo "										</td>\n";
//			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 7);' type='checkbox' class='bigcheck' name='WF7_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
// 			echo "										</td>\n";
//			echo "										<td colspan='3' width='25%' nowrap align='center' valign='top' class='datalabel' style='vertical-align:top;text-align:center'>\n";
//			echo "											<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 8);' type='checkbox' class='bigcheck' name='WF8_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
//			echo "										</td>\n";
			echo "									</tr>\n";
//			echo "									<tr>\n";
//			echo "										<td nowrap align='center' class='datalabel' width='1%' style='vertical-align:top;text-align:center'>\n";
//			echo "											Hold\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='right' class='datalabel' width='16%' style='text-align:right;vertical-align:top;'>\n";
//			echo "											S&nbsp;&nbsp;&nbsp;&nbsp;<span style='vertical-align:top;' class='datalabel' id='SDamage'>x</span>\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='right' class='datalabel' width='1%' style='text-align:center;vertical-align:top;'>\n";
//			echo "											|\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='left' class='datalabel' width='16%' style='text-align:left;vertical-align:top;'>\n";
//			echo "											<span style='vertical-align:top;' class='datalabel' id='SMinRoll'>y</span>\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='right' class='datalabel' width='16%' style='text-align:right;vertical-align:top;'>\n";
//			echo "											M&nbsp;&nbsp;&nbsp;&nbsp;<span style='vertical-align:top;' class='datalabel' id='MDamage'>x</span>\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='right' class='datalabel' width='1%' style='text-align:center;vertical-align:top;'>\n";
//			echo "											|\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='left' class='datalabel' width='16%' style='text-align:left;vertical-align:top;'>\n";
//			echo "											<span style='vertical-align:top;' class='datalabel' id='MMinRoll'>y</span>\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='right' class='datalabel' width='16%' style='text-align:right;vertical-align:top;'>\n";
//			echo "											L&nbsp;&nbsp;&nbsp;&nbsp;<span style='vertical-align:top;' class='datalabel' id='LDamage'>x</span>\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='right' class='datalabel' width='1%' style='text-align:center;vertical-align:top;'>\n";
//			echo "											|\n";
//			echo "										</td>\n";
//			echo "										<td nowrap align='left' class='datalabel' width='16%' style='text-align:left;vertical-align:top;'>\n";
//			echo "											<span style='vertical-align:top;' class='datalabel' id='LMinRoll'>y</span>\n";
//			echo "										</td>\n";
//			echo "									</tr>\n";
//			echo "									<tr>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>Dissipate</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:right;'>+TMM<br>+Cover</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>|<br>|</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:left;'>+Behind</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:right;'>+TMM<br>+Cover</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>|<br>|</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:left;'>+Behind</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:right;'>+TMM<br>+Cover</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='vertical-align:top;text-align:center;'>|<br>|</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='vertical-align:top;text-align:left;'>+Behind</td>\n";
//			echo "									</tr>\n";
//			echo "									<tr>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>Heat</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:right;'>+Cover</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>|</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:left;'></td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:right;'>+Cover</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>|</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:left;'></td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:right;'>+Cover</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='1%' style='text-align:center;'>|</td>\n";
//			echo "										<td nowrap colspan='1' class='datavalue_small' width='16%' style='text-align:left;'></td>\n";
//			echo "									</tr>\n";
			echo "								</table>\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "					</table>\n";
			echo "				<div>\n";
			echo "			</td>\n";
			echo "			<td width='30%' valign='top'>\n";
			echo "				<a href='#' onclick=\"location.href='".$locmeli."'\">&nbsp;&nbsp;&nbsp;&nbsp;<img src='./images/confirm.png' width='80px'></a><br>\n";
			echo "			</td>\n";
			echo "		</tr>\n";
			echo "	</table>\n";
			echo "</div>\n";

			echo "<script>\n";
			if ($array_MVMT[$chosenMechIndex] != null) {
				echo "	movement = $array_MVMT[$chosenMechIndex]\n";
			}
			if ($array_WPNSFIRED[$chosenMechIndex] != null) {
				echo "	weaponsfired = $array_WPNSFIRED[$chosenMechIndex]\n";
			}
			echo "	setMovementFlags($array_MECH_DBID[$chosenMechIndex], movement, weaponsfired);\n";
			echo "	setFireValues(movement, weaponsfired);\n";
			echo "  document.getElementById('editMovementValues').style.visibility='visible';\n";
			echo " 	$('#editMovementValues').show();\n";
			echo "</script>\n";
		}
	}
?>

</body>

</html>
