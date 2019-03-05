<?php
session_start();
// https://www.php-einfach.de/php-tutorial/php-sessions/

function random_pic($dir = 'uploads') {
    $files = glob($dir . '/*.*');
    $file = array_rand($files);
    return $files[$file];
}

	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php'>";
		die();
	}
	$pid = $_SESSION['playerid'];
	$pimage = $_SESSION['playerimage'];
	$hideNotOwnedMech = $_SESSION['option1'];
	$paramunitid = isset($_GET["unitid"]) ? $_GET["unitid"] : "";
	$paramunitname = isset($_GET["unitname"]) ? $_GET["unitname"] : "";
	$addmech = isset($_GET["am"]) ? $_GET["am"] : "";

	if ($addmech == 1) {
		$TON = isset($_GET["TON"]) ? $_GET["TON"] : "";
		$MNU = isset($_GET["MNU"]) ? $_GET["MNU"] : "";
		$TP = isset($_GET["TP"]) ? $_GET["TP"] : "";
		$SZ = isset($_GET["SZ"]) ? $_GET["SZ"] : "";
		$TMM = isset($_GET["TMM"]) ? $_GET["TMM"] : "";
		$MVG = isset($_GET["MVG"]) ? $_GET["MVG"] : "";
		$MVJ = isset($_GET["MVJ"]) ? $_GET["MVJ"] : "";
		$ROLE = isset($_GET["ROLE"]) ? $_GET["ROLE"] : "";
		$DMGS = isset($_GET["DMGS"]) ? $_GET["DMGS"] : "";
		$DMGM = isset($_GET["DMGM"]) ? $_GET["DMGM"] : "";
		$DMGL = isset($_GET["DMGL"]) ? $_GET["DMGL"] : "";
		$OV = isset($_GET["OV"]) ? $_GET["OV"] : "";
		$A = isset($_GET["A"]) ? $_GET["A"] : "";
		$S = isset($_GET["S"]) ? $_GET["S"] : "";
		$PVA = isset($_GET["PVA"]) ? $_GET["PVA"] : "";
		$SPCL = isset($_GET["SPCL"]) ? $_GET["SPCL"] : "";
		$PN = isset($_GET["PN"]) ? $_GET["PN"] : "";
		$PI = isset($_GET["PI"]) ? $_GET["PI"] : "";
		$SKILL = isset($_GET["SKILL"]) ? $_GET["SKILL"] : "";
		$UNITID = isset($_GET["UNITID"]) ? $_GET["UNITID"] : "";
		$MULID = isset($_GET["MULID"]) ? $_GET["MULID"] : "";
		$MODEL = isset($_GET["MODEL"]) ? $_GET["MODEL"] : "";

		$TON = urldecode($TON);
		$MNU = urldecode($MNU);
		$TP = urldecode($TP);
		$SZ = urldecode($SZ);
		$TMM = urldecode($TMM);
		$MVG = urldecode($MVG);
		$MVJ = urldecode($MVJ);
		$ROLE = urldecode($ROLE);
		$DMGS = urldecode($DMGS);
		$DMGM = urldecode($DMGM);
		$DMGL = urldecode($DMGL);
		$OV = urldecode($OV);
		$A = urldecode($A);
		$S = urldecode($S);
		$PVA = urldecode($PVA);
		$SPCL = urldecode($SPCL);
		$PN = urldecode($PN);
		$PI = urldecode($PI);
		$SKILL = urldecode($SKILL);
		$UNITID = urldecode($UNITID);
		$MULID = urldecode($MULID);
		$MODEL = urldecode($MODEL);

		//    MECH
		//    ----------------
		//    mechid
		//    mech_number
		//    mulid
		//    mech_tonnage
		//    as_model
		//    as_pv
		//    as_tp
		//    as_sz
		//    as_tmm
		//    as_mv
		//    as_mvj
		//    as_role
		//    as_skill
		//    as_short
		//    as_short_min
		//    as_medium
		//    as_medium_min
		//    as_long
		//    as_long_min
		//    as_extreme
		//    as_extreme_min
		//    as_ov
		//    as_armor
		//    as_structure
		//    as_threshold
		//    as_specials
		//    mech_imageurl
		//
		//    PILOT
		//    ----------------
		//    pilotid
		//    name
		//    pilot_imageurl
		//    playerid
		//
		//    ASSIGN
		//    ----------------
		//    id
		//    unitid
		//    mechid
		//    pilotid

		$sql_insertmech = "";
		$sql_insertmech = $sql_insertmech."INSERT INTO asc_mech ";
		$sql_insertmech = $sql_insertmech."(mech_number, mulid, mech_tonnage, as_model, as_pv, as_tp, as_sz, as_tmm, as_mv, as_mvj, as_role, as_skill, as_short, as_short_min, as_medium, as_medium_min, as_long, as_long_min, as_extreme, as_extreme_min, as_ov, as_armor, as_structure, as_threshold, as_specials, mech_imageurl) ";
		$sql_insertmech = $sql_insertmech."VALUES (";
		$sql_insertmech = $sql_insertmech."'".$MNU."', ";        // mech_number
		$sql_insertmech = $sql_insertmech."'".$MULID."', ";      // mulid
		$sql_insertmech = $sql_insertmech."'".$TON."', ";        // mech_tonnage
		$sql_insertmech = $sql_insertmech."'".$MODEL."', ";      // as_model
		$sql_insertmech = $sql_insertmech."'".$PVA."', ";        // as_pv
		$sql_insertmech = $sql_insertmech."'".$TP."', ";         // as_tp
		$sql_insertmech = $sql_insertmech."'".$SZ."', ";         // as_sz
		$sql_insertmech = $sql_insertmech."'".$TMM."', ";        // as_tmm
		$sql_insertmech = $sql_insertmech."'".$MVG."', ";        // as_mv
		if ($MVJ == 0) {
			$sql_insertmech = $sql_insertmech."null, ";          // as_mvj
		} else {
			$sql_insertmech = $sql_insertmech."'".$MVJ."', ";    // as_mvj
		}
		$sql_insertmech = $sql_insertmech."'".$ROLE."', ";       // as_role
		$sql_insertmech = $sql_insertmech."'".$SKILL."', ";      // as_skill
		$sql_insertmech = $sql_insertmech."'".$DMGS."', ";       // as_short
		$sql_insertmech = $sql_insertmech."0, ";                 // as_short_min
		$sql_insertmech = $sql_insertmech."'".$DMGM."', ";       // as_medium
		$sql_insertmech = $sql_insertmech."0, ";                 // as_medium_min
		$sql_insertmech = $sql_insertmech."'".$DMGL."', ";       // as_long
		$sql_insertmech = $sql_insertmech."0, ";                 // as_long_min
		$sql_insertmech = $sql_insertmech."0, ";                 // as_extreme
		$sql_insertmech = $sql_insertmech."0, ";                 // as_extreme_min
		$sql_insertmech = $sql_insertmech."'".$OV."', ";         // as_ov
		$sql_insertmech = $sql_insertmech."'".$A."', ";          // as_armor
		$sql_insertmech = $sql_insertmech."'".$S."', ";          // as_structure
		$sql_insertmech = $sql_insertmech."0, ";                 // as_threshold
		$sql_insertmech = $sql_insertmech."'".$SPCL."', ";       // as_specials
		$sql_insertmech = $sql_insertmech."'".$MODEL.".png' ";   // mech_imageurl
		$sql_insertmech = $sql_insertmech.")";
		if (mysqli_query($conn, $sql_insertmech)) {
			// Success
			$newmechid = mysqli_insert_id($conn);
		} else {
			// Error
			echo "Error: " . $sql_insertmech . "<br>" . mysqli_error($conn);
		}

		$sql_insertpilot = "";
		$sql_insertpilot = $sql_insertpilot."INSERT INTO asc_pilot ";
		$sql_insertpilot = $sql_insertpilot."(name, pilot_imageurl) ";
		$sql_insertpilot = $sql_insertpilot."VALUES (";
		$sql_insertpilot = $sql_insertpilot."'".$PN."', ";      // Pilotname
		$sql_insertpilot = $sql_insertpilot."'".$PI."'";        // Pilot image
		$sql_insertpilot = $sql_insertpilot.")";
		if (mysqli_query($conn, $sql_insertpilot)) {
			// Success
			$newpilotid = mysqli_insert_id($conn);
		} else {
			// Error
			echo "Error: " . $sql_insertpilot . "<br>" . mysqli_error($conn);
		}

		$sql_insertassign = "";
		$sql_insertassign = $sql_insertassign."INSERT INTO asc_assign ";
		$sql_insertassign = $sql_insertassign."(unitid, mechid, pilotid) ";
		$sql_insertassign = $sql_insertassign."VALUES (";
		$sql_insertassign = $sql_insertassign.$UNITID.", ";
		$sql_insertassign = $sql_insertassign.$newmechid.", ";
		$sql_insertassign = $sql_insertassign.$newpilotid;
		$sql_insertassign = $sql_insertassign.")";
		if (mysqli_query($conn, $sql_insertassign)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_insertassign . "<br>" . mysqli_error($conn);
		}

		$sql_insertmechstatus = "";
		$sql_insertmechstatus = $sql_insertmechstatus."INSERT INTO asc_mechstatus ";
		$sql_insertmechstatus = $sql_insertmechstatus."(mechid, heat, armor, structure, crit_engine, crit_fc, crit_mp, crit_weapons) ";
		$sql_insertmechstatus = $sql_insertmechstatus."VALUES (";
		$sql_insertmechstatus = $sql_insertmechstatus.$newmechid.", ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0, ";
		$sql_insertmechstatus = $sql_insertmechstatus."0";
		$sql_insertmechstatus = $sql_insertmechstatus.")";
		if (mysqli_query($conn, $sql_insertmechstatus)) {
			// Success
		} else {
			// Error
			echo "Error: " . $sql_insertmechstatus . "<br>" . mysqli_error($conn);
		}
		echo "<meta http-equiv='refresh' content='0;url=./gui_selectunit.php'>";
	}

	// TODO: get a random female name from the pilot names list
	// TODO: get a random male name from the pilot names list
	// --> put into javascript variable





?>

<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Unit creator</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

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
	<script type="text/javascript" src="./scripts/basic.js"></script>
	<script type="text/javascript" src="./scripts/masterunitlist.js"></script>

	<style>
		html, body {
			background-image: url('./images/body-bg_2.jpg');
		}
		table {
			margin-left: auto;
			margin-right: auto;
		}
		.box {
			width: 80%;
			background-color :#transparent;
			top: 50%;
			left: 50%;
		}
		.options {
			border-radius: 5px;
			border-style: solid;
			border-width: 3px;
			padding: 5px;
			background: rgba(60,60,60,0.75);
			color: #ddd;
			border-color: #aaa;
		}
		input, select {
			width: 80px;
			vertical-align: middle;
			color: #ddd;
			border-width: 0px;
			padding: 2px;
			font-family: 'Pathway Gothic One', sans-serif;
		}
		select:focus, textarea:focus, input:focus {
			outline: none;
		}
		select:invalid, input:invalid {
			background: rgba(40,40,40,0.75);;
		}
		select:valid, input:valid {
			background: rgba(70,70,70,0.75);;
		}
	</style>
</head>

<body>
	<script>
		$(document).ready(function() {
			$("#cover").hide();
			fetchMechList();
			document.getElementById("units").selectedIndex = "1";
		});

		function storeNewMech() {
			var url="./gui_createunit.php?am=1";

			// Store new mech
			var TON = document.getElementById('tonnage').value;
			var MNU = document.getElementById('MNU').value;
			var TP = document.getElementById('TP').value;
			var SZ = document.getElementById('SZ').value;
			var TMM = document.getElementById('TMM').value;
			var MV = document.getElementById('MV').value;
			var ROLE = document.getElementById('ROLE').value;
			var DMGS = document.getElementById('DMGS').value;
			var DMGM = document.getElementById('DMGM').value;
			var DMGL = document.getElementById('DMGL').value;
			var OV = document.getElementById('OV').value;
			var A = document.getElementById('A').value;
			var S = document.getElementById('S').value;
			var PVA = document.getElementById('PVA').value;
			var SPCL = document.getElementById('SPCL').value;
			var PN = document.getElementById('PN').value;
			var PI = document.getElementById('PI').value;
			var SKILL = document.getElementById('SKILL').value;
			var UNITID = document.getElementById('UNITID').value;

			var unitslistbox = document.getElementById("units");
			var selIndex = unitslistbox.selectedIndex;
			var selValue = unitslistbox.options[selIndex].value;
			var selText = unitslistbox.options[selIndex].text;
			var MULID = selValue;
			var MODEL = selText;
			MODEL = MODEL.replace(/"/g,"&quot;");
			MODEL = MODEL.replace(/'/g,"&apos;");

			var MVG = 0;
			var MVJ = 0;

			if (MV.indexOf("/") !== -1) {
				var MV_Parts = MV.split('/');
				MVG = MV_Parts[0].match(/\d+/)[0];
				MVJ = MV_Parts[1].match(/\d+/)[0];
			} else if (MV.indexOf("j") !== -1) {
				MVG = MV.match(/\d+/)[0];
				MVJ = MV.match(/\d+/)[0];
			} else {
				MVG = MV.match(/\d+/)[0];
				MVJ = 0;
			}
			url=url+"&TON="+encodeURIComponent(TON);
			url=url+"&MNU="+encodeURIComponent(MNU);
			url=url+"&TP="+encodeURIComponent(TP);
			url=url+"&SZ="+encodeURIComponent(SZ);
			url=url+"&TMM="+encodeURIComponent(TMM);
			url=url+"&MVG="+encodeURIComponent(MVG);
			url=url+"&MVJ="+encodeURIComponent(MVJ);
			url=url+"&ROLE="+encodeURIComponent(ROLE);
			url=url+"&DMGS="+encodeURIComponent(DMGS);
			url=url+"&DMGM="+encodeURIComponent(DMGM);
			url=url+"&DMGL="+encodeURIComponent(DMGL);
			url=url+"&OV="+encodeURIComponent(OV);
			url=url+"&A="+encodeURIComponent(A);
			url=url+"&S="+encodeURIComponent(S);
			url=url+"&PVA="+encodeURIComponent(PVA);
			url=url+"&SPCL="+encodeURIComponent(SPCL);
			url=url+"&PN="+encodeURIComponent(PN);
			url=url+"&PI="+encodeURIComponent(PI);
			url=url+"&SKILL="+encodeURIComponent(SKILL);
			url=url+"&MULID="+encodeURIComponent(MULID);
			url=url+"&MODEL="+encodeURIComponent(MODEL);
			url=url+"&UNITID="+encodeURIComponent(UNITID);

			// alert(url);
			window.location.href = url;
		}
		function createNewPilot(male) {
			if (male == "true") {
				// male pilot
			} else {
				// female pilot
			}
		}
	</script>

<?php
	echo "<div id='player_image'>\n";
	echo "	<img src='./images/player/".$pimage."' width='60px' height='60px'>\n";
	echo "</div>\n";
?>

	<div id="cover"></div>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td nowrap onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php"><i class="fa fa-power-off" aria-hidden="true"></i></a></div>
				</td>
				<td nowrap onclick="location.href='./gui_selectunit.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_selectunit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a unit to play</span></div></td>
				<td nowrap onclick="location.href='./gui_enemies.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_enemies.php'>OPFOR</a><br><span style='font-size:16px;'>Enemy Mechs</span></div></td>
				<td nowrap onclick="location.href='./gui_createunit.php'" width="20%"><div class='mechselect_button_active'><a href='./gui_createunit.php'>ADD MECH</a><br><span style='font-size:16px;'>Create a new unit and pilot</span></div></td>
				<td nowrap onclick="location.href='./gui_createplayer.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_createplayer.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>
				<td nowrap onclick="location.href='./gui_options.php'" width="20%"><div class='mechselect_button_normal'><a href='./gui_options.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td nowrap width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><div id='loggedOnUser'></div></td>
			</tr>
		</table>
	</div>

	<br>

	<form>
		<table class="options" cellspacing=10 cellpadding=5 border=0px>
			<tr>
				<td nowrap class="datalabel" style='text-align:left;'>
					<div>
						<table cellspacing=5 cellpadding=5>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%' colspan='3'>
									Tech: <select required name='tech' id='tech' size='1' onchange="fetchMechList();">
										<option value="2">Clan</option>
										<option value="1">IS</option>
									</select>

									Tons: <select required name='tonnage' id='tonnage' size='1' onchange="fetchMechList();">
										<option value="20">20</option>
										<option value="25">25</option>
										<option value="30">30</option>
										<option value="35">35</option>
										<option value="40">40</option>
										<option value="45">45</option>
										<option value="50">50</option>
										<option value="55">55</option>
										<option value="60">60</option>
										<option value="65">65</option>
										<option value="70">70</option>
										<option value="75">75</option>
										<option value="80">80</option>
										<option value="85">85</option>
										<option value="90">90</option>
										<option value="95">95</option>
										<option value="100">100</option>
									</select>

									Filter: <input required type="text" id="NameFilter" name="NameFilter" onchange="fetchMechList();" style="width:100px">
								</td>
							</tr>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%' colspan='3'>
									<!-- will be filled by 'getMechList();' -->
									<select required name='units' id='units' size='1' onchange="mechSelected();" style="width:300px"></select>
								</td>
							</tr>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='100%' colspan='3'>
									<hr>
									<input required type="hidden" id="TP" name="TP">
									<input required type="hidden" id="SZ" name="SZ">
									<input required type="hidden" id="TMM" name="TMM">
									<input required type="hidden" id="MV" name="MV">
									<input required type="hidden" id="ROLE" name="ROLE">
									<input required type="hidden" id="DMGS" name="DMGS">
									<input required type="hidden" id="DMGM" name="DMGM">
									<input required type="hidden" id="DMGL" name="DMGL">
									<input required type="hidden" id="OV" name="OV">
									<input required type="hidden" id="A" name="A">
									<input required type="hidden" id="S" name="S">
									<input required type="hidden" id="PVA" name="PVA">
									<input required type="hidden" id="SPCL" name="SPCL">
									<input required type="hidden" id="PI" name="PI">
								</td>
							</tr>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='34%'>
									Mech number: <input required type="text" id="MNU" name="MNU" style="width:300px;">
								</td>
								<td nowrap class="datalabel" style='text-align:left;' width='33%'>
									Pilot name: <input type="text" required id="PN" name="PN">
								</td>
								<td nowrap class="datalabel" style='text-align:left;' width='33%'>
									Skill: <select required name='SKILL' id='SKILL' size='1'>
										<option value="0">0</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
									</select>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td nowrap style='text-align:left;vertical-align:top'>
					<div>
						<table width='100%' cellspacing=5 cellpadding=5>
							<tr>
								<td nowrap class="datalabel" style='text-align:left;' width='50%'>
									<br>Add to unit:<br>

									<select required name='UNITID' id='UNITID' size='1' style='width:200px;'>
<?php
	$sql_asc_playersunits = "SELECT SQL_NO_CACHE * FROM asc_unit where playerid=".$pid;
	$result_asc_playersunits = mysqli_query($conn, $sql_asc_playersunits);
	if (mysqli_num_rows($result_asc_playersunits) > 0) {
		while($rowUnits = mysqli_fetch_assoc($result_asc_playersunits)) {
			$unitid = $rowUnits['unitid'];
			$forcename = $rowUnits['forcename'];
			if ($paramunitid == $unitid) {
				echo "										<option value='".$unitid."' selected>".$forcename."</option>\n";
			} else {
				echo "										<option value='".$unitid."'>".$forcename."</option>\n";
			}
		}
	}
?>
									</select>
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td valign="top">
					<a href='#' onClick='storeNewMech();'><i class='fa fa-fw fa-plus-square'></i></a>
				</td>
			</tr>
		</table>
	</form>

</body>

</html>
