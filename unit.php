<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/

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
	<!-- <meta name="viewport" content="width=1700px, initial-scale=1.0, user-scalable=no"> -->

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
</head>

<body>

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
	require('./db_getdata.php');
?>

<iframe name="saveframe" src="./save.php"></iframe>

<div id="cover"></div>

<div id="header">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
		<tr>
			<td onclick="location.href='./index.html'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;" nowrap>
				<div><a style="color: #eee;" href="./index.html"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
			</td>

			<?php
				$size = sizeof($array_MECH);
				for ($i4 = 1; $i4 <= $size; $i4++) {
					$meli="./unit.php?unit=".$unitid."&chosenmech=".$i4;
					if ($chosenMechIndex == $i4) {
						echo "<td onclick=\"location.href='".$meli."'\" nowrap><div class='mechselect_button_active'><a href='".$meli."'>#".$array_MECH_NUMBER[$i4]." ".$array_MECH[$i4]."</a><br><span style='font-size:16px;'>".$array_PILOT_CALLSIGN[$i4]."</span></div></td>";
					} else {
						echo "<td onclick=\"location.href='".$meli."'\" nowrap><div class='mechselect_button_normal'><a href='".$meli."'>#".$array_MECH_NUMBER[$i4]." ".$array_MECH[$i4]."</a><br><span style='font-size:16px;'>".$array_PILOT_CALLSIGN[$i4]."</span></div></td>";
					}
				}
			?>
		</tr>
	</table>
</div>

<div id="pilotimage">
	<?php echo "<img src='./images/pilots/".$array_PILOT_IMG_URL[$chosenMechIndex]."' width='100px' height='100px'>" ?>
</div>
<div id="faction" align="center">
	<?php echo "<img src='./images/factions/".$FACTION_IMG_URL."' width='60px' height='60px'>" ?>
</div>
<div id="mech_number" align="center"><?= $array_MECH_NUMBER[$chosenMechIndex] ?></div>
<div id="mech">
	<?php echo "<img id='mechimage' src='./images/mechs/".$array_MECH_IMG_URL[$chosenMechIndex]."'>" ?>
</div>

<div id="topleft">
	<span style="font-size: 20px; color: #aaaaaa;">
		<?php echo "$array_MECH[$chosenMechIndex]" ?>-<?php echo "$array_MECH_MODEL[$chosenMechIndex]" ?>&nbsp;<?php echo "\"$array_MECH_CUSTOM_NAME[$chosenMechIndex]\"" ?>
	</span>
	<br>
	<span style="font-size: 30px; color: #da8e25;">
		<?php echo "$array_PILOT[$chosenMechIndex]"; ?>
	</span>
	<br>
	<span style="font-size: 18px; color: #eeeeee;">
		<?php echo "$UNIT"; ?>
	</span>
</div>

<div id="topright">
	<img src="./images/top-right.png" width="220px">
</div>

<div id="player_image">
	<img src="./images/player/Meldric.png" width="150px">
</div>

<div id="pv">
	<span style="font-size: 22px; color: #aaaaaa; vertical-align: middle;">PV:&nbsp;&nbsp;</span>
	<span style="font-size: 48px; color: #da8e25; vertical-align: middle;">
		<?php echo "$array_PV[$chosenMechIndex]"; ?>
	</span>
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
							<td nowrap class="datavalue" width="13%"><?php echo "$array_TMM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">MV:</td>
							<td nowrap class="datalabel" width="13%" style="color:#fff;">
								<?php
									echo "$array_MV[$chosenMechIndex]&rdquo;";
									if ($array_MVJ[$chosenMechIndex] != null) {
										echo "/$array_MVJ[$chosenMechIndex]&rdquo;&nbsp;j";
									}
								?>
							</td>
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
							<td nowrap class="datalabel" width="15%" style="text-align: center;">S (+0):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_DMG_SHORT[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;">M (+2):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_DMG_MEDIUM[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;">L (+4):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_DMG_LONG[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%">OV:</td>
							<td nowrap class="datavalue" width="20%" style="text-align: center;"><?php echo "$array_OV[$chosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="10%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:</td>
							<td nowrap width="60%" style="text-align: right;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="H4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td class="datalabel" width="5%" style="text-align: right;">&nbsp;&nbsp;&nbsp;(SHDN)</td>
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
									echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='A".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;";
								}
							?>
							</td>
						</tr>
						<tr>
							<td nowrap width="5%" class="datalabel">S:</td>
							<td nowrap width="95%" style="color: #aaa;">
							<?php
								for ($i2 = 1; $i2 <= $array_S_MAX[$chosenMechIndex]; $i2++) {
									echo "<label class='bigcheck'><input onchange='readCircles($array_MECH_DBID[$chosenMechIndex]);' type='checkbox' class='bigcheck' name='S".$i2."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;";
								}
							?>
							</td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td width="10%" nowrap class="datalabel" width="100%">SPCL:</td>
							<td width="90%" class="datavalue_thin" style="text-align: left;"><?php echo "$array_SPCL[$chosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

			</td>
			<td width="40%" valign="bottom" align="right">

				<div id="dice" valign="middle" align="center">
					<img id="die1" src="./images/dice/d6_0.png" width="65px" height="65px">
					<img id="die2" src="./images/dice/d6_0.png" width="65px" height="65px">
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">ENGN:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">+1 HT FIRING</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FR-CTRL:</td>
							<td nowrap width="90%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">+2 TO-HIT EA.</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">1/2 MV EA.</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">WPNS:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?= $array_MECH_DBID[$chosenMechIndex] ?>);" type="checkbox" class="bigcheck" name="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">-1 DMG EA.</td>
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
<div id="bottomleft"><img src="./images/bottom-left.png" width="280px"></div>

<div align="center" id="settings">
	<a href="javascript:changeWallpaper()"><i class="fa fa-fw fa-picture-o"></i></a>
	<a href="#" onclick="javascript:window.location.reload(true)"><i class="fa fa-fw fa-refresh"></i></a>
	<a href="javascript:textSize(0)"><i class="fa fa-fw fa-minus-square"></i></a>
	<a href="javascript:textSize(1)"><i class="fa fa-fw fa-plus-square"></i></a>
</div>

<div id="version">
	<?php echo "$version"; ?>
</div>

<div id="bottomright"><img src="./images/bt-logo.png" width="300px"></div>

</body>

</html>
