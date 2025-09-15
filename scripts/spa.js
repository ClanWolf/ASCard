function getSpecialPilotAbilities(spa) {
	// Read special abilities from json file
	var cache_url = 'https://www.ascard.net/app/data/specialabilities/specialpilotabilities.json';
	var match = null;

	//console.log("Searching: " + spa);

	$.getJSON(cache_url, function (json) {
		json.specialpilotabilities.sort(function(a, b) {
			if (a.NAME < b.NAME) return -1;
			if (a.NAME > b.NAME) return 1;
		});
		$.each(json.specialpilotabilities, function (i, specialpilotability) {
			let specialpilotabilityName = specialpilotability.NAME.toUpperCase();

			//console.log("1: " + spa);
			//console.log("2: " + specialpilotabilityName);

			if (spa.toUpperCase().startsWith(specialpilotabilityName)) {
				match = specialpilotability;
				//console.log("Found: " + match.NAME);
			}
		});
	}).then(function data() {
		if (match != null) {
			document.getElementById("ut_desc").innerHTML = match.DESCRIPTION + "<br><br>" + match.REQUIREMENTS + "<br><br>" + match.BONUSABILITY;
			document.getElementById("ut_name").innerHTML = match.NAME;
			document.getElementById("ut_variation").innerHTML = match.VARIATION;
			document.getElementById("ut_type").innerHTML = match.UNITTYPE;
			if (document.getElementById("ut_source") != null) {
				document.getElementById("ut_source").innerHTML = match.SOURCE;
			}
			if (document.getElementById("ut_page") != null) {
				document.getElementById("ut_page").innerHTML = "P. " + match.PAGE;
			}
			$('.scroll-pane').jScrollPane();
		} else {
			var errortext = "NO DATA FOUND";
			document.getElementById("ut_desc").innerHTML = errortext;
			document.getElementById("ut_name").innerHTML = errortext;
			document.getElementById("ut_variation").innerHTML = errortext;
			document.getElementById("ut_type").innerHTML = errortext;
			if (document.getElementById("ut_source") != null) {
				document.getElementById("ut_source").innerHTML = errortext;
			}
			if (document.getElementById("ut_page") != null) {
				document.getElementById("ut_page").innerHTML = "P. " + errortext;
			}
		}
	});
}

function showSpa(spa) {
	getSpecialPilotAbilities(spa);
}
