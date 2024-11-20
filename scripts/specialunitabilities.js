// Read special abilities from json file

function getSpecialAbilities() {
	$.getJSON(cache_url, function (json) {
		json.SpecialAbilities.sort(function(a, b) {
		    if (a.Name < b.Name) return -1;
			if (a.Name > b.Name) return 1;
		});
		$.each(json.SpecialAbilities, function (i, specialAbility) {
			var name = specialAbility.name;

		  console.log(name);

		});
	}).then(function data() {
		document.getElementById("units").innerHTML = optionList;
	});
}
