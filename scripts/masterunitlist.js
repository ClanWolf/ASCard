function getMechList(filter, tech, minTon, maxTon) {
	var optionList = '';
	var url = 'https://www.masterunitlist.info/Unit/QuickList';
		url = url + '?Name='			+ filter;
		url = url + '&HasBV=false';
		url = url + '&MinTons='			+ minTon;
		url = url + '&MaxTons='			+ maxTon;
		url = url + '&MinBV=';
		url = url + '&MaxBV=';
		url = url + '&MinIntro=';
		url = url + '&MaxIntro=';
		url = url + '&MinCost=';
		url = url + '&MaxCost=';
		url = url + '&HasRole=';
		url = url + '&HasBFAbility=';
		url = url + '&MinPV=';
		url = url + '&MaxPV=';
		url = url + '&Role=None+Selected';
		url = url + '&Technologies='	+ tech;
		url = url + '&Types=18';
		url = url + '&BookAuto=';
		url = url + '&FactionAuto=';
	$.getJSON(url, function (json) {
		json.Units.sort(function(a, b) {
		    if (a.Name < b.Name) return -1;
			if (a.Name > b.Name) return 1;
		});
		$.each(json.Units, function (i, unit) {
			var variant = unit.variant;
			if (variant !== undefined) {
				variant = " / " + variant;
			} else {
				variant = "";
			}
			optionList = optionList + "<option value=" + unit.Id + "> " + unit.Name + variant + " (" + unit.Tonnage + "t)</option>";
		});
	}).then(function data() {
		document.getElementById("units").innerHTML = optionList;
		// document.getElementById("url").innerHTML=url;

		document.getElementById("TP").value="";
		document.getElementById("SZ").value="";
		document.getElementById("TMM").value="";
		document.getElementById("MV").value="";
		document.getElementById("ROLE").value="";
		document.getElementById("SKILL").value="";
		document.getElementById("DMGS").value="";
		document.getElementById("DMGM").value="";
		document.getElementById("DMGL").value="";
		document.getElementById("OV").value="";
		document.getElementById("A").value="";
		document.getElementById("S").value="";
		document.getElementById("SPCL").value="";

		document.getElementById("PVA").value=json="";
	});
}

function getMechDetails(id) {
	var url = 'https://www.masterunitlist.info/Unit/QuickDetails?id=' + id;
	$.getJSON(url, function (json) {
		document.getElementById("TP").value=json.BFType;
		document.getElementById("SZ").value=json.BFSize;
		document.getElementById("TMM").value=json.BFTmm;
		document.getElementById("MV").value=json.BFMove;
		document.getElementById("ROLE").value=json.Role.Name;
		document.getElementById("SKILL").value=json.Skill;
		document.getElementById("DMGS").value=json.BFDamageShort;
		document.getElementById("DMGM").value=json.BFDamageMedium;
		document.getElementById("DMGL").value=json.BFDamageLong;
		document.getElementById("OV").value=json.BFOverheat;
		document.getElementById("A").value=json.BFArmor;
		document.getElementById("S").value=json.BFStructure;
		document.getElementById("SPCL").value=json.BFAbilities;

		document.getElementById("PVA").value=json.BFPointValue;
	});
}

function mechSelected() {
	var e = document.getElementById("units");
	var id = e.options[e.selectedIndex].value;
	getMechDetails(id);
}

function fetchMechList() {
	var tech = document.getElementById("tech");
	var techid = tech.options[tech.selectedIndex].value;
	var tonnage = document.getElementById("tonnage");
	var tonnagevalue = tonnage.options[tonnage.selectedIndex].value;
	var filter = document.getElementById("NameFilter").value;

	if (tonnagevalue == '0') {
		tonnagevalue = '';
	}
	getMechList(filter, techid, tonnagevalue, tonnagevalue);
}
