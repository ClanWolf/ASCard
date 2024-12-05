function getSpecialUnitAbilities(sa) {
	// Read special abilities from json file
	var cache_url = 'https://www.ascard.net/app/data/specialabilities/specialunitabilities.json';
	var match = null;
	var alphabetNavigation = "";
	var subNavigation = "";
	var currentLetter = "#";

	// console.log("Searching: " + sa);

	$.getJSON(cache_url, function (json) {
		json.SpecialUnitAbilities.sort(function(a, b) {
			if (a.ABBREVIATION < b.ABBREVIATION) return -1;
			if (a.ABBREVIATION > b.ABBREVIATION) return 1;
		});
		$.each(json.SpecialUnitAbilities, function (i, specialAbility) {
			var shortenedSA = specialAbility.ABBREVIATION;
			if (specialAbility.ABBREVIATION.indexOf('#') > 0) {
				shortenedSA = specialAbility.ABBREVIATION.substring(0, specialAbility.ABBREVIATION.indexOf('#')).replace("(", "").replace("X-", "").trim();
			}

			if (shortenedSA.substring(0, 1) != currentLetter) {
				// console.log(shortenedSA + " - " + shortenedSA.substring(0, 1) + " - " + currentLetter);
				currentLetter = shortenedSA.substring(0, 1);
				alphabetNavigation = alphabetNavigation + "<a style='font-size:1.3em;' href='gui_show_specialabilities.php?sa=" + shortenedSA + "'>" + currentLetter + "</a>&nbsp;&nbsp;&nbsp;";
			}

			if (sa.substring(0, 1) == shortenedSA.substring(0, 1)) {
				subNavigation = subNavigation + "<a style='font-size:1.2em;' href='javascript:getSpecialUnitAbilities(\"" + shortenedSA + "\");'>" + shortenedSA + "</a>&nbsp;&nbsp;&nbsp;";
			}

			if (shortenedSA == sa) {
				match = specialAbility;
				// console.log("Found: " + specialAbility.ABBREVIATION);
			}
		});
	}).then(function data() {
		if (match != null) {
			document.getElementById("sa_abbreviation").innerHTML = match.ABBREVIATION;
			document.getElementById("sa_name").innerHTML = match.NAME;
			document.getElementById("sa_rule").innerHTML = match.RULE;
			document.getElementById("sa_type").innerHTML = match.TYPE;
			if (document.getElementById("sa_source") != null) {
				document.getElementById("sa_source").innerHTML = match.SOURCE;
			}
			if (document.getElementById("sa_page") != null) {
				document.getElementById("sa_page").innerHTML = "P. " + match.PAGE;
			}
		} else {
			var errortext = "NO DATA FOUND";
			document.getElementById("sa_abbreviation").innerHTML = errortext;
			document.getElementById("sa_name").innerHTML = errortext;
			document.getElementById("sa_rule").innerHTML = errortext;
			document.getElementById("sa_type").innerHTML = errortext;
			if (document.getElementById("sa_source") != null) {
				document.getElementById("sa_source").innerHTML = errortext;
			}
			if (document.getElementById("sa_page") != null) {
				document.getElementById("sa_page").innerHTML = "P. " + errortext;
			}
		}

		if (document.getElementById("alphabeticalNavigation") != null) {
			document.getElementById("alphabeticalNavigation").innerHTML = alphabetNavigation;
		}
		if (document.getElementById("specialunitabilitiesNavigation") != null) {
			document.getElementById("specialunitabilitiesNavigation").innerHTML = subNavigation;
		}
	});
}

function showSpecialUnitAbility(sa) {
	getSpecialUnitAbilities(sa);
}
