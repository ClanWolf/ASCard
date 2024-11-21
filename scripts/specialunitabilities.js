// Read special abilities from json file

function getSpecialUnitAbilities() {
	var cache_url = 'https://www.clanwolf.net/apps/ASCard/data/specialabilities/specialunitabilities.json';

	$.getJSON(cache_url, function (json) {
		json.SpecialAbilities.sort(function(a, b) {
			if (a.NAME < b.NAME) return -1;
			if (a.NAME > b.NAME) return 1;
		});
		$.each(json.SpecialAbilities, function (i, specialAbility) {
			var name = specialAbility.NAME;
			console.log(name);
		});
	}).then(function data() {
		document.getElementById("units").innerHTML = optionList;
	});
}

function showSpecialUnitAbility(sa) {
	//alert("working: " + sa);
}
