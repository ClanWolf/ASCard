<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/
	require('./logger.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
		die();
	}
	$pid = $_SESSION['playerid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedMech = $_SESSION['option1'];
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
	<meta name='viewport' content='user-scalable=0'>

	<link rel="manifest" href="./manifest.json">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
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

	<script type="text/javascript" src="./scripts/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>
	<script type="text/javascript" src="./scripts/functions.js"></script>

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
		function changeMovementFlag(index, fln) {
			var list = document.getElementsByClassName("bigcheck");
			var fired = 0;
			var mv = 0;
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 2) == "MV" && fln != 5) { el1.checked = false }
					if (na.substring(0, 4) == "MV" + fln + "_") {
						el1.checked = true;
						mv = fln;
					}

					if ((na.substring(0, 4) == "MV1_") && el1.checked == true) { mv = 1; }
					if ((na.substring(0, 4) == "MV2_") && el1.checked == true) { mv = 2; }
					if ((na.substring(0, 4) == "MV3_") && el1.checked == true) { mv = 3; }
					if ((na.substring(0, 4) == "MV4_") && el1.checked == true) { mv = 4; }

					if (na == "WF_WEAPONSFIRED" && el1.checked == true) {
						fired = 1;
					}
				}
			})
			var url="./save_movement.php?index="+index+"&mvmt="+mv+"&wpns="+fired;
			window.frames['saveframe'].location.replace(url);
		}
		function setMovementFlags(index, movement, weaponsfired) {
			var list = document.getElementsByClassName("bigcheck");
			[].forEach.call(list, function (el1) {
				na = el1.name;
				if (typeof na != 'undefined') {
					if (na.substring(0, 2) == "MV") { el1.checked = false }

					if ((na.substring(0, 4) == "MV1_") && movement == 1) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV2_") && movement == 2) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV3_") && movement == 3) { el1.checked = true; }
					if ((na.substring(0, 4) == "MV4_") && movement == 4) { el1.checked = true; }

					if (na == "WF_WEAPONSFIRED" && weaponsfired == 1) { el1.checked = true; }
				}
			})
		}
	</script>

<?php
	$file = file_get_contents('./version.txt', true);
	$version = $file;
	if (!isset($_GET["unit"])) {
		echo "<meta http-equiv='refresh' content='0;url=./index.html'> ";
		die();
	}
	$unitid = $_GET["unit"];
	if (empty($unitid)) {
		echo "<meta http-equiv='refresh' content='0;url=./index.html'> ";
		die();
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

	echo "<script>";
	echo "	var shortdamage = ".$array_DMG_SHORT[$chosenMechIndex].";";
	echo "	var mediumdamage = ".$array_DMG_MEDIUM[$chosenMechIndex].";";
	echo "	var longdamage = ".$array_DMG_LONG[$chosenMechIndex].";";
	echo "	var movementpointsground = ".$array_MV[$chosenMechIndex].";";
	if ($array_MVJ[$chosenMechIndex] != null) {
		echo "		var movementpointsjump = ".$array_MVJ[$chosenMechIndex].";";
	} else {
		echo "		var movementpointsjump = 0;";
	}
	echo "	var maximalarmorpoints = ".$array_A_MAX[$chosenMechIndex].";";
	echo "	var maximalstructurepoints = ".$array_S_MAX[$chosenMechIndex].";";
	echo "	var originalmechimage = '".$array_MECH_IMG_URL[$chosenMechIndex]."';";
	echo "	var deadmechimage = 'skull.png';";
	echo "</script>";
?>

<iframe name="saveframe" src="./save.php"></iframe>

<div id="cover"></div>

<div id="header">
	<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
		<tr>
			<td nowrap onclick="location.href='./index.html'" width="50px" style="background:rgba(50,50,50,1.0); text-align:center;vertical-align:middle;">
				<div><a style="color:#eee;" href="./index.html"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
			</td>
			<td>
				<table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_active_left' style="background:rgba(50,50,50,1.0);">
					<tr>
						<td nowrap width='20px' align='center' valign='center'>
							<div style='display:inline-block;height:100%;vertical-align:middle;'>
								<span style='font-size:16px;'>RND</span><br>
								<span style='font-size:16px;color:#ff0;'>1</span>
							</div>
						</td>
					</tr>
				</table>
			</td>

<?php
	$size = sizeof($array_MECH_MODEL);
	$width = ceil(100 / $size);
	for ($i4 = 1; $i4 <= $size; $i4++) {
		$meli="./gui_play_mech.php?unit=".$unitid."&chosenmech=".$i4;
		if ($chosenMechIndex == $i4) {
			if ($movd==1) {
				$meli=$meli."&movd=0";
				$locmeli = $meli;
			} else {
				$meli=$meli."&movd=1";
			}
			echo "<td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_active_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img id='mechstatusimagemenu' style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='30px' width='25px'></div></td><td nowrap width='100%'><div><a href='".$meli."'><span style='font-size:15px;'>".$array_MECH_NUMBER[$i4]."</span> ".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='images/check_green.png' width='20px'><br><span style='font-size:14px;'>".$array_MECH_MODEL[$i4]."</span></div></td></tr></table></td>\r\n";
		} else {
			echo "<td width='".$width."%' nowrap onclick=\"location.href='".$meli."'\"><table width='100%' cellspacing='0' cellpadding='0' class='mechselect_button_normal_left'><tr><td nowrap width='30px' align='center' valign='center'><div style='display:inline-block;height:100%;vertical-align:middle;'><img style='vertical-align:middle;' src='".$array_MECH_IMG_STATUS[$i4]."' height='30px' width='25px'></div></td><td nowrap width='100%'><div><a href='".$meli."'><span style='font-size:15px;'>".$array_MECH_NUMBER[$i4]."</span> ".$array_PILOT[$i4]."</a>&nbsp;&nbsp;<img src='images/check_blue.png' width='20px'><br><span style='font-size:14px;'>".$array_MECH_MODEL[$i4]."</span></div></td></tr></table></td>\r\n";
		}
	}
?>

			<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
		</tr>
	</table>
</div>

<!--
<div id="tablebuttons">
	<p>Buttons for tables</p>
</div>
-->

<div id="pilotimage"><?php echo "<img src='".$array_PILOT_IMG_URL[$chosenMechIndex]."' width='80px' height='80px'>" ?></div>
<div id="faction" align="center"><?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='50px' height='50px'>" ?></div>
<div id="mech_number" align="center"><?= $array_MECH_NUMBER[$chosenMechIndex] ?></div>
<div id="mech"><?php echo "<img id='mechimage' src='".$array_MECH_IMG_URL[$chosenMechIndex]."'>" ?></div>

<div id="topleft">
	<span style="font-size: 18px; color: #eeeeee;"><?php echo "$UNIT"; ?></span>
	<br>
	<span style="font-size: 30px; color: #da8e25;"><?php echo "$array_PILOT[$chosenMechIndex]"; ?></span>
	<br>
	<span style="font-size: 20px; color: #aaaaaa;"><?php echo "$array_MECH_MODEL[$chosenMechIndex]" ?></span>
</div>

<div id="topright">
	<img src="./images/top-right.png" height="150px">
</div>

<?php
	echo "<div id='player_image'>";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>";
	echo "</div>";
	if ($pid == $unitplayerid) {
		// Current Mech is playable by current user
		$playable = true;
	} else {
		$playable = false;
	}

	if (!$playable) {
		if ($hideNotOwnedMech) {
			echo "<div id='blockNotOwnedMechs'></div>";
		}
	}
?>

<div id="pv">
	<span style="font-size: 22px; color: #aaaaaa; vertical-align: middle;">PV:&nbsp;&nbsp;</span>
	<span style="font-size: 48px; color: #da8e25; vertical-align: middle;"><?php echo "$array_PV[$chosenMechIndex]"; ?></span>
</div>

<div class="datatable">
	<table width="100%" style="height: 100%;">
		<tr>
			<td width="60%" valign="bottom">

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="12%">TP:</td>
							<td nowrap class="datavalue" width="13%"><?php echo "$array_TP[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">SZ:</td>
							<td nowrap class="datavalue" width="13%"><?php echo "$array_SZ[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">TMM:</td>
							<td nowrap class="datavalue" width="13%" id="TMM"><?php echo "$array_TMM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">MV:</td>
							<td nowrap class="datavalue_thin" style="text-transform: none;" width="13%" id="mv_points"><?php echo "$array_MV[$chosenMechIndex]&rdquo;";
							if ($array_MVJ[$chosenMechIndex] != null) {
								echo "/$array_MVJ[$chosenMechIndex]&rdquo;&nbsp;j";
							} ?></td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="12%" colspan="1">ROLE:</td>
							<td nowrap class="datavalue_thin" width="38%" colspan="3"><?php echo "$array_ROLE[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%" colspan="1">SKILL:</td>
							<td nowrap class="datavalue" width="38%" colspan="3"><?php echo "$array_SKILL[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="10%" style="text-align: left;">DMG:</td>
							<td nowrap class="datalabel_thin" width="15%" style="text-align: center;" id="minrollshort">S (+0):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgshort_s"><?php echo "$array_DMG_SHORT[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel_thin" width="15%" style="text-align: center;" id="minrollmedium">M (+2):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmgmedium_s"><?php echo "$array_DMG_MEDIUM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel_thin" width="15%" style="text-align: center;" id="minrolllong">L (+4):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;" id="dmglong_s"><?php echo "$array_DMG_LONG[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%">OV:</td>
							<td nowrap class="datavalue" width="20%" style="text-align: center;"><?php echo "$array_OV[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="10%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:</td>
							<td nowrap width="60%" style="text-align: right;" id="ht_field">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H1" id="H1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H2" id="H2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H3" id="H3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H4" id="H4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td class="datalabel" width="5%" style="text-align: right;">&nbsp;&nbsp;&nbsp;(SD)</td>
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
							<td nowrap width="90%" class="datavalue_thin" style="text-align: left;"><?php echo "$array_SPCL[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

			</td>
			<td width="40%" valign="bottom" align="right">

				<div id="criticalhit"></div>

				<div id="dice" valign="middle" align="center">
					<img id="die1" src="./images/dice/d6_0.png" width="65px" height="65px">
					<img id="die2" src="./images/dice/d6_0.png" width="65px" height="65px">
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">ENGN:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_1" id="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_2" id="CD_E_2" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">+1 HT FIRING</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FCTL:</td>
							<td nowrap width="90%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_1" id="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_2" id="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_3" id="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_4" id="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">+2 TO-HIT EA.</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_1" id="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_2" id="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_3" id="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_4" id="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">1/2 MV EA.</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">WPNS:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_1" id="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_2" id="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_3" id="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>, <?= $array_A_MAX[$chosenMechIndex] ?>, <?= $array_S_MAX[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_4" id="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel_thin" width="5%" style="text-align: right;">-1 DMG EA.</td>
						</tr>
					</table>
				</div>

			</td>
		</tr>
	</table>
</div>

<script type="text/javascript">
	setCircles(<?=$array_HT[$chosenMechIndex]?>,<?=$array_A[$chosenMechIndex]?>,<?=$array_S[$chosenMechIndex]?>,<?=$array_ENGN[$chosenMechIndex]?>,<?=$array_FRCTRL[$chosenMechIndex]?>,<?=$array_MP[$chosenMechIndex]?>,<?=$array_WPNS[$chosenMechIndex]?>);
</script>

<div id="footer"></div>
<div id="bottomleft"><img src="./images/bottom-left.png" width="200px"></div>

<div align="center" id="settings">
	<a href="https://www.clanwolf.net/static/files/Rulebooks/CAT35860%20-%20AlphaStrike%20CommandersEdition.pdf" target="_blank"><i class="fa fa-fw fa-bookmark"></i></a>&nbsp;&nbsp;&nbsp;
	<a href="#" onclick="javascript:window.location.reload(true)"><i class="fa fa-fw fa-refresh"></i></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:textSize(0)"><i class="fa fa-fw fa-minus-square"></i></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:textSize(1)"><i class="fa fa-fw fa-plus-square"></i></a>
</div>

<div id="version">
	<?php echo "$version"; ?>
</div>

<div id="bottomright"><img src="./images/bt-logo2.png" width="250px"></div>

<?php
	if ($movd==1) {
		if ($playable) {
			echo "<div id='editMovementValues'>\n";
			echo "	<br>\n";
			echo "	<br>\n";
			echo "	<table width='100%'>\n";
			echo "		<tr>\n";
			echo "			<td width='40%' onclick=\"location.href='".$locmeli."'\"></td>\n";
			echo "			<td width='20%'>\n";
			echo "				<div>\n";
			echo "					<table class='options' style='margin-left: auto;margin-right: auto;' cellspacing=4 cellpadding=4 border=0px>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 1);' type='checkbox' class='bigcheck' name='MV1_IMMOBILE' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM -4\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Prone\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 2);' type='checkbox' class='bigcheck' name='MV2_STANDSTILL' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM 0\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Stationary\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 3);' type='checkbox' class='bigcheck' name='MV3_MOVED' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM $array_TMM[$chosenMechIndex]\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Walked (>1\")\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 4);' type='checkbox' class='bigcheck' name='MV4_JUMPED' value='yes'/><span class='bigcheck-target'></span></label>\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;TMM ";

			if(strpos($array_SPCL[$chosenMechIndex],"JMPS") !== false) {
				// special strong jumpjets
			} else if(strpos($array_SPCL[$chosenMechIndex],"JMPW") !== false) {
				// special weak jumpjets
			} else {
				// no special jumpjets
			}

			echo intval($array_TMM[$chosenMechIndex]) + 1 . "\n";
			echo "							</td>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Jumped\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "						    <td nowrap colspan='3'><hr></td>\n";
			echo "						</tr>\n";
			echo "						<tr>\n";
			echo "							<td nowrap align='left' class='datalabel'>\n";
			echo "								<label class='bigcheck'><input onchange='changeMovementFlag($array_MECH_DBID[$chosenMechIndex], 5);' type='checkbox' class='bigcheck' name='WF_WEAPONSFIRED' value='yes'/><span class='bigcheck-target'></span></label>\n";
 			echo "							</td>\n";
 			echo "							<td nowrap colspan='2' align='left' class='datalabel'>\n";
			echo "								&nbsp;&nbsp;&nbsp;Fired\n";
			echo "							</td>\n";
			echo "						</tr>\n";
			echo "					</table>\n";
			echo "				<div>\n";
			echo "			</td>\n";
			echo "			<td width='40%' onclick=\"location.href='".$locmeli."'\"></td>\n";
			echo "		</tr>\n";
			echo "	</table>\n";
			echo "</div>\n";

			echo "<script>\n";
			echo "	var movement = $array_MVMT[$chosenMechIndex]\n";
			echo "	var weaponsfired = $array_WPNSFIRED[$chosenMechIndex]\n";
			echo "	setMovementFlags($array_MECH_DBID[$chosenMechIndex], movement, weaponsfired);\n";
			echo "</script>\n";
		}
	}
?>

</body>

</html>
