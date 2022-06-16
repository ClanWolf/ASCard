<?php
session_start();
	require('./logger.php');
	require('./db.php');
	if (!isset($_SESSION['playerid'])) {
		echo "Not logged in... redirecting.<br>";
		echo "<meta http-equiv='refresh' content='0;url=./login.php?auto=1'>";
		header("Location: ./login.php?auto=1");
		//die("Check position 4");
	}

	// Get data on units from db
	$pid = $_SESSION['playerid'];
	$pname = $_SESSION['name'];
	$pimage = $_SESSION['playerimage'];
	$opt3 = $_SESSION['option3'];
	$playMode = $opt3;

	$sql_asc_playerround = "SELECT SQL_NO_CACHE * FROM asc_player where playerid = " . $pid . ";";
    $result_asc_playerround = mysqli_query($conn, $sql_asc_playerround);
    if (mysqli_num_rows($result_asc_playerround) > 0) {
        while($row = mysqli_fetch_assoc($result_asc_playerround)) {
            $CURRENTROUND = $row["round"];
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Special abilities</title>
	<meta charset="utf-8">
	<meta http-equiv="expires" content="0">
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=0.75, user-scalable=no" />

	<link rel="manifest" href="./manifest.json">
	<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./styles/styles.css">
	<link rel="stylesheet" type="text/css" href="./styles/jquery.jscrollpane.css">
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
	<script type="text/javascript" src="./scripts/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="./scripts/mwheelIntent.js"></script>
	<script type="text/javascript" src="./scripts/howler.min.js"></script>
	<script type="text/javascript" src="./scripts/cookies.js"></script>

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
		.scroll-pane {
			width: 100%;
			height: 300px;
			overflow: none;
		}
		.horizontal-only {
			height: auto;
			max-height: 200px;
		}
	</style>
</head>

<body>
	<script>
		$(function() {
			$('.scroll-pane').jScrollPane();
		});
		$(document).ready(function() {
			$("#cover").hide();
			var api = $('.scroll-pane').data('jsp');
			api.reinitialise();
		});
	</script>

	<div id="cover"></div>

<?php
	if ($playMode) {
		$buttonWidth = "34%";
	} else {
		$buttonWidth = "17%";
	}
?>

	<div id="header">
		<table style="width:100%;height:60px;border:none;border-collapse:collapse;background:rgba(50,50,50,1.0);" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width: 100px;" nowrap onclick="location.href='./logout.php'" width="60px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./logout.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-power-off" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td style="width: 100px;" nowrap onclick="location.href='./finalizeRound.php'" width="100px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;">
					<div><a style="color: #eee;" href="./finalizeRound.php">&nbsp;&nbsp;&nbsp;<i class="fas fa-redo"></i>&nbsp;&nbsp;&nbsp;</a></div>
				</td>
				<td style="width: 100px;" nowrap onclick="location.href='./finalizeRound.php'" style="background:rgba(1,1,1,1.0);">
					<div style='vertical-align:middle;font-size:28px;color:#ff0;'>&nbsp;&nbsp;&nbsp;R<?php echo $CURRENTROUND ?>&nbsp;&nbsp;&nbsp;</div>
				</td>
				<td nowrap onclick="location.href='./gui_select_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_unit.php'>ROSTER</a><br><span style='font-size:16px;'>Choose a Mech</span></div></td>
				<td nowrap onclick="location.href='./gui_select_enemy_unit.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_select_enemy_unit.php'>FORCES</a><br><span style='font-size:16px;'>All bidding units</span></div></td>

<?php
	if (!$playMode) {
		echo "				<td nowrap onclick=\"location.href='./gui_assign_unit.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_assign_unit.php'>ASSIGN</a><br><span style='font-size:16px;'>Assign Mech/BA</span></div></td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_mech.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_mech.php'>ADD</a><br><span style='font-size:16px;'>Create a Mech/BA</span></div></td>\n";
		echo "				<td nowrap onclick=\"location.href='./gui_create_player.php'\" width='17%'><div class='mechselect_button_normal'><a href='./gui_create_player.php'>PLAYER</a><br><span style='font-size:16px;'>Manage players</span></div></td>\n";
	}
?>

				<td nowrap onclick="location.href='./gui_edit_option.php'" width="<?php echo $buttonWidth ?>"><div class='mechselect_button_normal'><a href='./gui_edit_option.php'>OPTIONS</a><br><span style='font-size:16px;'>Change options</span></div></td>
				<td style="width: 100px;" nowrap width="100px" style="background: rgba(50,50,50,1.0); text-align: center; vertical-align: middle;"><img src='./images/player/<?=$pimage?>' width='60px' height='60px'></td>
			</tr>
		</table>
	</div>

	<br>

	<table width="70%" class="options" cellspacing=4 cellpadding=4 border=0px>
		<tr>
			<td width="15%" nowrap align="center">
				<a href="javascript:window.history.back();"><< Go back</a>
			</td>
			<td width="85%" align="center">
				<a href="#PRB" id="PRBLink" target="_SELF">PRB</a>&nbsp;&nbsp;
				<a href="#AFC" target="_SELF">AFC</a>&nbsp;&nbsp;
				<a href="#AT" target="_SELF">AT</a>&nbsp;&nbsp;
				<a href="#AMP" target="_SELF">AMP</a>&nbsp;&nbsp;
				<a href="#AECM" target="_SELF">AECM</a>&nbsp;&nbsp;
				<a href="#AM" target="_SELF">AM</a>&nbsp;&nbsp;
				<a href="#AMS" target="_SELF">AMS</a>&nbsp;&nbsp;
				<a href="#ARM" target="_SELF">ARM</a>&nbsp;&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<hr>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="left" class='datalabel'>
				<div class="scroll-pane">
					<p id="PRB"><strong>Active Probe (PRB)</strong><br>
						Units equipped with active probes have an extended view of the battlefield, enabling them to provide information about targets without moving into the target’s Short range bracket. The active probe’s effective range is 18”, automatically confers the Recon (RCN) special ability upon its user, and enables it to detect hidden units (see Hidden Units, p. 102), identify incoming sensor blips, or even discover the capabilities of unknown hostile units that fall within this range (see Concealing Unit Data, pp. 87-89). Hostile ECM systems, including Angel ECM (AECM) and standard ECM (ECM) will overwhelm the active probe’s abilities.
					</p>
					<p id="AFC"><strong>Advanced Fire Control (AFC)</strong><br>
						IndustrialMechs and support vehicles equipped with Advanced Fire Control do not suffer to-hit modifiers for their unit type.
					</p>
					<p id="AT"><strong>Aerospace Transport (AT#)</strong><br>
						A unit with this special ability can transport, launch and recover the indicated number of aerospace or conventional fighters (see Aerospace Unit Transports, p. 72).
					</p>
					<p id="AMP"><strong>Amphibious (AMP)</strong><br>
						This ability makes a non-naval unit capable of water  movement. Amphibious<br>
						units pay a total of 4” per inch of water traversed and move as a surface<br>
						naval unit in water, except that they freely move in and out of water areas.
					</p>
					<p id="AECM"><strong>Angel ECM (AECM)</strong><br>
						An Angel ECM suite has all the advantages of a standard ECM suite. Angel<br>
						ECM is treated as two standard ECM suites.
					</p>
					<p id="AM"><strong>Anti-’Mech (AM)</strong><br>
						Infantry units with the Anti-’Mech (AM) special ability can make a<br>
						special attack against any ground units, landed VTOLs and WiGEs, or<br>
						grounded aerospace units with which they are in base-to-base contact.<br>
						Anti-’Mech Infantry attacks are treated as a physical attack<br>
						(see p. 42).
					</p>
					<p id="AMS"><strong>Anti-Missile System (AMS)</strong><br>
						A unit with an AMS reduces the damage by 1 point (to a minimum of 1)<br>
						from any of the following attacks: standard weapon attack from a unit<br>
						with the IF, SRM, or LRM special abilities, Indirect Fire attack<br>
						using the IF special ability, or special weapon attack made using<br>
						the SRM or LRM special abilities. AMS only works on attacks coming<br>
						in the front arc, unless mounted in a turret (TUR).
					</p>
					<p id="ARM"><strong>Armored Components (ARM)</strong><br>
						A unit with this ability ignores the first critical hit chance rolled<br>
						against it during a single Alpha Strike scenario. The first time<br>
						circumstances arise that would normally generate an opportunity<br>
						for a critical hit (such as structure damage), the unit’s<br>
						controlling player must strike off this ability as “spent” for the<br>
						remainder of the scenario, and the attacker loses his first<br>
						opportunity to roll for a critical hit.
					</p>
					<p id="ARS"><strong>Armored Motive Systems (ARS)</strong><br>
						A unit with this special ability applies a –1 modifier on the<br>
						Determining Motive Systems Damage roll (see Determining Motive<br>
						Systems Damage Table, p. 42).
					</p>
					<p id="ARTX"><strong>Artillery (ARTX-#)</strong><br>
						This special ability lets a unit make an artillery attack,<br>
						with an abbreviation for each type of artillery replacing the<br>
						“X” in the ability’s acronym. Each different type of artillery<br>
						a unit carries is listed separately, with the number indicating<br>
						the number of that type carried. For example, a unit with two<br>
						Long Tom artillery weapons would record this as ARTLT-2. Refer<br>
						to the Artillery Abbreviations Table, below (see the Bomb<br>
						(BOMB#) special ability, p. 105, for Arrow IV missiles carried<br>
						as bombs).
					</p>
					<p id="AC"><strong>Autocannon (AC#/#/#/#)</strong><br>
						This unit mounts a significant number of autocannons and may<br>
						fire them together as an alternative weapon attack instead of<br>
						a standard weapon attack. This ability enables the unit to<br>
						use alternate autocannon ammo for modified effects.
					</p>
					<p id="BHJ"><strong>BattleMech HarJel (BHJ)</strong><br>
						A ’Mech protected by HarJel ignores the additional critical<br>
						hit chance incurred by suffering damage while operating<br>
						underwater or in a vacuum. Critical hit chances from normal<br>
						structure damage (and other sources) still apply.
					</p>
					<p id="SHLD"><strong>BattleMech Shield (SHLD)</strong><br>
						Shield-bearing ’Mechs gain some protection against weapon<br>
						and physical attacks at the expense of their own attack<br>
						accuracy. To reflect this, shield-equipped units reduce<br>
						the damage from most weapons and physical attacks by 1<br>
						point (to a minimum of 0). Indirect attacks, heat-causing<br>
						attacks, and area-effect attacks (such as artillery and<br>
						bombs) are not dampened by the shield and thus deliver<br>
						full damage. All weapon attacks made by a ’Mech with<br>
						this ability incur an additional +1 to-hit modifier.
					</p>
					<p id="BH"><strong>Bloodhound Active Probe (BH)</strong><br>
						An enhanced version of the standard active probe (PRB),<br>
						the Bloodhound probe offers all the same features, but<br>
						with an effective range of 26”. Bloodhound probes<br>
						automatically confer the Recon (RCN) special ability<br>
						upon their users, and enable them to detect hidden<br>
						units (see Hidden Units, p. 102), identify incoming<br>
						sensor blips, or discover the capabilities of unknown<br>
						hostile units that fall within this range (see<br>
						Concealing Unit Data, pp. 87-89).
					</p>
					<p>
						In addition to these standard features, the Bloodhound is<br>
						also unaffected by standard and light ECM specials (ECM and<br>
						LECM). Presently, only the Angel ECM (AECM) can overwhelm the<br>
						sensing abilities of the Bloodhound.
					</p>
					<p><strong>Booby Trap (BT)</strong><br>
						The booby trap is a last-ditch weapon. A unit with this<br>
						ability has devoted considerable mass toward a devastating<br>
						selfdestruct mechanism designed inflict damage on nearby<br>
						units as well. The booby trap may be activated during the<br>
						Combat Phase, in place of a weapon or physical attack. Once<br>
						activated, the system automatically destroys the unit and<br>
						delivers an area-effect attack to all units within an area<br>
						covered by a 2” AoE template. Activated on the ground, all<br>
						units in the area of effect suffer damage equal to the<br>
						booby-trapped unit’s weight/size class times half its Move.<br>
						For example, a booby-trapped assault ’Mech with a Move of 6”<br>
						would deliver 12 points of damage (Size 4 x [Move 6” ÷ 2] =<br>
						12) to all units in its area of effect.
					</p>
					<p>
						<em>Airborne Booby Traps:</em> A booby trap that is activated<br>
						in the air by units using on the Radar Map has no effect in<br>
						Alpha Strike gameplay. Airborne units on the ground map that<br>
						activate a booby trap inflict damage in a 2” AoE template<br>
						centered on a point, as chosen by the player. All units on<br>
						the ground within that area of effect suffer damage equal<br>
						to the booby-trapped unit’s weight/size class. Thus, while<br>
						a heavy aerospace fighter with a booby trap would inflict<br>
						no damage on the Radar Map, if it were flying over the<br>
						ground map and chose to self destruct, its damage to all<br>
						units within the area covered by the 2” AoE template<br>
						centered on a point on its flight path would be 3<br>
						points.
					</p>
					<p id="BOMB"><strong>Bomb (BOMB#)</strong><br>
						Conventional and aerospace fighters, fixed-wing support<br>
						vehicles, and some battle armor can carry bombs. The<br>
						number of bombs these units can carry are equal to the<br>
						number in the ability’s notation (so a unit with BOMB4<br>
						carries up to 4 bombs). For most units, these bombs may<br>
						be of any type, though battle armor units with this<br>
						ability may only use cluster bombs (see p. 57). (As a<br>
						special exception, Arrow IV missiles of all types may<br>
						be carried as bombs, but a unit that uses Arrow IV bombs<br>
						must count the first Arrow IV missile carried this way<br>
						as 2 bombs. All remaining bombs are then counted<br>
						normally.)
					</p>
					<p>
						Each bomb a unit carries reduces its Thrust value by 1.<br>
						(Battle armor units with bombs suffer no effects on their<br>
						Move ratings.) A bomb-carrying unit’s card should list how<br>
						many bombs the unit is carrying in the scenario, which must<br>
						be equal to or less than the number this ability enables it<br>
						to carry.
					</p>
					<p id="BRID"><strong>Bridgelayer (BRID)</strong><br>
						A unit with this special ability may deploy a temporary bridge<br>
						capable of spanning gaps up to 2 inches in width. Multiple<br>
						bridges may be linked together to extend the reach of an existing<br>
						bridge. Deploying or extending a bridge takes one turn,<br>
						during which the bridgelayer unit cannot move. After the bridge is<br>
						deployed, the bridgelaying unit may move normally. A bridge does<br>
						not need to be deployed such that each side of the bridge rests<br>
						on solid ground; it may be deployed as a makeshift dock extending<br>
						into water. Bridges placed by bridgelayer units are temporary in<br>
						nature. Once a bridgelayer unit places a bridge, it may not place<br>
						another for the remainder of the scenario unless it removes the<br>
						original. Removing one of these temporary bridges may only be done<br>
						by non-infantry bridgelayer units, and requires the unit to remain<br>
						in base-contact with the bridge being removed for the entire turn,<br>
						with no other units passing over the bridge in that same turn.
					</p>
					<p>
						All bridgelayer bridges automatically float on water, as they contain<br>
						integral flotation devices by design. Bridges placed by a non-infantry<br>
						unit with this ability have a CF of 18 and may support units of Size<br>
						class 3. The bridge may be targeted as a building and will be<br>
						destroyed once its CF is reduced to 0. A bridge reduced to 10 points<br>
						or less may only support units up to Size 2. Bridges reduced to 5 or<br>
						fewer points it may only support Size 1 units.
					</p>
					<p>
						If a unit that exceeds a bridge’s Size limit attempts to use it, the<br>
						bridge immediately collapses once the unit moves onto it. All units<br>
						on a bridge when it collapses will fall and suffer 1 point of damage<br>
						per 3 inches (or fraction thereof) of difference between the starting<br>
						level and destination level, rolling for critical hits as normal. If<br>
						the unit falls into prohibited terrain as a result of a bridge<br>
						collapse, it is destroyed.
					</p>
					<p><em>Infantry Bridgelayers:</em><br>
						Infantry with this ability may erect a bridge using gear and parts<br>
						carried with them for the task, but may only do so once per scenario.<br>
						Infantry bridgelayers require 2 turns to complete their bridges, which<br>
						possess a starting CF of 8, and can support units up to Size 2.
					</p>
					<p id="CAP"><strong>Capital Weapons (CAP)</strong><br>
						Capital weapons are large weapons that are seen only on truly massive<br>
						installations, mobile structures, and WarShips Because their use is<br>
						almost exclusively limited to combat between units in orbital space<br>
						and beyond, their use is beyond the general scope of the ground war<br>
						game presented in this book. Nevertheless, in certain limited<br>
						instances where they may be used, consult the Capital and<br>
						Sub-Capital Weapons rules (see pp. 86-87).
					</p>
					<p id="CK"><strong>Cargo Transport, Kilotons (CK#)</strong><br>
						This ability is identical to the Cargo Transport–Tons ability, except<br>
						that the numerical designation for this special ability represents<br>
						cargo capacity in 1,000-ton lots. This may be a decimal value, so a<br>
						unit with CK3.57 would have a cargo capacity of 3,570 tons (1,000<br>
						tons x 3.57 = 3,570 tons).
					</p>
					<p id="CT"><strong>Cargo Transport, Tons (CT#)</strong><br>
						Units with this special ability have bays or other internal space<br>
						set aside for carrying bulk cargo such as munitions, supplies and<br>
						the like. This space is not generally suited for transporting<br>
						battleready units like vehicles, ’Mechs, or infantry, and such<br>
						units may not be dropped or deployed from cargo bays as a<br>
						result—though they can be carried as cargo (see Units as Cargo,<br>
						p. 64). This ability usually applies to DropShips, and is always<br>
						used in conjunction with the Door (D#) special ability. The<br>
						numerical value in this ability indicates how many tons of cargo<br>
						the unit may transport.
					</p>
					<p id="CASE"><strong>Cellular Ammunition Storage Equipment (CASE)</strong><br>
						Units with this ability can minimize the catastrophic effects of<br>
						an ammunition explosion and thus can survive Ammo Hit critical<br>
						hits (see Ammo Hit, p. 18), but will suffer additional damage.
					</p>
					<p id="CASEII"><strong>Cellular Ammunition Storage Equipment II (CASEII)</strong><br>
						Units with this ability have superior protection against ammunition<br>
						explosions and can ignore Ammo Hit critical hits (see Ammo Hit, p.<br>
						18).
					</p>
					<p id="CRW"><strong>Crew (CRW#)</strong><br>
						Non-DropShip units with this ability can temporarily inflict a Crew<br>
						Stunned critical hit on themselves, while DropShip units can<br>
						temporarily inflict a Crew Hit critical on themselves instead.<br>
						Doing so enables these units to deploy a number of infantry<br>
						units—equal to the number rating of this ability—as additional<br>
						marines to aid in repelling enemy boarding parties. These foot<br>
						infantry units have a Move of 2”f, 2 Armor points, 1 Structure point,<br>
						and Damage Values of 1 at Short and Medium range (see Boarding<br>
						Actions, p. 98).
					</p>
					<p id="CR"><strong>Critical-Resistant (CR)</strong><br>
						A unit with this special ability features special armor or other<br>
						protective features that reduces the chance and severity of a<br>
						critical hit (including damage to structure, damage effects from<br>
						armor-penetrating weapons, and hull breaches while in vacuum or<br>
						underwater). Any time an attack on this unit prompts a roll on<br>
						its Critical Hits Table, apply a –2 modifier to the Critical Hit<br>
						roll. Modified critical results of 1 or less are treated as No<br>
						Critical Hit results.
					</p>
					<p id="D"><strong>Door (D#)</strong><br>
						This ability indicates the number of ingress/egress doors<br>
						available on a DropShip, small craft, or support vehicles’<br>
						transport bays. Each door a unit has is tied to a particular<br>
						bay, and can accommodate a limited number of units per turn<br>
						(see Transporting Non-Infantry Units, p. 63).
					</p>
					<p id="DRO"><strong>Drone (DRO)</strong><br>
						Units with this special ability are unmanned units capable of<br>
						movement and (occasionally) combat. Ground drones must stay<br>
						within 900” of their control vehicle, unless the control<br>
						vehicle is airborne or in orbit, in which case range is<br>
						functionally limitless for a ground game. In space, drones<br>
						need only remain within LOS to their controller, as the actual<br>
						range limit is more than 100,000”.
					</p>
					<p>
						Drones enveloped in a hostile ECM field shut down during the<br>
						End Phase of the turn in which they were trapped by the field.<br>
						They remain shut down until the ECM field is no longer present.<br>
						Drones restart automatically in the End Phase of the turn in<br>
						which the ECM field is removed. If the drone control unit is<br>
						caught by a hostile ECM field, all of its drones shut down until<br>
						the ECM field is no longer present. In addition, if the LOS from<br>
						a drone control unit to its drone passes through an ECM bubble,<br>
						the drone will shut down. This is frequently avoided by the use<br>
						of Satellite uplinks for drone control. If the drone control unit<br>
						is eliminated, the drones shut down for the rest of the game.
					</p>
					<p>
						When not affected by hostile ECM, and as long as their control<br>
						units (see below) are operational, drone units may Move, attack,<br>
						spot for indirect fire, and use special abilities as an<br>
						equivalent unit of the same motive type and capabilities. The<br>
						Skill rating of a drone is equal to that of its controller’s<br>
						Skill, plus 1.
					</p>
					<p><strong>Drone Carrier Control System (DCC#)</strong><br>
						Units with the drone carrier control system (DCC) special<br>
						ability may control units with the drone (DRO) special.<br>
						The numerical value of this ability indicates the number<br>
						of drones the unit can control. All drones controlled by<br>
						this unit will shut down if the control unit is destroyed,<br>
						disabled, or enveloped in hostile ECM fields.
					</p>
					<p id="DUN"><strong>Dune Buggy (DUN)</strong><br>
						A unit with this special ability can move more easily over<br>
						Sand (see Advanced Terrain, p. 64).
					</p>
					<p id="ECM"><strong>Electronic Countermeasures (ECM)</strong><br>
						In Alpha Strike, an ECM suite’s area of effect covers a<br>
						12-inch radius from the unit that has this special ability.<br>
						Electronics (including active probes and C3 computers) used<br>
						by units friendly to the ECM-equipped unit will not be<br>
						affected by this item, nor will an ECM suite affect other<br>
						scanning and targeting devices (such as basic or advanced<br>
						fire control, or TAG).
					</p>
					<p id="ES"><strong>Ejection Seat (ES)</strong><br>
						The pilot of a unit with an ejection seat may abandon his<br>
						unit at any time using the unit’s on-board ejection system.<br>
						The pilot with an ejection seat is also automatically ejected<br>
						if his unit suffers an Ammo Hit critical and does not feature<br>
						a CASE or CASEII special (see Ejection/Abandoning Units, p.<br>
						91).
					</p>
					<p id="ENG"><strong>Engineering (ENG)</strong><br>
						A unit with this special ability can clear woods just like a<br>
						unit with the Saw special ability (see Saw, p. 107). In<br>
						addition, a unit with this ability can clear a path through<br>
						rubble. It takes 1 turn for a group of 4 or more units with<br>
						the Engineering special to clear a 2” long path of rubble,<br>
						2 turns for 3 units, 3 turns for 2 units and 4 turns for<br>
						1 unit.
					</p>
					<p>
						An area cleared by engineering units does not actually change<br>
						its terrain type; the clearing action simply creates a narrow,<br>
						clear path through it that units may use to pass through the<br>
						terrain as if it is clear. (For further explanation, see<br>
						Terrain Conversion, p. 104.)
					</p>
					<p id="ENE"><strong>Energy (ENE)</strong><br>
						A unit with this ability has little to no ammo to explode, and<br>
						ignores Ammo Hit critical hits (see Ammo Hit, p. 18).
					</p>
					<p id="SEAL"><strong>Environmental Sealing (SEAL)</strong><br>
						A unit with this special ability may operate in hostile<br>
						environments (including underwater, vacuum, and so forth).<br>
						Aerospace units, ProtoMechs, combat vehicles and support<br>
						vehicles built as submarines are automatically treated as<br>
						if they have this ability.
					</p>
					<p id="FF"><strong>Firefighter (FF)</strong><br>
						Firefighter units may put out fires within 2” of their<br>
						position. This action requires a 2D6 roll of 8+, made in<br>
						place of a weapon attack. Reduce this target number by 1<br>
						for each turn the unit spends fighting a fire, and for each<br>
						additional unit engaged in fighting the same fire (to a maximum<br>
						target number modifier of –3).
					</p>
					<p id="FLK"><strong>Flak (FLK#/#/#/#)</strong><br>
						If a unit with this ability misses its to-hit roll by 2 points<br>
						or less when attacking an airborne aerospace unit, VTOL or WiGE<br>
						target, the unit will deal damage to its target equal to its<br>
						FLK rating at the appropriate range bracket.
					</p>
					<p id="FD"><strong>Flight Deck (FD)</strong><br>
						A unit with this special ability can be used as a landing area<br>
						by an aerospace fighter, conventional fighter, small craft,<br>
						fixedwing support vehicle, airship support vehicle, or VTOL unit.
					</p>
					<p id="HT"><strong>Heat (HT#/#/#)</strong><br>
						Units with this ability apply heat to the target’s Heat scale<br>
						during the End Phase of the turn in which they deliver a<br>
						successful weapon attack. If the target is a unit type that does<br>
						not use a Heat Scale, the heat this ability would normally<br>
						produce is added to the normal attack damage instead (see<br>
						Determine and Apply Damage, p. 17).
					</p>
					<p id="HELI"><strong>Helipad (HELI)</strong><br>
						A unit with this special ability can be used as a landing area<br>
						by a unit with VTOL movement.
					</p>
					<p id="IF"><strong>Indirect Fire (IF#)</strong><br>
						The Indirect Fire special ability allows a unit to attack a<br>
						target without having a valid LOS to it via arcing missiles<br>
						over the intervening obstacles, similar to how mortars and<br>
						artillery work. This attack requires a friendly unit with a<br>
						valid LOS to act as a spotter. The numerical rating for this<br>
						ability indicates the amount of damage a successful indirect<br>
						attack will deliver. Because they attack when other weapons<br>
						cannot, damage from an indirect attack applies in place of<br>
						the unit’s normal weapon attack (see Indirect Fire, p. 35).
					</p>
					<p id="INARC"><strong>Improved Narc Missile Beacon (iNARC#)</strong><br>
						A unit with the INARC# special ability may make an extra weapon<br>
						attack using its iNarc missile beacon device. A unit hit by an<br>
						iNarc beacon will not suffer damage from the iNarc itself, but<br>
						will suffer 1 additional point of damage from any Indirect Fire<br>
						(IF), LRM, or SRM attacks for the rest of the game—unless the<br>
						unit is within a friendly ECM bubble. The iNarc beacon launcher<br>
						is usable up to the Medium range bracket. Instead of their normal<br>
						attack, iNarc launchers may fire specialty ammo (see Alternate<br>
						Munitions, p. 76). The numerical value of this ability indicates<br>
						the number of extra iNarc beacon attacks the unit can deliver in<br>
						a single turn.
					</p>
					<p id="LG"><strong>Large (LG)</strong><br>
						Large units cover a 2” AoE template area. Large units block LOS.
					</p>
					<p id="LPRB"><strong>Light Active Probe (LPRB)</strong><br>
						Light active probes function in the same way as standard active<br>
						probes, but only have an effective range of 12”. As with standard<br>
						probes, light probes automatically confer the Recon (RCN) special<br>
						ability upon their users, and enable them to detect hidden units<br>
						(see Hidden Units, p. 102), identify incoming sensor blips, or<br>
						discover the capabilities of unknown hostile units that fall within<br>
						this range (see Concealing Unit Data, pp. 87-89).
					</p>
					<p>
						Hostile ECM systems, including Angel ECM (AECM) and standard ECM<br>
						(ECM) will overwhelm the light active probe’s abilities.
					</p>
					<p id="LECM"><strong>Light ECM (LECM)</strong><br>
						Light ECM functions identically to ECM, but with a reduced radius.<br>
						Light ECM only creates an ECM bubble with a 2” radius.
					</p>
					<p id="LTAG"><strong>Light Target Acquisition Gear (LTAG)</strong><br>
						A unit with Light TAG can “paint” targets for artillery homing<br>
						rounds (see Artillery, p. 73) in the same way as a unit with<br>
						standard target acquisition gear (TAG). Light TAG may only be<br>
						used in the Short range bracket.
					</p>
					<p id="LRM"><strong>Long-Range Missiles (LRM#/#/#/#)</strong><br>
						This unit mounts a significant number of long-range missile<br>
						launchers and may fire them together as an alternative weapon<br>
						attack instead of a standard weapon attack. This ability enables<br>
						the unit to use alternate LRM ammo for modified effects (see<br>
						Alternate Munitions, p. 76).
					</p>
					<p id="MAG"><strong>Maglev (MAG)</strong><br>
						A variation of the Rail (RAIL) special ability (see Rail, p. 108),<br>
						units with magnetic levitation (maglev) systems may only travel<br>
						along rail terrain designated for maglev units.
					</p>
					<p id="MT"><strong>’Mech Transport (MT#)</strong><br>
						A unit with this special ability can transport, deploy, and drop<br>
						the indicated number of ’Mechs. This ability usually applies to<br>
						DropShips, and is always used in conjunction with the Door special<br>
						ability (see Transporting Non-Infantry Units, and Dropping Troops,<br>
						pp. 63 and 90, respectively).
					</p>
					<p id="MEL"><strong>Melee (MEL)</strong><br>
						This special ability indicates that the ’Mech is equipped with a<br>
						physical attack weapon, and adds 1 additional point of physical<br>
						attack damage on a successful Melee-type physical attack (see<br>
						Resolving Physical Attacks, p. 19).
					</p>
					<p id="MDS"><strong>Mine Dispenser (MDS#)</strong><br>
						This ability allows a unit to create minefields in areas through<br>
						which it travels (see Minefields, p. 102). Record this ability<br>
						as MDS# where # is the number of mine dispensers mounted on the<br>
						unit. Each mine dispenser deploys a density 1 minefield. Multiple<br>
						deployments in the same location increase the density of the<br>
						minefield by 1 each, to a maximum density of 5.
					</p>
					<p id="MSW"><strong>Minesweeper (MSW)</strong><br>
						A unit with a minesweeper automatically clears any minefields it<br>
						is in base contact with at the end of the Movement Phase (see<br>
						Minefields, p. 102). During the minesweeper’s Combat Phase, it<br>
						may not execute any attacks, but must roll 2D6 to clear the<br>
						minefield, applying a +4 modifier to the result if the<br>
						minesweeping unit is not infantry. If the result is 10 or better,<br>
						the minefield is cleared and removed from the map. If the result<br>
						is 5 or less, the minefield detonates for its full effects. Any<br>
						other roll result means the minefield is not cleared.
					</p>
					<p id="MSL"><strong>Missile (MSL #/#/#/#)</strong><br>
						Units with this special ability are aerospace units that have<br>
						been outfitted with capital and/or sub-capital scale missile<br>
						launchers. Though these weapons are treated as artillery when<br>
						attacking the ground, they cannot use alternative munitions<br>
						under these rules.
					</p>
					<p>
						Consult the Capital and Sub-Capital Weapons rules to resolve<br>
						combat using these weapons (see pp. 86-87).
					</p>
					<p id="MHQ"><strong>Mobile Headquarters (MHQ#)</strong><br>
						The standard MHQ is equipped with a wide array of special equipment<br>
						to coordinate engagements over a large area. This ability provides<br>
						different bonuses depending on the numerical rating (see Battlefield<br>
						Intelligence, p. 82).
					</p>
					<p id="MTN"><strong>Mountain Troops (MTN)</strong><br>
						Infantry units with this special ability may climb 2 inches per<br>
						inch moved forward in a turn.
					</p>
					<p id="CNARC"><strong>Narc Missile Beacon (CNARC#)</strong><br>
						A unit with the CNARC# or SNARC# special ability may make an extra<br>
						weapon attack using its Narc missile beacon device. A unit hit by<br>
						a Narc beacon will not suffer damage from the Narc itself, but<br>
						will suffer 1 additional point of damage from any Indirect Fire<br>
						(IF), LRM, or SRM attacks for the rest of the game—unless the unit<br>
						is within a friendly ECM bubble. Standard Narc beacon launchers<br>
						(indicated by SNARC) have a maximum range of Medium, while Compact<br>
						Narc beacon launchers (CNARC) have a maximum range of Short.
					</p>
					<p id="SNARC"><strong>Narc Missile Beacon (SNARC#)</strong><br>
						A unit with the CNARC# or SNARC# special ability may make an extra<br>
						weapon attack using its Narc missile beacon device. A unit hit by<br>
						a Narc beacon will not suffer damage from the Narc itself, but will<br>
						suffer 1 additional point of damage from any Indirect Fire (IF),<br>
						LRM, or SRM attacks for the rest of the game—unless the unit is<br>
						within a friendly ECM bubble. Standard Narc beacon launchers<br>
						(indicated by SNARC) have a maximum range of Medium, while Compact<br>
						Narc beacon launchers (CNARC) have a maximum range of Short.
					</p>
					<p>
						Instead of their normal attack, Narc launchers may fire specialty ammo<br>
						(see Alternate Munitions, p. 76). The numerical value of this ability<br>
						indicates the number of extra Narc beacon attacks the unit can deliver<br>
						in a single turn.
					</p>
					<p id="OMNI"><strong>Omni (OMNI)</strong><br>
						In standard Alpha Strike play, ground-based Omni units (’Mechs or<br>
						vehicles) may transport a single battle armor unit using the mechanized<br>
						battle armor rules (see Transporting Infantry, p. 32).
					</p>
					<p id="OVL"><strong>Overheat Long (OVL)</strong><br>
						A unit with this special ability may overheat up to its OV value and<br>
						apply that value to its Long range damage value as well as the unit’s<br>
						Short and Medium range damage values. (A unit without this special<br>
						ability may only apply the damage benefits of its Overheat capabilities<br>
						to damage delivered in the Short and Medium range brackets.)
					</p>
					<p id="PAR"><strong>Paratroops (PAR)</strong><br>
						These units may dismount from airborne transport units (including<br>
						aerospace units) just like jump infantry.
					</p>
					<p id="PNT"><strong>Point Defense (PNT#)</strong><br>
						Unless it is shut down, a unit protected by a point defense system<br>
						automatically engages any missiles that attack it. Unlike an<br>
						anti-missile system (AMS), the point defense system may engage<br>
						Arrow IV, capital or sub-capital missiles as well as missile<br>
						attacks delivered using the IF, SRM, and LRM specials. Point<br>
						defense has a 360-degree arc of fire, and is always successful,<br>
						so no to-hit roll is required. Point defense generates a number<br>
						of “defensive damage points” equal to the ability’s numerical<br>
						rating. Thus, a unit with a PNT6 special would generate 6 points<br>
						of “defensive damage” per turn. This damage is distributed among<br>
						incoming missiles at the controlling player’s discretion. If an<br>
						incoming missile delivers no damage to begin with, any amount of<br>
						defensive damage from a point defense ability will destroy the<br>
						incoming missile before it can attack.
					</p>
					<p>
						For all other incoming missiles, 1 point of defensive damage will<br>
						apply a +1 to-hit modifier to the missile’s attack roll, and reduce<br>
						the incoming attack’s damage value by half (rounded down, to a minimum<br>
						of 0 points). If 2 or more points of defensive damage are assigned to<br>
						an incoming missile attack, the attack is eliminated entirely.
					</p>
					<p><strong>ProtoMech Transport (PT#)</strong><br>
						A unit with this special ability can transport, deploy, and drop the<br>
						indicated number of ProtoMechs. This ability usually applies to<br>
						DropShips, and is always used in conjunction with the Door special<br>
						ability (see Transporting Non-Infantry Units and Dropping Troops,<br>
						pp. 63, 90, respectively).
					</p>
					<p id="RAIL"><strong>Rail (RAIL)</strong><br>
						A unit with the Rail special can only move along rails.
					</p>
					<p id="RCA"><strong>Reactive Armor (RCA)</strong><br>
						A unit with reactive armor is resistant to damage from explosive<br>
						ordnance, particularly those delivered by artillery and missile<br>
						weaponry. If a unit with this special is struck by damage from<br>
						any area-effect attack, or by any attacking using the ART, BOMB,<br>
						MSL, or FLK specials, reduce the damage from these attacks by<br>
						half before applying it (rounding down). For any attack against<br>
						a unit with reactive armor by a unit with the IF, LRM, or SRM<br>
						specials, reduce the amount of attack’s damage by half of the<br>
						LRM or SRM special’s value at the appropriate range (rounding<br>
						up). If reactive armor reduces damage below 1 point, treat the<br>
						attack as delivering 1 point.
					</p>
					<p>
						Note that this damage reducing effect even covers general attacks<br>
						by units that possess such abilities, so if a unit that can deliver<br>
						4 points of damage at Short range attacks a target with reactive<br>
						armor, and the attacker has the SRM 2/2 special, the damage<br>
						delivered is 3 points (4 points total – (2 ÷ 2) = 3).
					</p>
					<p><strong>Recon (RCN)</strong><br>
						The recon ability works in conjunction with the Mobile Headquarters<br>
						(MHQ#) ability. Every unit with the recon special confers a +1<br>
						initiative bonus to itself and 3 other units.
					</p>
					<p id="RFA"><strong>Reflective Armor (RFA)</strong><br>
						A unit with reflective armor is resistant to damage from energy<br>
						weapons, including flamers, but is much more susceptible to physical<br>
						attacks, area-effect weapons, and armor-penetrating hits. If a unit<br>
						with this special is struck by an air-to-ground strafing attack, or<br>
						by a weapon attack by a unit with the ENE special, or by an attack<br>
						using the HT special, reduce this damage (or heat) by half before<br>
						applying it. (Round this damage down, to a minimum of 1 point of<br>
						damage or heat applied from that attack type.) If, on the other hand,<br>
						a unit with this ability suffers damage from any physical attack, an<br>
						area-effect attack, or by any attack using the ART, BOMB, FLK, or MSL<br>
						specials, double the damage applied by that attack.
					</p>
					<p>
						For all other attacks against a unit with reflective armor, reduce the<br>
						total damage applied by 1 point (to a minimum of 1 point). Finally, all<br>
						critical hits suffered by a unit equipped with reflective armor apply a +2<br>
						modifier on the unit’s Critical Hits Table. Modified critical results of 13<br>
						or higher are treated as Engine Hits. Note that this damage reducing (and<br>
						increasing) effect even covers general attacks by such units that possess<br>
						such abilities, so if a unit that can deliver 4 points of damage at Short<br>
						range attacks a target ’Mech with reflective armor, and the attacker also<br>
						has the HT2 special, the attack will deliver 3 points of damage (4 – 1 = 3),<br>
						plus 1 point of heat (HT2 ÷ 2 = 1).
					</p>
					<p id="RSD"><strong>Remote Sensor Dispenser (RSD#)</strong><br>
						A unit with this ability may deploy 1 remote sensor per turn per Remote<br>
						Sensor Dispenser. (The number of dispensers the unit is carrying is<br>
						indicated in the special ability’s abbreviation.) When deployed, sensors<br>
						are stationary and rest on the surface of the underlying terrain. A remote<br>
						sensor has no armor to speak of, and is automatically destroyed in the End<br>
						Phase of any turn that ends with an opposing unit in base-to-base contact<br>
						with them. Alternatively, the sensor may be destroyed if it takes 1 point<br>
						of damage. Attacks against a sensor apply a –2 to-hit modifier. Each type<br>
						of sensor may also be carried as a bomb (taking 1 bomb slot) by any unit<br>
						that possesses the BOMB# special ability. Once deployed, remote sensors<br>
						may be used to spot for indirect or artillery attacks, as if they were a<br>
						friendly unit, but they apply an additional +3 to-hit modifier.
					</p>
					<p>
						Remote Sensors can also reveal units (see Hidden Units, p. 102), unless<br>
						they are affected by hostile ECM systems, including Angel ECM (AECM) and<br>
						standard ECM (ECM), which will overwhelm their abilities.
					</p>
					<p id="SAW"><strong>Saw (SAW)</strong><br>
						A unit with this special ability may forego its attack to clear an area<br>
						of woods (see Terrain Conversion, p. 104).
					</p>
					<p id="SRCH"><strong>Searchlight (SRCH)</strong><br>
						Units equipped with a searchlight ignore the to-hit modifiers for combat<br>
						in darkness (see Darkness, p. 92).
					</p>
					<p id="SRM"><strong>Short Range Missiles (SRM #/#)</strong><br>
						This unit mounts a significant number of short-range missile launchers and<br>
						may fire them together as an alternative weapon attack instead of a standard<br>
						weapon attack. This ability enables the unit to use alternate SRM ammo for<br>
						modified effects (see Alternate Munitions, p. 76).
					</p>
					<p id="ST"><strong>Small Craft Transport (ST#)</strong><br>
						A unit with this special ability can transport/ launch, and recover the<br>
						indicated number of Small Craft. This ability usually applies to DropShips,<br>
						and is always used in conjunction with the Door special ability (see<br>
						Transporting Non-Infantry Units, p. 63).
					</p>
					<p id="SDS"><strong>Space Defense System (SDS-C #/#/#/#, SDS-CM #/#/#/#, SDS-SC #/#/#/#)</strong><br>
						Any non-DropShip unit or installation with SDS weapons is a unit that<br>
						carries large weapons designed almost exclusively for use against WarShips.<br>
						These capital or sub-capital weapons are generally too large to use<br>
						effectively in ground combat, and are generally reserved to target<br>
						incoming DropShips and WarShips, though SDS missiles (SDS-CM) may<br>
						also be employed as artillery.
					</p>
					<p>
						In the limited instances where these weapons may be used, consult the<br>
						Capital and Sub-Capital Weapons rules (see pp. 86-87).
					</p>
					<p><strong>Space Operations Adaptation (SOA)</strong><br>
						A unit with this special ability can operate in vacuum (see p. 92),<br>
						but is not capable of spaceflight on its own.
					</p>
					<p id="STL"><strong>Stealth (STL)</strong><br>
						Though various stealth systems exist in the BattleTech universe, the<br>
						majority are similar enough in function that Alpha Strike does not<br>
						distinguish between them. These systems make a target more difficult<br>
						to hit with weapon attacks (but not physical attacks), based on the<br>
						range and unit type being targeted. For attacks made against<br>
						non-infantry targets with the STL special, apply an additional +1<br>
						to-hit modifier to attacks at Medium range, and an additional +2<br>
						to-hit modifier at Long range (or greater). For attacks made against<br>
						battle armor targets with the STL special, apply an additional +1<br>
						to-hit modifier at Short and Medium range, and an additional +2<br>
						to-hit modifier at Long range (or greater).
					</p>
					<p id="SCAP"><strong>Sub-Capital (SCAP)</strong><br>
						Sub-capital weapons are smaller-scale versions of the capital weapons<br>
						used on WarShips and SDS batteries. Their use is still almost<br>
						exclusively limited to combat between units in orbital space and<br>
						beyond, and so is generally beyond the general scope of the ground<br>
						war game presented in this book. Nevertheless, in certain limited<br>
						instances where they may be used, consult the Capital and Sub-Capital<br>
						Weapons rules (see pp. 86-87).
					</p>
					<p id="SLG"><strong>Super Large (SLG)</strong><br>
						Super Large units occupy a 6” AoE template sized area or larger.<br>
						Super Large units block LOS.
					</p>
					<p id="TAG"><strong>Target Acquisition Gear (TAG)</strong><br>
						TAG is used to designate targets for homing artillery attacks. A unit<br>
						with this ability may designate targets in the Short and Medium range<br>
						brackets (see Artillery, p. 73).
					</p>
					<p id="MTAS"><strong>Taser (MTAS#)</strong><br>
						A unit with the MTAS# special is carrying a ’Mech Taser; a unit with<br>
						the BTAS# special carries a battle armor Taser. For MTAS special<br>
						abilities, the # in this special indicates the quantity of Taser<br>
						weapons mounted by the unit in question, each of which may attempt<br>
						one attack per turn against any targets that lie in the unit’s firing<br>
						arc and within its Short range bracket.
					</p>
					<p id="BTAS"><strong>Taser (BTAS#)</strong><br>
						A unit with the MTAS# special is carrying a ’Mech Taser; a unit with<br>
						the BTAS# special carries a battle armor Taser. For MTAS special<br>
						abilities, the # in this special indicates the quantity of Taser<br>
						weapons mounted by the unit in question, each of which may attempt<br>
						one attack per turn against any targets that lie in the unit’s<br>
						firing arc and within its Short range bracket.
					</p>
					<p>
						For BTAS special abilities, the # in this special represents the<br>
						maximum number of Taser attacks the unit can make for the entire<br>
						scenario.
					</p>
					<p>
						All Taser attacks are resolved separately, and may be made in addition<br>
						to the unit’s normal weapon or physical attacks.
					</p>
					<p id="TOR"><strong>Torpedo (TOR#)</strong><br>
						Torpedo launchers may only be launched by units in water (or on the<br>
						surface of a water feature), against targets that are also on or in<br>
						water (this includes units like hovercraft and airborne WiGEs operating<br>
						just above the surface of water). Torpedo special ability damage is<br>
						given in range brackets like a standard weapon attack, and may be fired<br>
						separately or combined with the standard weapon damage that a submerged<br>
						unit may deliver in combat.
					</p>
					<p>
						Torpedo attacks ignore underwater range and damage  modifiers that<br>
						affect other weapons. For example, if a submerged unit, with damage<br>
						values of 2/2/2 and a TOR 3/3 special, fires at a target that is in<br>
						its underwater Short range bracket, it will deliver 4 points of total<br>
						damage on a successful attack. (The base damage of 2 for its normal<br>
						weapons is halved to 1, but the full TOR damage of 3 applies without<br>
						reduction.)
					</p>
					<p id="TSM"><strong>Triple-Strength Myomer (TSM)</strong><br>
						’Mechs with the Triple-Strength Myomer special ability can move faster and deliver additional damage in standard- and melee-type physical attacks, but only when running hot. Once a unit with TSM overheats, the following rules apply only to its movement and physical attack capabilities. All other rules for overheating and gameplay apply normally.
					</p>
					<p>
						<em>Movement:</em> When a ’Mech with TSM has a heat scale level of 1 or higher, it gains 2 inches of additional ground Move. If the heat scale is 1, the unit also ignores the loss of 2 inches from overheating, but the overheating effects on Move for heat levels of 2+ remain in effect. (Unlike units with Industrial TSM, units with this ability do not include its movement effects in their normal stats, because the ability is activated only by overheating.)
					</p>
					<p>
						<em>Physical Attacks:</em> When an overheating unit delivers a successful standard- or melee-type physical attack, it adds 1 point to the damage delivered by the attack. Unlike Industrial TSM, this heat-activated version imposes no additional to-hit modifiers.
					</p>
					<p id="TUR"><strong>Turret (TUR#)</strong><br>
						A unit with a turret has some (or all) of its weapons mounted with a 360-degree field of fire. Damage for all turret-mounted weapons are included in the base damage values for the unit, and then separately for the TUR special ability. Thus, when a unit with a turret wishes to make an attack outside of its normal forward field of fire, it must use the damage values for its TUR special ability in place of the unit’s standard damage values.
					</p>
					<p>
						Weapon attacks made using the turret cannot be combined with any other special attack ability (such as IF, FLK, and so on). Some particularly large units—such as mobile structures and very large or super large vehicles—may feature multiple turrets. A unit with multiple turrets may use each turret individually to deliver its attacks<br>
						(see Exceptionally Large Units, pp. 96-99).
					</p>
					<p id="UMU"><strong>Underwater Maneuvering Units (UMU)</strong><br>
						A unit with the UMU special ability uses the submersible movement rules when it is submerged in water instead of the normal underwater movement rules<br>
						(see Submersible Movement, p. 31).
					</p>
					<p id="WAT"><strong>Watchdog (WAT)</strong><br>
						A unit with this special ability possesses the Watchdog Composite Electronic Warfare System. For purposes of  Alpha Strike, it is treated as if it has both the ECM and Light Active Probe (LPRB) special abilities.<br>
						(Active probes are covered in greater detail in the Advanced Options chapter, see pp. 62-113.)
					</p>
				</div>
			</td>
		</tr>
	</table>

	<script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
//                console.log("scrolling");
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
		var api = $('.scroll-pane').data('jsp');
		api.reinitialise();
            });
        });
    </script>
</body>

</html>
