<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	$sa = isset($_GET['sa']) ? $_GET['sa'] : "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASCard.net AplhaStrike Card App (clanwolf.net): Special abilities</title>
	<meta charset="utf-8">
	<!-- <meta http-equiv="expires" content="0"> -->
	<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<meta name="description" content="Cards app for the AlphaStrike TableTop (BattleTech).">
	<meta name="keywords" content="BattleTech, AlphaStrike">
	<meta name="robots" content="noindex,nofollow">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=0.75, minimum-scale=0.75, maximum-scale=1.85, user-scalable=yes" />

	<link rel="manifest" href="./manifest.json">
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
	<script type="text/javascript" src="./scripts/jquery.jscrollpane.min.js"></script>
	<script type="text/javascript" src="./scripts/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="./scripts/specialunitabilities.js"></script>

	<style>
		.scroll-pane {
			width: 100%;
			height: 100px;
			overflow: auto;
		}
		.horizontal-only {
			height: auto;
			max-height: 100px;
		}
	</style>
</head>

<body>
	<div class="content" id="cont">
		<div id="specialabilitiescontainer_standalone">
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

			<br>

			<table width="100%" height="80%">
				<tr>
					<td width="5%" align="right" valign="top" class="datalabel">&nbsp;</td>
					<td width="90%">
						<table class="options" width="100%" style="height:100%;" cellspacing=4 cellpadding=8 border=0px>
							<tr>
								<td id="alphabeticalNavigation" align="center" valign="middle" colspan="2" class="datalabel" style="font-size:1.6em;">
									A B C D E F G H I J K L M N O P Q R S T U V W X Y Z
								</td>
							</tr>
							<tr>
								<td id="specialunitabilitiesNavigation" align="center" valign="middle" colspan="2" class="datalabel">
									NAV
								</td>
							</tr>
							<tr>
								<td class="datavalue_thin" colspan="2"><hr></td>
							</tr>
							<tr>
								<td class="datalabel" id="sa_name" align="left" width="90%" style="font-size:1.4em;">...</td><td nowrap class="datalabel" id="sa_abbreviation" align="right" width="10%" style="font-size:1.4em;">...</td>
							</tr>
							<tr>
								<td class="datavalue_thinflow" style="font-size:0.75em;" align="left">
									<span  id="sa_source">...</span>, <span id="sa_page">...</span>
								</td>
								<td nowrap class="datavalue_thinflow" id="sa_type">...</td>
							</tr>
							<tr>
								<td class="datavalue_thin" colspan="2"><hr></td>
							</tr>
							<tr>
								<td height="100%" colspan="2" align="left" valign="top">
									<div class='scroll-pane' width="100%" style="width:100%;">
										<table width="100%"><tr><td class="datavalue_thinflow" id="sa_rule">...</td></tr></table>
									</div>
								</td>
							</tr>

							<!--
							<tr>
								<td class="datavalue_thin" colspan="2"><hr></td>
							</tr>
							<tr>
								<td nowrap class="datavalue_thinflow" id="sa_source" align="left" width="90%">...</td><td nowrap class="datavalue_thinflow" id="sa_page" align="right" width="10%">...</td>
							</tr>
							-->

							<tr>
								<td class="datavalue_thin" colspan="2"><hr></td>
							</tr>
							<tr>
								<td nowrap class="datavalue_thin" colspan="2" align="center"><a href="gui_play_unit.php">Units</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:history.back();">BACK</a></td>
							</tr>
						</table>
					</td>
					<td width="5%" align="right" valign="top" class="datalabel">&nbsp;</td>
				</tr>
			</table>
		</div>

	</div>

<script>
	document.addEventListener('readystatechange', event => {
		if (event.target.readyState === "complete") {
			// console.log("<?= $sa ?>");
			showSpecialUnitAbility("<?= $sa ?>");
		}
	});
</script>

</body>

</html>
