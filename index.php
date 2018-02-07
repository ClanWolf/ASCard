<?php
	$file = file_get_contents('./manifest.appcache.php', true);
	$version = substr($file, 26, -12);

	$unitid = 5;
	$choosenMechIndex = 1;
	require_once('./db_getdata.php');
?>

<html lang="en" manifest="./manifest.appcache.php">

<head>
	<title>ClanWolf.net - AplhaStrike Cards</title>
	<meta charset="utf-8">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!-- <meta name="viewport" content="width=1700px, initial-scale=1.0, user-scalable=no"> -->

	<link rel="manifest" href="https://www.clanwolf.net/ASCard/manifest.json">
	<link rel="stylesheet" href="https://www.clanwolf.net/ASCard/styles.css" type="text/css" media="screen">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
	<link rel="icon" href="https://www.clanwolf.net/ASCard/favicon.png" type="image/png">
	<link rel="shortcut icon" href="https://www.clanwolf.net/ASCard/images/icon_196x196.png" type="image/png" sizes="196x196">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_57x57.png" type="image/png" sizes="57x57">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_72x72.png" type="image/png" sizes="72x72">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_76x76.png" type="image/png" sizes="76x76">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_114x114.png" type="image/png" sizes="114x114">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_120x120.png" type="image/png" sizes="120x120">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_144x144.png" type="image/png" sizes="144x144">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_152x152.png" type="image/png" sizes="152x152">
	<link rel="apple-touch-icon" href="https://www.clanwolf.net/ASCard/images/icon_180x180.png" type="image/png" sizes="180x180">
 
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.clanwolf.net/ASCard/scripts/cookies.js"></script>
	<script type="text/javascript" src="https://www.clanwolf.net/ASCard/scripts/howler.min.js"></script>
	<script type="text/javascript" src="https://www.clanwolf.net/ASCard/scripts/functions.js"></script>
</head>

<body>

<iframe name="saveframe" src="https://www.clanwolf.net/ASCard/save.php"></iframe>

<div id="header">
	<table style="width: 100%;" cellspacing="0" cellpadding="0">
		<tr>
			<!--
			<td width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;" nowrap>
				<div><a style="color: #eee;" href="javascript:manage()"><i class="fa fa-bars" aria-hidden="true"></i></a></div>
			</td>
			-->
			<?php
				$size = sizeof($array_MECH);
				for ($i4 = 1; $i4 <= $size; $i4++) {
					echo "<td nowrap><div class='mechselect_button_active'><a href=''>#1</a></div></td>";
				}
			?>
			<!--
			<td nowrap><div class="mechselect_button_active"><a href=''>#1</a></div></td>
			<td nowrap><div class="mechselect_button_normal"><a href=''>#2</a></div></td>
			<td nowrap><div class="mechselect_button_normal"><a href=''>#3</a></div></td>
			<td nowrap><div class="mechselect_button_normal"><a href=''>#4</a></div></td>
			<td nowrap><div class="mechselect_button_normal"><a href=''>#5</a></div></td>
			-->
		</tr>
	</table>
</div>

<div id="pilotimage">
	<?php echo "<img src=\"https://www.clanwolf.net/ASCard/images/pilots/".$array_PILOT_IMG_URL[$choosenMechIndex]."\" width=\"60px\" height=\"60px\">" ?>
</div>
<div id="faction" align="center">
	<?php echo "<img src=\"https://www.clanwolf.net/ASCard/images/factions/".$FACTION_IMG_URL."\" width=\"60px\" height=\"60px\">" ?>
</div>
<div id="mech_number" align="center">123</div>
<div id="mech">
	<?php echo "<img id=\"mechimage\" src=\"https://www.clanwolf.net/ASCard/images/mechs/".$array_MECH_IMG_URL[$choosenMechIndex]."\">" ?>
</div>

<div id="topleft">
	<span style="font-size: 20px; color: #aaaaaa;">
		<?php echo "$array_MECH[$choosenMechIndex]" ?>-<?php echo "$array_MECH_MODEL[$choosenMechIndex]" ?>&nbsp;<?php echo "\"$array_MECH_CUSTOM_NAME[$choosenMechIndex]\"" ?>
	</span>
	<br>
	<span style="font-size: 30px; color: #da8e25;">
		<?php echo "$array_PILOT[$choosenMechIndex]"; ?>
	</span>
</div>

<div id="topright">
	<img src="https://www.clanwolf.net/ASCard/images/top-right.png" width="220px">
</div>

<div id="pv">
	<span style="font-size: 22px; color: #aaaaaa; vertical-align: middle;">PV:&nbsp;&nbsp;</span>
	<span style="font-size: 48px; color: #da8e25; vertical-align: middle;">
		<?php echo "$array_PV[$choosenMechIndex]"; ?>
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
							<td nowrap class="datavalue" width="13%"><?php echo "$array_TP[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">SZ:</td>
							<td nowrap class="datavalue" width="13%"><?php echo "$array_SZ[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">TMM:</td>
							<td nowrap class="datavalue" width="13%"><?php echo "$array_TMM[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%">MV:</td>
							<td nowrap class="datalabel" width="13%" style="color:#fff;">
								<?php
									echo "$array_MV[$choosenMechIndex]&rdquo;";
									if ($array_MVJ[$choosenMechIndex] != null) {
										echo "/$array_MVJ[$choosenMechIndex]&rdquo;&nbsp;j";
									}
								?>
							</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="12%" colspan="1">ROLE:</td>
							<td nowrap class="datavalue_thin" width="38%" colspan="3"><?php echo "$array_ROLE[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="12%" colspan="1">SKILL:</td>
							<td nowrap class="datavalue" width="38%" colspan="3"><?php echo "$array_SKILL[$choosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="10%" style="text-align: left;">DMG:</td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;">S (+0):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_DMG_SHORT[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;">M (+2):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_DMG_MEDIUM[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="15%" style="text-align: center;">L (+4):</td>
							<td nowrap class="datavalue" width="15%" style="text-align: center;"><?php echo "$array_DMG_LONG[$choosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%">OV:</td>
							<td nowrap class="datavalue" width="20%" style="text-align: center;"><?php echo "$array_OV[$choosenMechIndex]"; ?></td>
							<td nowrap class="datalabel" width="10%" style="text-align: right;">&nbsp;&nbsp;&nbsp;HT:</td>
							<td nowrap width="60%" style="text-align: right;">
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="H1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="H2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="H3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="H4" value="yes"/><span class="bigcheck-target"></span></label>
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
								for ($i1 = 1; $i1 <= $array_A_MAX[$choosenMechIndex]; $i1++) {
									echo "<label class='bigcheck'><input onchange='readCircles($choosenMechIndex);' type='checkbox' class='bigcheck' name='A".$i1."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;";
								}
							?>
							</td>
						</tr>
						<tr>
							<td nowrap width="5%" class="datalabel">S:</td>
							<td nowrap width="95%" style="color: #aaa;">
							<?php
								for ($i2 = 1; $i2 <= $array_S_MAX[$choosenMechIndex]; $i2++) {
									echo "<label class='bigcheck'><input onchange='readCircles($choosenMechIndex);' type='checkbox' class='bigcheck' name='S".$i2."' value='yes'/><span class='bigcheck-target'></span></label>&nbsp;";
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
							<td width="90%" class="datavalue_thin" style="text-align: left;"><?php echo "$array_SPCL[$choosenMechIndex]"; ?></td>
						</tr>
					</table>
				</div>

			</td>
			<td width="40%" valign="bottom" align="right">

				<div id="dice" valign="middle" align="center">
					<img id="die1" src="https://www.clanwolf.net/ASCard/images/dice/d6_0.png" width="65px" height="65px">
					<img id="die2" src="https://www.clanwolf.net/ASCard/images/dice/d6_0.png" width="65px" height="65px">
				</div>

				<div class="dataarea">
					<table width="100%">
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">ENGN:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_E_1" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">+1 HT FIRING</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">FR-CTRL:</td>
							<td nowrap width="90%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_FC_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_FC_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_FC_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_FC_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">+2 TO-HIT EA.</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">MP:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_MP_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_MP_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_MP_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_MP_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">1/2 MV EA.</td>
						</tr>
						<tr>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">WPNS:</td>
							<td nowrap width="55%" style="text-align: left;">
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_W_1" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_W_2" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_W_3" value="yes"/><span class="bigcheck-target"></span></label>
								<label class="bigcheck"><input onchange="readCircles(<?=$choosenMechIndex?>);" type="checkbox" class="bigcheck" name="CD_W_4" value="yes"/><span class="bigcheck-target"></span></label>
							</td>
							<td nowrap class="datalabel" width="5%" style="text-align: right;">-1 DMG EA.</td>
						</tr>
					</table>
				</div>

			</td>
		</tr>
	</table>
</div>

<div id="footer"></div>
<div id="bottomleft"><img src="https://www.clanwolf.net/ASCard/images/bottom-left.png" width="280px"></div>

<div align="center" id="settings">
	<a href="javascript:save()"><i class="fa fa-fw fa-floppy-o"></i></a>
	<a href="javascript:changeWallpaper()"><i class="fa fa-fw fa-picture-o"></i></a>
	<a href="index.php"><i class="fa fa-fw fa-refresh"></i></a>
	<a href="javascript:textSize(0)"><i class="fa fa-fw fa-minus-square"></i></a>
	<a href="javascript:textSize(1)"><i class="fa fa-fw fa-plus-square"></i></a>
</div>

<div id="version">
	<?php echo "$version"; ?>
</div>

<div id="bottomright"><img src="https://www.clanwolf.net/ASCard/images/bt-logo.png" width="300px"></div>

</body>

</html>
