<!DOCTYPE html>
<html lang="en">

<head>
	<title>ClanWolf.net: AplhaStrike Card App (ASCard): Special abilities</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike, Mech">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=1.85, user-scalable=yes" />

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

	<!-- https://www.npmjs.com/package/passive-events-support?activeTab=readme -->

	<script>
		window.passiveSupport = {
			debug: false,
			events: ['touchstart', 'touchmove', 'wheel'],
			listeners: [
				{
					element: '.jspContainer',
					event: 'touchstart',
					prevented: true
				},
				{
					element: '.jspContainer',
					event: 'touchmove',
					prevented: true
				},
				{
					element: '.jspContainer',
					event: 'wheel',
					prevented: true
				}
			]
		}
	</script>
	<script type="text/javascript" src="./scripts/passive-events-support/main.js"></script>

	<script type="text/javascript" src="./scripts/jquery-3.7.1.min.js"></script>
	<script type="text/javascript" src="./scripts/specialunitabilities.js"></script>
</head>

<body style="background-image: url('images/body-bg_2.jpg');">
	<style>
		.topnav {
			z-index: 10;
			overflow: hidden;
			background-color: #333;
			position: fixed;
		}
		.content {
			z-index: 10;
			overflow-x: hidden;
			overflow-y: scroll;
			position: fixed;
			bottom: 0px;
		}
	</style>

	<div class="topnav" id="nav">
		<table class="options" cellspacing=10 cellpadding=10 border=0px>
			<tr>
<?php
	echo "					<td>\n";
	echo "						<table width='100%'><tr>\n";
	echo "							<td nowrap colspan='1' width='15%' style='color:#dcdcdc;' class='mechselect_button_normal' onclick='javascript:window.history.back();'>\n";
	echo "								<i style='font-size:2.5em;' class='fa-solid fa-caret-left'></i>\n";
	echo "							</td>\n";
	echo "						</tr></table>\n";
	echo "					</td>\n";
?>
				<td width="85%" align="left">
					<table>
						<tr>
							<td><a href="#AC" target="_SELF">AC</a>&nbsp;&nbsp;</td>
							<td><a href="#AECM" target="_SELF">AECM</a>&nbsp;&nbsp;</td>
							<td><a href="#AFC" target="_SELF">AFC</a>&nbsp;&nbsp;</td>
							<td><a href="#AM" target="_SELF">AM</a>&nbsp;&nbsp;</td>
							<td><a href="#AMP" target="_SELF">AMP</a>&nbsp;&nbsp;</td>
							<td><a href="#AMS" target="_SELF">AMS</a>&nbsp;&nbsp;</td>
							<td><a href="#ARM" target="_SELF">ARM</a>&nbsp;&nbsp;</td>
							<td><a href="#ARS" target="_SELF">ARS</a>&nbsp;&nbsp;</td>
							<td><a href="#ARTX" target="_SELF">ARTX</a>&nbsp;&nbsp;</td>
							<td><a href="#AT" target="_SELF">AT</a>&nbsp;&nbsp;</td>
							<td><a href="#BH" target="_SELF">BH</a>&nbsp;&nbsp;</td>
							<td><a href="#BHJ" target="_SELF">BHJ</a>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><a href="#BOMB" target="_SELF">BOMB</a>&nbsp;&nbsp;</td>
							<td><a href="#BRID" target="_SELF">BRID</a>&nbsp;&nbsp;</td>
							<td><a href="#BT" target="_SELF">BT</a>&nbsp;&nbsp;</td>
							<td><a href="#BTAS" target="_SELF">BTAS</a>&nbsp;&nbsp;</td>
							<td><a href="#CAP" target="_SELF">CAP</a>&nbsp;&nbsp;</td>
							<td><a href="#CASE" target="_SELF">CASE</a>&nbsp;&nbsp;</td>
							<td><a href="#CASEII" target="_SELF">CASEII</a>&nbsp;&nbsp;</td>
							<td><a href="#CK" target="_SELF">CK</a>&nbsp;&nbsp;</td>
							<td><a href="#CNARC" target="_SELF">CNARC</a>&nbsp;&nbsp;</td>
							<td><a href="#CR" target="_SELF">CR</a>&nbsp;&nbsp;</td>
							<td><a href="#CRW" target="_SELF">CRW</a>&nbsp;&nbsp;</td>
							<td><a href="#CT" target="_SELF">CT</a>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><a href="#D" target="_SELF">D</a>&nbsp;&nbsp;</td>
							<td><a href="#DCC" target="_SELF">DCC</a>&nbsp;&nbsp;</td>
							<td><a href="#DRO" target="_SELF">DRO</a>&nbsp;&nbsp;</td>
							<td><a href="#DUN" target="_SELF">DUN</a>&nbsp;&nbsp;</td>
							<td><a href="#ECM" target="_SELF">ECM</a>&nbsp;&nbsp;</td>
							<td><a href="#ENE" target="_SELF">ENE</a>&nbsp;&nbsp;</td>
							<td><a href="#ENG" target="_SELF">ENG</a>&nbsp;&nbsp;</td>
							<td><a href="#ES" target="_SELF">ES</a>&nbsp;&nbsp;</td>
							<td><a href="#FD" target="_SELF">FD</a>&nbsp;&nbsp;</td>
							<td><a href="#FF" target="_SELF">FF</a>&nbsp;&nbsp;</td>
							<td><a href="#FLK" target="_SELF">FLK</a>&nbsp;&nbsp;</td>
							<td><a href="#HELI" target="_SELF">HELI</a>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><a href="#HT" target="_SELF">HT</a>&nbsp;&nbsp;</td>
							<td><a href="#IF" target="_SELF">IF</a>&nbsp;&nbsp;</td>
							<td><a href="#INARC" target="_SELF">INARC</a>&nbsp;&nbsp;</td>
							<td><a href="#LECM" target="_SELF">LECM</a>&nbsp;&nbsp;</td>
							<td><a href="#LG" target="_SELF">LG</a>&nbsp;&nbsp;</td>
							<td><a href="#LPRB" target="_SELF">LPRB</a>&nbsp;&nbsp;</td>
							<td><a href="#LRM" target="_SELF">LRM</a>&nbsp;&nbsp;</td>
							<td><a href="#LTAG" target="_SELF">LTAG</a>&nbsp;&nbsp;</td>
							<td><a href="#MAG" target="_SELF">MAG</a>&nbsp;&nbsp;</td>
							<td><a href="#MDS" target="_SELF">MDS</a>&nbsp;&nbsp;</td>
							<td><a href="#MEC" target="_SELF">MEC</a>&nbsp;&nbsp;</td>
							<td><a href="#MEL" target="_SELF">MEL</a>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><a href="#MHQ" target="_SELF">MHQ</a>&nbsp;&nbsp;</td>
							<td><a href="#MSL" target="_SELF">MSL</a>&nbsp;&nbsp;</td>
							<td><a href="#MSW" target="_SELF">MSW</a>&nbsp;&nbsp;</td>
							<td><a href="#MT" target="_SELF">MT</a>&nbsp;&nbsp;</td>
							<td><a href="#MTAS" target="_SELF">MTAS</a>&nbsp;&nbsp;</td>
							<td><a href="#MTN" target="_SELF">MTN</a>&nbsp;&nbsp;</td>
							<td><a href="#OMNI" target="_SELF">OMNI</a>&nbsp;&nbsp;</td>
							<td><a href="#OVL" target="_SELF">OVL</a>&nbsp;&nbsp;</td>
							<td><a href="#PNT" target="_SELF">PNT</a>&nbsp;&nbsp;</td>
							<td><a href="#PRB" target="_SELF">PRB</a>&nbsp;&nbsp;</td>
							<td><a href="#PT" target="_SELF">PT</a>&nbsp;&nbsp;</td>
							<td><a href="#RAIL" target="_SELF">RAIL</a>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><a href="#RCA" target="_SELF">RCA</a>&nbsp;&nbsp;</td>
							<td><a href="#RCN" target="_SELF">RCN</a>&nbsp;&nbsp;</td>
							<td><a href="#REAR" target="_SELF">REAR</a>&nbsp;&nbsp;</td>
							<td><a href="#RFA" target="_SELF">RFA</a>&nbsp;&nbsp;</td>
							<td><a href="#RSD" target="_SELF">RSD</a>&nbsp;&nbsp;</td>
							<td><a href="#SAW" target="_SELF">SAW</a>&nbsp;&nbsp;</td>
							<td><a href="#SCAP" target="_SELF">SCAP</a>&nbsp;&nbsp;</td>
							<td><a href="#SDS" target="_SELF">SDS</a>&nbsp;&nbsp;</td>
							<td><a href="#SEAL" target="_SELF">SEAL</a>&nbsp;&nbsp;</td>
							<td><a href="#SHLD" target="_SELF">SHLD</a>&nbsp;&nbsp;</td>
							<td><a href="#SLG" target="_SELF">SLG</a>&nbsp;&nbsp;</td>
							<td><a href="#SRCH" target="_SELF">SRCH</a>&nbsp;&nbsp;</td>
						</tr>
						<tr>
							<td><a href="#SRM" target="_SELF">SRM</a>&nbsp;&nbsp;</td>
							<td><a href="#ST" target="_SELF">ST</a>&nbsp;&nbsp;</td>
							<td><a href="#STL" target="_SELF">STL</a>&nbsp;&nbsp;</td>
							<td><a href="#TAG" target="_SELF">TAG</a>&nbsp;&nbsp;</td>
							<td><a href="#TOR" target="_SELF">TOR</a>&nbsp;&nbsp;</td>
							<td><a href="#TSM" target="_SELF">TSM</a>&nbsp;&nbsp;</td>
							<td><a href="#TUR" target="_SELF">TUR</a>&nbsp;&nbsp;</td>
							<td><a href="#UMU" target="_SELF">UMU</a>&nbsp;&nbsp;</td>
							<td><a href="#WAT" target="_SELF">WAT</a>&nbsp;&nbsp;</td>
							<td><a href="#XMEC" target="_SELF">XMEC</a>&nbsp;&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>

	<div class="hudcenteranimation">
		<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" style="enable-background:new 0 0 1000 1000;" xml:space="preserve">
			<circle class="st0" cx="500" cy="500" r="302.8">
				<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 500 500" to="360 500 500" dur="100s" repeatCount="indefinite"></animateTransform>
			</circle>
			<circle class="st1" cx="500" cy="500" r="237.7">
				<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 500 500" to="360 500 500" dur="40s" repeatCount="indefinite"></animateTransform>
			</circle>
			<circle class="st2" cx="500" cy="500" r="366.8">
				<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 500 500" to="-360 500 500" dur="50s" repeatCount="indefinite"></animateTransform>
			</circle>
			<circle class="st3" cx="500" cy="500" r="395.1"></circle>
		</svg>
	</div>

	<div class="content" id="cont">
		<table class="options" cellspacing=5 cellpadding=5 border=0px>
			<tr>
				<td align="left" class='datalabel'>
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
						This ability makes a non-naval unit capable of water  movement. Amphibious units pay a total of 4” per inch of water traversed and move as a surface naval unit in water, except that they freely move in and out of water areas.
					</p>
					<p id="AECM"><strong>Angel ECM (AECM)</strong><br>
						An Angel ECM suite has all the advantages of a standard ECM suite. Angel ECM is treated as two standard ECM suites.
					</p>
					<p id="AM"><strong>Anti-’Mech (AM)</strong><br>
						Infantry units with the Anti-’Mech (AM) special ability can make a special attack against any ground units, landed VTOLs and WiGEs, or grounded aerospace units with which they are in base-to-base contact. Anti-’Mech Infantry attacks are treated as a physical attack<br>
						(see p. 42).
					</p>
					<p id="AMS"><strong>Anti-Missile System (AMS)</strong><br>
						A unit with an AMS reduces the damage by 1 point (to a minimum of 1) from any of the following attacks: standard weapon attack from a unit with the IF, SRM, or LRM special abilities, Indirect Fire attack using the IF special ability, or special weapon attack made using the SRM or LRM special abilities. AMS only works on attacks coming in the front arc, unless mounted in a turret (TUR).
					</p>
					<p id="ARM"><strong>Armored Components (ARM)</strong><br>
						A unit with this ability ignores the first critical hit chance rolled against it during a single Alpha Strike scenario. The first time circumstances arise that would normally generate an opportunity for a critical hit (such as structure damage), the unit’s controlling player must strike off this ability as “spent” for the remainder of the scenario, and the attacker loses his first opportunity to roll for a critical hit.
					</p>
					<p id="ARS"><strong>Armored Motive Systems (ARS)</strong><br>
						A unit with this special ability applies a –1 modifier on the Determining Motive Systems Damage roll (see Determining Motive Systems Damage Table, p. 42).
					</p>
					<p id="ARTX"><strong>Artillery (ARTX-#)</strong><br>
						This special ability lets a unit make an artillery attack, with an abbreviation for each type of artillery replacing the “X” in the ability’s acronym. Each different type of artillery a unit carries is listed separately, with the number indicating the number of that type carried. For example, a unit with two Long Tom artillery weapons would record this as ARTLT-2. Refer to the Artillery Abbreviations Table, below (see the Bomb (BOMB#) special ability, p. 105, for Arrow IV missiles carried as bombs).
					</p>
					<p id="AC"><strong>Autocannon (AC#/#/#/#)</strong><br>
						This unit mounts a significant number of autocannons and may fire them together as an alternative weapon attack instead of a standard weapon attack. This ability enables the unit to use alternate autocannon ammo for modified effects.
					</p>
					<p id="BHJ"><strong>BattleMech HarJel (BHJ)</strong><br>
						A ’Mech protected by HarJel ignores the additional critical hit chance incurred by suffering damage while operating underwater or in a vacuum. Critical hit chances from normal structure damage (and other sources) still apply.
					</p>
					<p id="SHLD"><strong>BattleMech Shield (SHLD)</strong><br>
						Shield-bearing ’Mechs gain some protection against weapon and physical attacks at the expense of their own attack accuracy. To reflect this, shield-equipped units reduce the damage from most weapons and physical attacks by 1 point (to a minimum of 0). Indirect attacks, heat-causing attacks, and area-effect attacks (such as artillery and bombs) are not dampened by the shield and thus deliver full damage. All weapon attacks made by a ’Mech with this ability incur an additional +1 to-hit modifier.
					</p>
					<p id="BH"><strong>Bloodhound Active Probe (BH)</strong><br>
						An enhanced version of the standard active probe (PRB), the Bloodhound probe offers all the same features, but with an effective range of 26”. Bloodhound probes automatically confer the Recon (RCN) special ability upon their users, and enable them to detect hidden units (see Hidden Units, p. 102), identify incoming sensor blips, or discover the capabilities of unknown hostile units that fall within this range (see Concealing Unit Data, pp. 87-89).
					</p>
					<p>
						In addition to these standard features, the Bloodhound is also unaffected by standard and light ECM specials (ECM and LECM). Presently, only the Angel ECM (AECM) can overwhelm the sensing abilities of the Bloodhound.
					</p>
					<p id="BT"><strong>Booby Trap (BT)</strong><br>
						The booby trap is a last-ditch weapon. A unit with this ability has devoted considerable mass toward a devastating selfdestruct mechanism designed inflict damage on nearby units as well. The booby trap may be activated during the Combat Phase, in place of a weapon or physical attack. Once activated, the system automatically destroys the unit and delivers an area-effect attack to all units within an area covered by a 2” AoE template. Activated on the ground, all units in the area of effect suffer damage equal to the booby-trapped unit’s weight/size class times half its Move. For example, a booby-trapped assault ’Mech with a Move of 6” would deliver 12 points of damage (Size 4 x [Move 6” ÷ 2] = 12) to all units in its area of effect.
					</p>
					<p>
						<em>Airborne Booby Traps:</em> A booby trap that is activated in the air by units using on the Radar Map has no effect in Alpha Strike gameplay. Airborne units on the ground map that activate a booby trap inflict damage in a 2” AoE template centered on a point, as chosen by the player. All units on the ground within that area of effect suffer damage equal to the booby-trapped unit’s weight/size class. Thus, while a heavy aerospace fighter with a booby trap would inflict no damage on the Radar Map, if it were flying over the ground map and chose to self destruct, its damage to all units within the area covered by the 2” AoE template centered on a point on its flight path would be 3 points.
					</p>
					<p id="BOMB"><strong>Bomb (BOMB#)</strong><br>
						Conventional and aerospace fighters, fixed-wing support vehicles, and some battle armor can carry bombs. The number of bombs these units can carry are equal to the number in the ability’s notation (so a unit with BOMB4 carries up to 4 bombs). For most units, these bombs may be of any type, though battle armor units with this ability may only use cluster bombs (see p. 57). (As a special exception, Arrow IV missiles of all types may be carried as bombs, but a unit that uses Arrow IV bombs must count the first Arrow IV missile carried this way as 2 bombs. All remaining bombs are then counted normally.)
					</p>
					<p>
						Each bomb a unit carries reduces its Thrust value by 1. (Battle armor units with bombs suffer no effects on their Move ratings.) A bomb-carrying unit’s card should list how many bombs the unit is carrying in the scenario, which must be equal to or less than the number this ability enables it to carry.
					</p>
					<p id="BRID"><strong>Bridgelayer (BRID)</strong><br>
						A unit with this special ability may deploy a temporary bridge capable of spanning gaps up to 2 inches in width. Multiple bridges may be linked together to extend the reach of an existing bridge. Deploying or extending a bridge takes one turn, during which the bridgelayer unit cannot move. After the bridge is deployed, the bridgelaying unit may move normally. A bridge does not need to be deployed such that each side of the bridge rests on solid ground; it may be deployed as a makeshift dock extending into water. Bridges placed by bridgelayer units are temporary in nature. Once a bridgelayer unit places a bridge, it may not place another for the remainder of the scenario unless it removes the original. Removing one of these temporary bridges may only be done by non-infantry bridgelayer units, and requires the unit to remain in base-contact with the bridge being removed for the entire turn, with no other units passing over the bridge in that same turn.
					</p>
					<p>
						All bridgelayer bridges automatically float on water, as they contain integral flotation devices by design. Bridges placed by a non-infantry unit with this ability have a CF of 18 and may support units of Size class 3. The bridge may be targeted as a building and will be destroyed once its CF is reduced to 0. A bridge reduced to 10 points or less may only support units up to Size 2. Bridges reduced to 5 or fewer points it may only support Size 1 units.
					</p>
					<p>
						If a unit that exceeds a bridge’s Size limit attempts to use it, the bridge immediately collapses once the unit moves onto it. All units on a bridge when it collapses will fall and suffer 1 point of damage per 3 inches (or fraction thereof) of difference between the starting level and destination level, rolling for critical hits as normal. If the unit falls into prohibited terrain as a result of a bridge collapse, it is destroyed.
					</p>
					<p><em>Infantry Bridgelayers:</em><br>
						Infantry with this ability may erect a bridge using gear and parts carried with them for the task, but may only do so once per scenario. Infantry bridgelayers require 2 turns to complete their bridges, which possess a starting CF of 8, and can support units up to Size 2.
					</p>
					<p id="CAP"><strong>Capital Weapons (CAP)</strong><br>
						Capital weapons are large weapons that are seen only on truly massive installations, mobile structures, and WarShips Because their use is almost exclusively limited to combat between units in orbital space and beyond, their use is beyond the general scope of the ground war game presented in this book. Nevertheless, in certain limited instances where they may be used, consult the Capital and Sub-Capital Weapons rules (see pp. 86-87).
					</p>
					<p id="CK"><strong>Cargo Transport, Kilotons (CK#)</strong><br>
						This ability is identical to the Cargo Transport–Tons ability, except that the numerical designation for this special ability represents cargo capacity in 1,000-ton lots. This may be a decimal value, so a unit with CK3.57 would have a cargo capacity of 3,570 tons (1,000 tons x 3.57 = 3,570 tons).
					</p>
					<p id="CT"><strong>Cargo Transport, Tons (CT#)</strong><br>
						Units with this special ability have bays or other internal space set aside for carrying bulk cargo such as munitions, supplies and the like. This space is not generally suited for transporting battleready units like vehicles, ’Mechs, or infantry, and such units may not be dropped or deployed from cargo bays as a result—though they can be carried as cargo (see Units as Cargo, p. 64). This ability usually applies to DropShips, and is always used in conjunction with the Door (D#) special ability. The numerical value in this ability indicates how many tons of cargo the unit may transport.
					</p>
					<p id="CASE"><strong>Cellular Ammunition Storage Equipment (CASE)</strong><br>
						Units with this ability can minimize the catastrophic effects of an ammunition explosion and thus can survive Ammo Hit critical hits (see Ammo Hit, p. 18), but will suffer additional damage.
					</p>
					<p id="CASEII"><strong>Cellular Ammunition Storage Equipment II (CASEII)</strong><br>
						Units with this ability have superior protection against ammunition explosions and can ignore Ammo Hit critical hits (see Ammo Hit, p. 18).
					</p>
					<p id="CRW"><strong>Crew (CRW#)</strong><br>
						Non-DropShip units with this ability can temporarily inflict a Crew Stunned critical hit on themselves, while DropShip units can temporarily inflict a Crew Hit critical on themselves instead. Doing so enables these units to deploy a number of infantry units—equal to the number rating of this ability—as additional marines to aid in repelling enemy boarding parties. These foot infantry units have a Move of 2”f, 2 Armor points, 1 Structure point, and Damage Values of 1 at Short and Medium range (see Boarding Actions, p. 98).
					</p>
					<p id="CR"><strong>Critical-Resistant (CR)</strong><br>
						A unit with this special ability features special armor or other protective features that reduces the chance and severity of a critical hit (including damage to structure, damage effects from armor-penetrating weapons, and hull breaches while in vacuum or underwater). Any time an attack on this unit prompts a roll on its Critical Hits Table, apply a –2 modifier to the Critical Hit roll. Modified critical results of 1 or less are treated as No Critical Hit results.
					</p>
					<p id="D"><strong>Door (D#)</strong><br>
						This ability indicates the number of ingress/egress doors available on a DropShip, small craft, or support vehicles’ transport bays. Each door a unit has is tied to a particular bay, and can accommodate a limited number of units per turn (see Transporting Non-Infantry Units, p. 63).
					</p>
					<p id="DRO"><strong>Drone (DRO)</strong><br>
						Units with this special ability are unmanned units capable of movement and (occasionally) combat. Ground drones must stay within 900” of their control vehicle, unless the control vehicle is airborne or in orbit, in which case range is functionally limitless for a ground game. In space, drones need only remain within LOS to their controller, as the actual range limit is more than 100,000”.
					</p>
					<p>
						Drones enveloped in a hostile ECM field shut down during the End Phase of the turn in which they were trapped by the field. They remain shut down until the ECM field is no longer present. Drones restart automatically in the End Phase of the turn in which the ECM field is removed. If the drone control unit is caught by a hostile ECM field, all of its drones shut down until the ECM field is no longer present. In addition, if the LOS from a drone control unit to its drone passes through an ECM bubble, the drone will shut down. This is frequently avoided by the use of Satellite uplinks for drone control. If the drone control unit is eliminated, the drones shut down for the rest of the game.
					</p>
					<p>
						When not affected by hostile ECM, and as long as their control units (see below) are operational, drone units may Move, attack, spot for indirect fire, and use special abilities as an equivalent unit of the same motive type and capabilities. The Skill rating of a drone is equal to that of its controller’s Skill, plus 1.
					</p>
					<p id="DCC"><strong>Drone Carrier Control System (DCC#)</strong><br>
						Units with the drone carrier control system (DCC) special ability may control units with the drone (DRO) special. The numerical value of this ability indicates the number of drones the unit can control. All drones controlled by this unit will shut down if the control unit is destroyed, disabled, or enveloped in hostile ECM fields.
					</p>
					<p id="DUN"><strong>Dune Buggy (DUN)</strong><br>
						A unit with this special ability can move more easily over Sand (see Advanced Terrain, p. 64).
					</p>
					<p id="ECM"><strong>Electronic Countermeasures (ECM)</strong><br>
						In Alpha Strike, an ECM suite’s area of effect covers a 12-inch radius from the unit that has this special ability. Electronics (including active probes and C3 computers) used by units friendly to the ECM-equipped unit will not be affected by this item, nor will an ECM suite affect other scanning and targeting devices (such as basic or advanced fire control, or TAG).
					</p>
					<p id="ES"><strong>Ejection Seat (ES)</strong><br>
						The pilot of a unit with an ejection seat may abandon his unit at any time using the unit’s on-board ejection system. The pilot with an ejection seat is also automatically ejected if his unit suffers an Ammo Hit critical and does not feature a CASE or CASEII special (see Ejection/Abandoning Units, p. 91).
					</p>
					<p id="ENG"><strong>Engineering (ENG)</strong><br>
						A unit with this special ability can clear woods just like a unit with the Saw special ability (see Saw, p. 107). In addition, a unit with this ability can clear a path through rubble. It takes 1 turn for a group of 4 or more units with the Engineering special to clear a 2” long path of rubble, 2 turns for 3 units, 3 turns for 2 units and 4 turns for 1 unit.
					</p>
					<p>
						An area cleared by engineering units does not actually change its terrain type; the clearing action simply creates a narrow, clear path through it that units may use to pass through the terrain as if it is clear. (For further explanation, see Terrain Conversion, p. 104.)
					</p>
					<p id="ENE"><strong>Energy (ENE)</strong><br>
						A unit with this ability has little to no ammo to explode, and ignores Ammo Hit critical hits (see Ammo Hit, p. 18).
					</p>
					<p id="SEAL"><strong>Environmental Sealing (SEAL)</strong><br>
						A unit with this special ability may operate in hostile environments (including underwater, vacuum, and so forth). Aerospace units, ProtoMechs, combat vehicles and support vehicles built as submarines are automatically treated as if they have this ability.
					</p>
					<p id="FF"><strong>Firefighter (FF)</strong><br>
						Firefighter units may put out fires within 2” of their position. This action requires a 2D6 roll of 8+, made in place of a weapon attack. Reduce this target number by 1 for each turn the unit spends fighting a fire, and for each additional unit engaged in fighting the same fire (to a maximum target number modifier of –3).
					</p>
					<p id="FLK"><strong>Flak (FLK#/#/#/#)</strong><br>
						If a unit with this ability misses its to-hit roll by 2 points or less when attacking an airborne aerospace unit, VTOL or WiGE target, the unit will deal damage to its target equal to its FLK rating at the appropriate range bracket.
					</p>
					<p id="FD"><strong>Flight Deck (FD)</strong><br>
						A unit with this special ability can be used as a landing area by an aerospace fighter, conventional fighter, small craft, fixedwing support vehicle, airship support vehicle, or VTOL unit.
					</p>
					<p id="HT"><strong>Heat (HT#/#/#)</strong><br>
						Units with this ability apply heat to the target’s Heat scale during the End Phase of the turn in which they deliver a successful weapon attack. If the target is a unit type that does not use a Heat Scale, the heat this ability would normally produce is added to the normal attack damage instead (see Determine and Apply Damage, p. 17).
					</p>
					<p id="HELI"><strong>Helipad (HELI)</strong><br>
						A unit with this special ability can be used as a landing area by a unit with VTOL movement.
					</p>
					<p id="IF"><strong>Indirect Fire (IF#)</strong><br>
						The Indirect Fire special ability allows a unit to attack a target without having a valid LOS to it via arcing missiles over the intervening obstacles, similar to how mortars and artillery work. This attack requires a friendly unit with a valid LOS to act as a spotter. The numerical rating for this ability indicates the amount of damage a successful indirect attack will deliver. Because they attack when other weapons cannot, damage from an indirect attack applies in place of the unit’s normal weapon attack (see Indirect Fire, p. 35).
					</p>
					<p id="INARC"><strong>Improved Narc Missile Beacon (iNARC#)</strong><br>
						A unit with the INARC# special ability may make an extra weapon attack using its iNarc missile beacon device. A unit hit by an iNarc beacon will not suffer damage from the iNarc itself, but will suffer 1 additional point of damage from any Indirect Fire (IF), LRM, or SRM attacks for the rest of the game—unless the unit is within a friendly ECM bubble. The iNarc beacon launcher is usable up to the Medium range bracket. Instead of their normal attack, iNarc launchers may fire specialty ammo (see Alternate Munitions, p. 76). The numerical value of this ability indicates the number of extra iNarc beacon attacks the unit can deliver in a single turn.
					</p>
					<p id="LG"><strong>Large (LG)</strong><br>
						Large units cover a 2” AoE template area. Large units block LOS.
					</p>
					<p id="LPRB"><strong>Light Active Probe (LPRB)</strong><br>
						Light active probes function in the same way as standard active probes, but only have an effective range of 12”. As with standard probes, light probes automatically confer the Recon (RCN) special ability upon their users, and enable them to detect hidden units (see Hidden Units, p. 102), identify incoming sensor blips, or discover the capabilities of unknown hostile units that fall within this range (see Concealing Unit Data, pp. 87-89).
					</p>
					<p>
						Hostile ECM systems, including Angel ECM (AECM) and standard ECM (ECM) will overwhelm the light active probe’s abilities.
					</p>
					<p id="LECM"><strong>Light ECM (LECM)</strong><br>
						Light ECM functions identically to ECM, but with a reduced radius. Light ECM only creates an ECM bubble with a 2” radius.
					</p>
					<p id="LTAG"><strong>Light Target Acquisition Gear (LTAG)</strong><br>
						A unit with Light TAG can “paint” targets for artillery homing rounds (see Artillery, p. 73) in the same way as a unit with standard target acquisition gear (TAG). Light TAG may only be used in the Short range bracket.
					</p>
					<p id="LRM"><strong>Long-Range Missiles (LRM#/#/#/#)</strong><br>
						This unit mounts a significant number of long-range missile launchers and may fire them together as an alternative weapon attack instead of a standard weapon attack. This ability enables the unit to use alternate LRM ammo for modified effects (see Alternate Munitions, p. 76).
					</p>
					<p id="MAG"><strong>Maglev (MAG)</strong><br>
						A variation of the Rail (RAIL) special ability (see Rail, p. 108), units with magnetic levitation (maglev) systems may only travel along rail terrain designated for maglev units.
					</p>
					<p id="MT"><strong>’Mech Transport (MT#)</strong><br>
						A unit with this special ability can transport, deploy, and drop the indicated number of ’Mechs. This ability usually applies to DropShips, and is always used in conjunction with the Door special ability (see Transporting Non-Infantry Units, and Dropping Troops, pp. 63 and 90, respectively).
					</p>
					<p id="MEC"><strong>Mechanized (MEC)</strong><br>
						Battle Armor with this special ability can be carried into battle as mechanized battle armor by units with the OMNI special ability.
					</p>
					<p id="MEL"><strong>Melee (MEL)</strong><br>
						This special ability indicates that the ’Mech is equipped with a physical attack weapon, and adds 1 additional point of physical attack damage on a successful Melee-type physical attack (see Resolving Physical Attacks, p. 19).
					</p>
					<p id="MDS"><strong>Mine Dispenser (MDS#)</strong><br>
						This ability allows a unit to create minefields in areas through which it travels (see Minefields, p. 102). Record this ability as MDS# where # is the number of mine dispensers mounted on the unit. Each mine dispenser deploys a density 1 minefield. Multiple deployments in the same location increase the density of the minefield by 1 each, to a maximum density of 5.
					</p>
					<p id="MSW"><strong>Minesweeper (MSW)</strong><br>
						A unit with a minesweeper automatically clears any minefields it is in base contact with at the end of the Movement Phase (see Minefields, p. 102). During the minesweeper’s Combat Phase, it may not execute any attacks, but must roll 2D6 to clear the minefield, applying a +4 modifier to the result if the minesweeping unit is not infantry. If the result is 10 or better, the minefield is cleared and removed from the map. If the result is 5 or less, the minefield detonates for its full effects. Any other roll result means the minefield is not cleared.
					</p>
					<p id="MSL"><strong>Missile (MSL #/#/#/#)</strong><br>
						Units with this special ability are aerospace units that have been outfitted with capital and/or sub-capital scale missile launchers. Though these weapons are treated as artillery when attacking the ground, they cannot use alternative munitions under these rules.
					</p>
					<p>
						Consult the Capital and Sub-Capital Weapons rules to resolve combat using these weapons (see pp. 86-87).
					</p>
					<p id="MHQ"><strong>Mobile Headquarters (MHQ#)</strong><br>
						The standard MHQ is equipped with a wide array of special equipment to coordinate engagements over a large area. This ability provides different bonuses depending on the numerical rating (see Battlefield Intelligence, p. 82).
					</p>
					<p id="MTN"><strong>Mountain Troops (MTN)</strong><br>
						Infantry units with this special ability may climb 2 inches per inch moved forward in a turn.
					</p>
					<p id="CNARC"><strong>Narc Missile Beacon (CNARC#)</strong><br>
						A unit with the CNARC# or SNARC# special ability may make an extra weapon attack using its Narc missile beacon device. A unit hit by a Narc beacon will not suffer damage from the Narc itself, but will suffer 1 additional point of damage from any Indirect Fire (IF), LRM, or SRM attacks for the rest of the game—unless the unit is within a friendly ECM bubble. Standard Narc beacon launchers (indicated by SNARC) have a maximum range of Medium, while Compact Narc beacon launchers (CNARC) have a maximum range of Short.
					</p>
					<p id="SNARC"><strong>Narc Missile Beacon (SNARC#)</strong><br>
						A unit with the CNARC# or SNARC# special ability may make an extra weapon attack using its Narc missile beacon device. A unit hit by a Narc beacon will not suffer damage from the Narc itself, but will suffer 1 additional point of damage from any Indirect Fire (IF), LRM, or SRM attacks for the rest of the game—unless the unit is within a friendly ECM bubble. Standard Narc beacon launchers (indicated by SNARC) have a maximum range of Medium, while Compact Narc beacon launchers (CNARC) have a maximum range of Short.
					</p>
					<p>
						Instead of their normal attack, Narc launchers may fire specialty ammo (see Alternate Munitions, p. 76). The numerical value of this ability indicates the number of extra Narc beacon attacks the unit can deliver in a single turn.
					</p>
					<p id="OMNI"><strong>Omni (OMNI)</strong><br>
						In standard Alpha Strike play, ground-based Omni units (’Mechs or vehicles) may transport a single battle armor unit using the mechanized battle armor rules (see Transporting Infantry, p. 32).
					</p>
					<p id="OVL"><strong>Overheat Long (OVL)</strong><br>
						A unit with this special ability may overheat up to its OV value and apply that value to its Long range damage value as well as the unit’s Short and Medium range damage values. (A unit without this special ability may only apply the damage benefits of its Overheat capabilities to damage delivered in the Short and Medium range brackets.)
					</p>
					<p id="PAR"><strong>Paratroops (PAR)</strong><br>
						These units may dismount from airborne transport units (including aerospace units) just like jump infantry.
					</p>
					<p id="PNT"><strong>Point Defense (PNT#)</strong><br>
						Unless it is shut down, a unit protected by a point defense system automatically engages any missiles that attack it. Unlike an anti-missile system (AMS), the point defense system may engage Arrow IV, capital or sub-capital missiles as well as missile attacks delivered using the IF, SRM, and LRM specials. Point defense has a 360-degree arc of fire, and is always successful, so no to-hit roll is required. Point defense generates a number of “defensive damage points” equal to the ability’s numerical rating. Thus, a unit with a PNT6 special would generate 6 points of “defensive damage” per turn. This damage is distributed among incoming missiles at the controlling player’s discretion. If an incoming missile delivers no damage to begin with, any amount of defensive damage from a point defense ability will destroy the incoming missile before it can attack.
					</p>
					<p>
						For all other incoming missiles, 1 point of defensive damage will apply a +1 to-hit modifier to the missile’s attack roll, and reduce the incoming attack’s damage value by half (rounded down, to a minimum of 0 points). If 2 or more points of defensive damage are assigned to an incoming missile attack, the attack is eliminated entirely.
					</p>
					<p id="PT"><strong>ProtoMech Transport (PT#)</strong><br>
						A unit with this special ability can transport, deploy, and drop the indicated number of ProtoMechs. This ability usually applies to DropShips, and is always used in conjunction with the Door special ability (see Transporting Non-Infantry Units and Dropping Troops, pp. 63, 90, respectively).
					</p>
					<p id="RAIL"><strong>Rail (RAIL)</strong><br>
						A unit with the Rail special can only move along rails.
					</p>
					<p id="RCA"><strong>Reactive Armor (RCA)</strong><br>
						A unit with reactive armor is resistant to damage from explosive ordnance, particularly those delivered by artillery and missile weaponry. If a unit with this special is struck by damage from any area-effect attack, or by any attacking using the ART, BOMB, MSL, or FLK specials, reduce the damage from these attacks by half before applying it (rounding down). For any attack against a unit with reactive armor by a unit with the IF, LRM, or SRM specials, reduce the amount of attack’s damage by half of the LRM or SRM special’s value at the appropriate range (rounding up). If reactive armor reduces damage below 1 point, treat the attack as delivering 1 point.
					</p>
					<p>
						Note that this damage reducing effect even covers general attacks by units that possess such abilities, so if a unit that can deliver 4 points of damage at Short range attacks a target with reactive armor, and the attacker has the SRM 2/2 special, the damage delivered is 3 points (4 points total – (2 ÷ 2) = 3).
					</p>
					<p id="RCN"><strong>Recon (RCN)</strong><br>
						The recon ability works in conjunction with the Mobile Headquarters (MHQ#) ability. Every unit with the recon special confers a +1 initiative bonus to itself and 3 other units.
					</p>
					<p id="REAR"><strong>Rear-firing weapons (REAR#/#/#/#)</strong><br>
						Although rear-facing weapons are common enough on larger and less flexible units like mobile structures and DropShips, several smaller units also feature secondary weapons mounted in their rear fields of fire. ’Mechs, vehicles, and fighters that possess such weaponry feature the REAR (#/#/#/#) special unit ability to reflect this. As with most other special weapon abilities, the numbers associated with this ability indicate the damage that the unit can inflict at each range bracket.
					</p>
					<p>
						Ground Units:<br>Any ground unit with rear-facing weapons may decide to use them against any targets that begin the Combat Phase outside of the unit’s normal firing arc. This rear attack is resolved using all of the same rules as a normal weapon attack, but applies an additional +1 Target Number modifier.
					</p>
					<p>
						Airborne Units:<br>The same rules apply for fighter units as for ground units. However, a fighter may only use its rear-facing weapons against units that are specifically tailing them (see p. 185), and are within range of its rear weapons. Thus, if a fighter has rear-firing weapons that only delivers damage to the Short range bracket, it may only use these weapons against tailing enemies at Short range.
					</p>
					<p>
						Combining Forward (or Turret) and Rearward Attacks:<br>A unit attempting a REAR attack may still deliver normal forwardfiring attacks in the same turn, but its ability to do so is reduced. To reflect this, if a unit makes an attack using the REAR special ability, for every point of REAR damage it can inflict, its forward-arc (or turret-based) damage for that turn must be reduced by the same amount. This damage reduction is applied before the use of any additional damage made possible by overheating.
					</p>
					<p>
						Additional Restrictions:<br>Overheat damage cannot be applied to REAR attacks, nor can a REAR attack deliberately reduce its damage values to improve forward-firing (or turret-based) weapon attacks. Finally, REAR attacks cannot make use of other special attack abilities, such as heat, indirect fire, flak, or artillery. [...]
					</p>
					<p id="RFA"><strong>Reflective Armor (RFA)</strong><br>
						A unit with reflective armor is resistant to damage from energy weapons, including flamers, but is much more susceptible to physical attacks, area-effect weapons, and armor-penetrating hits. If a unit with this special is struck by an air-to-ground strafing attack, or by a weapon attack by a unit with the ENE special, or by an attack using the HT special, reduce this damage (or heat) by half before applying it. (Round this damage down, to a minimum of 1 point of damage or heat applied from that attack type.) If, on the other hand, a unit with this ability suffers damage from any physical attack, an area-effect attack, or by any attack using the ART, BOMB, FLK, or MSL specials, double the damage applied by that attack.
					</p>
					<p>
						For all other attacks against a unit with reflective armor, reduce the total damage applied by 1 point (to a minimum of 1 point). Finally, all critical hits suffered by a unit equipped with reflective armor apply a +2 modifier on the unit’s Critical Hits Table. Modified critical results of 13 or higher are treated as Engine Hits. Note that this damage reducing (and increasing) effect even covers general attacks by such units that possess such abilities, so if a unit that can deliver 4 points of damage at Short range attacks a target ’Mech with reflective armor, and the attacker also has the HT2 special, the attack will deliver 3 points of damage (4 – 1 = 3), plus 1 point of heat (HT2 ÷ 2 = 1).
					</p>
					<p id="RSD"><strong>Remote Sensor Dispenser (RSD#)</strong><br>
						A unit with this ability may deploy 1 remote sensor per turn per Remote Sensor Dispenser. (The number of dispensers the unit is carrying is indicated in the special ability’s abbreviation.) When deployed, sensors are stationary and rest on the surface of the underlying terrain. A remote sensor has no armor to speak of, and is automatically destroyed in the End Phase of any turn that ends with an opposing unit in base-to-base contact with them. Alternatively, the sensor may be destroyed if it takes 1 point of damage. Attacks against a sensor apply a –2 to-hit modifier. Each type of sensor may also be carried as a bomb (taking 1 bomb slot) by any unit that possesses the BOMB# special ability. Once deployed, remote sensors may be used to spot for indirect or artillery attacks, as if they were a friendly unit, but they apply an additional +3 to-hit modifier.
					</p>
					<p>
						Remote Sensors can also reveal units (see Hidden Units, p. 102), unless they are affected by hostile ECM systems, including Angel ECM (AECM) and standard ECM (ECM), which will overwhelm their abilities.
					</p>
					<p id="SAW"><strong>Saw (SAW)</strong><br>
						A unit with this special ability may forego its attack to clear an area of woods (see Terrain Conversion, p. 104).
					</p>
					<p id="SRCH"><strong>Searchlight (SRCH)</strong><br>
						Units equipped with a searchlight ignore the to-hit modifiers for combat in darkness (see Darkness, p. 92).
					</p>
					<p id="SRM"><strong>Short Range Missiles (SRM #/#)</strong><br>
						This unit mounts a significant number of short-range missile launchers and may fire them together as an alternative weapon attack instead of a standard weapon attack. This ability enables the unit to use alternate SRM ammo for modified effects (see Alternate Munitions, p. 76).
					</p>
					<p id="ST"><strong>Small Craft Transport (ST#)</strong><br>
						A unit with this special ability can transport/ launch, and recover the indicated number of Small Craft. This ability usually applies to DropShips, and is always used in conjunction with the Door special ability (see Transporting Non-Infantry Units, p. 63).
					</p>
					<p id="SDS"><strong>Space Defense System (SDS-C #/#/#/#, SDS-CM #/#/#/#, SDS-SC #/#/#/#)</strong><br>
						Any non-DropShip unit or installation with SDS weapons is a unit that carries large weapons designed almost exclusively for use against WarShips. These capital or sub-capital weapons are generally too large to use effectively in ground combat, and are generally reserved to target incoming DropShips and WarShips, though SDS missiles (SDS-CM) may also be employed as artillery.
					</p>
					<p>
						In the limited instances where these weapons may be used, consult the Capital and Sub-Capital Weapons rules (see pp. 86-87).
					</p>
					<p><strong>Space Operations Adaptation (SOA)</strong><br>
						A unit with this special ability can operate in vacuum (see p. 92), but is not capable of spaceflight on its own.
					</p>
					<p id="STL"><strong>Stealth (STL)</strong><br>
						Though various stealth systems exist in the BattleTech universe, the majority are similar enough in function that Alpha Strike does not distinguish between them. These systems make a target more difficult to hit with weapon attacks (but not physical attacks), based on the range and unit type being targeted. For attacks made against non-infantry targets with the STL special, apply an additional +1 to-hit modifier to attacks at Medium range, and an additional +2 to-hit modifier at Long range (or greater). For attacks made against battle armor targets with the STL special, apply an additional +1 to-hit modifier at Short and Medium range, and an additional +2 to-hit modifier at Long range (or greater).
					</p>
					<p id="SCAP"><strong>Sub-Capital (SCAP)</strong><br>
						Sub-capital weapons are smaller-scale versions of the capital weapons used on WarShips and SDS batteries. Their use is still almost exclusively limited to combat between units in orbital space and beyond, and so is generally beyond the general scope of the ground war game presented in this book. Nevertheless, in certain limited instances where they may be used, consult the Capital and Sub-Capital Weapons rules (see pp. 86-87).
					</p>
					<p id="SLG"><strong>Super Large (SLG)</strong><br>
						Super Large units occupy a 6” AoE template sized area or larger. Super Large units block LOS.
					</p>
					<p id="TAG"><strong>Target Acquisition Gear (TAG)</strong><br>
						TAG is used to designate targets for homing artillery attacks. A unit with this ability may designate targets in the Short and Medium range brackets (see Artillery, p. 73).
					</p>
					<p id="MTAS"><strong>Taser (MTAS#)</strong><br>
						A unit with the MTAS# special is carrying a ’Mech Taser; a unit with the BTAS# special carries a battle armor Taser. For MTAS special abilities, the # in this special indicates the quantity of Taser weapons mounted by the unit in question, each of which may attempt one attack per turn against any targets that lie in the unit’s firing arc and within its Short range bracket.
					</p>
					<p id="BTAS"><strong>Taser (BTAS#)</strong><br>
						A unit with the MTAS# special is carrying a ’Mech Taser; a unit with the BTAS# special carries a battle armor Taser. For MTAS special abilities, the # in this special indicates the quantity of Taser weapons mounted by the unit in question, each of which may attempt one attack per turn against any targets that lie in the unit’s firing arc and within its Short range bracket.
					</p>
					<p>
						For BTAS special abilities, the # in this special represents the maximum number of Taser attacks the unit can make for the entire scenario.
					</p>
					<p>
						All Taser attacks are resolved separately, and may be made in addition to the unit’s normal weapon or physical attacks.
					</p>
					<p id="TOR"><strong>Torpedo (TOR#)</strong><br>
						Torpedo launchers may only be launched by units in water (or on the surface of a water feature), against targets that are also on or in water (this includes units like hovercraft and airborne WiGEs operating just above the surface of water). Torpedo special ability damage is given in range brackets like a standard weapon attack, and may be fired separately or combined with the standard weapon damage that a submerged unit may deliver in combat.
					</p>
					<p>
						Torpedo attacks ignore underwater range and damage  modifiers that affect other weapons. For example, if a submerged unit, with damage values of 2/2/2 and a TOR 3/3 special, fires at a target that is in its underwater Short range bracket, it will deliver 4 points of total damage on a successful attack. (The base damage of 2 for its normal weapons is halved to 1, but the full TOR damage of 3 applies without reduction.)
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
					<p id="XMEC"><strong>Extended Mechanized (XMEC)</strong><br>
						Battle Armor with this ability can be transported on the battlefield by any type of unit as mechanized battle armor (see page 32 for details on transporting infantry.)  Normally, only Units with the Omni tag can carry mechanized Battle Armor.
					</p>
				</td>
			</tr>
		</table>
	</div>

	<script>
		$(document).ready(function() {
			var offsetHeight = document.getElementById('nav').offsetHeight + 20;
			document.getElementById('cont').style.setProperty("top", offsetHeight + "px");

		});
		$(window).resize(function() {
			var offsetHeight = document.getElementById('nav').offsetHeight + 20;
			document.getElementById('cont').style.setProperty("top", offsetHeight + "px");
		});
	</script>
</body>

</html>
