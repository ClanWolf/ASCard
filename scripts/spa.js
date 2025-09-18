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

			//	"NAME": "ANIMAL MIMICRY",
			//	"UNITTYPE": "'Mechs, ProtoMechs (only if the model has four legs)",
			//	"SPACOST": "2 points",
			//	"BRIEF_DESCRIPTION":"Quadruped unit gains mobility bonus and ability to demoralize opponents",
			//	"RULE": "The pilot with this SPA has combined an exceptional understanding of animal behavior with his own natural aptitude at the controls to give the movements of his machine an uncanny— even frightening—resemblance to that of a wild animal.<br>This ability, which works only with Mech and ProtoMech units where the model has four legs, reduces the units Move cost for passing through ultra-heavy woods terrain, ultra-heavy jungle terrain, or any buildings by 2 inches per inch of movement. Furthermore, any enemy units that come within 6 inches of this unit must make a 2D6 roll, and will become Intimidated on a roll result of 8 or less. Units that are Intimidated in this fashion reduce their Move by half (round down) and suffer a +1 Target Number modifier for all attacks made against the animal-mimicking unit until after the next Movement Phase.",
			//	"SOURCE": "Alpha Strike Commanders Edition 7th",
			//	"PAGE": "92"

			document.getElementById("ut_desc").innerHTML = match.BRIEF_DESCRIPTION + "<br><br>" + match.RULE;
			document.getElementById("ut_name").innerHTML = match.NAME;
			document.getElementById("ut_variation").innerHTML = match.SPACOST;
			document.getElementById("ut_type").innerHTML = match.UNITTYPE;
			if (document.getElementById("ut_source") != null) {
				document.getElementById("ut_source").innerHTML = match.SOURCE;
			}
			if (document.getElementById("ut_page") != null) {
				document.getElementById("ut_page").innerHTML = "P. " + match.PAGE;
			}
//			var scrollcontainerdivs = document.getElementsByClassName("scroll-pane");
//			for(var i=0; i < scrollcontainerdivs.length; i++) {
//				if (scrollcontainerdivs[i].id === "spaInfo") {
//					// This is the scroll-pane in the spa detail pane
//					let ch = document.getElementById("scrollcont").offsetHeight;
//					//console.log("Height: " + ch);
//					scrollcontainerdivs[i].style.height = ch+"px";
//					$('.scroll-pane').jScrollPane();
//			    }
//			}
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
