function getFormationTypes(ft) {
	// Read special abilities from json file
	var cache_url = 'https://www.ascard.net/app/data/specialabilities/formationtypes.json';
	var match = null;
	var alphabetNavigation = "";
	var subNavigation = "";
	var currentLetter = "#";

	console.log("Searching for: " + ft);

	$.getJSON(cache_url, function (json) {
		json.formationtypes.sort(function(a, b) {
			if (a.NAME < b.NAME) return -1;
			if (a.NAME > b.NAME) return 1;
		});
		$.each(json.formationtypes, function (i, formationtype) {
			let fullName = "";
			let formationtypeName = formationtype.NAME;
			let formationtypeVariation = formationtype.VARIATION;

			if (formationtypeVariation !== "NONE" && formationtypeVariation) {
				fullName = formationtypeVariation + " ";
			}
			if (formationtypeName) {
				fullName = fullName + formationtypeName;
			}

			//console.log("C: '" + ft + "' with '" + fullName + "'");

			if (ft == fullName) {
				match = formationtype;
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

function showFormationType(ft) {
	getFormationTypes(ft);
}
