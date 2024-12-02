// Until the masterunitlist is served over https, a CORS proxy is used to access mul
// in order to avoid security error messages and content blocking
var corsproxyprefix1 = "https://cors-anywhere.herokuapp.com/";
var corsproxyprefix2 = "https://cors.io/?";
var corsproxyprefix3 = "https://yacdn.org/proxy/";
var corsproxyprefix4 = "https://api.allorigins.win/get?url=";
var corsproxyprefix5 = "https://jsonp.afeld.me/?url=";

var corsproxyprefix = corsproxyprefix5;

function getMechList(filter, tech, minTon, maxTon, category, unittypeString) {

	//console.log (filter);

	var optionList = '';
	optionList = optionList + "<option><<< Select unit >>></option>";

	var url = corsproxyprefix + 'http://www.masterunitlist.info/Unit/QuickList';
		url = url + '?Name='					+ filter;
		url = url + '&HasBV=false';
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
		url = url + '&Technologies='			+ tech;
		url = url + '&BookAuto=';
		url = url + '&FactionAuto=';
		if (maxTon == '2') {
			url = url + '&Types=21';                    // Infantry
			url = url + '&SubTypes=28';                 // Elementals / Battle Armor
		} else {
			url = url + '&MinTons='				+ minTon;
			url = url + '&MaxTons='				+ maxTon;
			url = url + '&Types=17';                    // Aerospace
			url = url + '&Types=18';                    // Mechs
			url = url + '&Types=19';                    // Combat vehicles / Tanks
		}

	var cache_url = 'cache/mul/';
		if (tech == '2') {
			cache_url = cache_url + 'Clan';
		} else {
			cache_url = cache_url + 'IS';
		}
		cache_url = cache_url + '_';
		if (category != '') {
			cache_url = cache_url + category;
		} else {
			cache_url = cache_url + maxTon;
		}
		if (unittypeString != 'BA') {
			cache_url = cache_url + '_' + unittypeString;
		}
		cache_url = cache_url + '.json';

	console.log("URL: " + url);
	console.log("Cache: " + cache_url);

	$.getJSON(cache_url, function (json) {
		json.Units.sort(function(a, b) {
		    if (a.Name < b.Name) return -1;
			if (a.Name > b.Name) return 1;
		});
		$.each(json.Units, function (i, unit) {
			var variant = unit.variant;
			var unittypeid = unit.Type.Id;
			var unittypename = unit.BFType;

			// console.log(unit.Type.Id);
			// if (unittypeid === 19) {
				// console.log(unit.Name);
			// }

			if (unittypename !== undefined) {
				unittypename = " [" + unit.BFType + "]"
			} else {
				unittypename = "";
			}

			if (variant !== undefined) {
				variant = " / " + variant;
			} else {
				variant = "";
			}
			if (unit.BFSize != "0") {
				var unitString = unit.Id + "> " + unit.Name + variant + unittypename;
				var unitStringLowerCase = unitString.toLowerCase();
				var filterLowerCase = filter.toLowerCase();

				if (unitStringLowerCase.includes(filterLowerCase)) {
					optionList = optionList + "<option value=" + unitString + "</option>";
				}
			}
		});
	}).then(function data() {
		document.getElementById("units").innerHTML = optionList;
		// document.getElementById("url").innerHTML=url;

		document.getElementById("TP").value="";
		document.getElementById("SZ").value="";
		document.getElementById("TMM").value="";
		document.getElementById("MV").value="";
		document.getElementById("ROLE").value="";
		//document.getElementById("SKILL").value="";
		document.getElementById("DMGS").value="";
		document.getElementById("DMGM").value="";
		document.getElementById("DMGL").value="";
		document.getElementById("OV").value="";
		document.getElementById("A").value="";
		document.getElementById("S").value="";
		document.getElementById("SPCL").value="";
		document.getElementById("PVA").value="";
		document.getElementById("F_TON").value="";
		document.getElementById("TECH").value="";
	});
}

function getMechDetails(id) {
	if (id == "<<< Select unit >>>") {
		document.getElementById("TP").value="";
		document.getElementById("SZ").value="";
		document.getElementById("TMM").value="";
		document.getElementById("MV").value="";
		document.getElementById("ROLE").value="";
		//document.getElementById("SKILL").value="";
		document.getElementById("DMGS").value="";
		document.getElementById("DMGM").value="";
		document.getElementById("DMGL").value="";
		document.getElementById("OV").value="";
		document.getElementById("A").value="";
		document.getElementById("S").value="";
		document.getElementById("SPCL").value="";
		document.getElementById("PVA").value="";
		document.getElementById("F_TON").value="";
		document.getElementById("TECH").value="";

		return;
	}

	var url = corsproxyprefix + 'http://www.masterunitlist.info/Unit/QuickDetails?id=' + id;
	var cache_details_url = 'cache/mul/mechdetails/' + id + '.json';

	// $.getJSON(url, function (json) {
	$.getJSON(cache_details_url, function (json) {

		// An asterisk (*) --> &#42;
		var sp = json.BFAbilities;
		if (sp) {
			var spcl = sp.replace(/\*/g, "&#42;");
		} else {
			var spcl = "-";
		}

		//console.log("TECH: " + json.Technology.Id);

		document.getElementById("TP").value=json.BFType;
		document.getElementById("SZ").value=json.BFSize;
		document.getElementById("TMM").value=json.BFTMM;
		document.getElementById("MV").value=json.BFMove;
		document.getElementById("ROLE").value=json.Role.Name;
		//document.getElementById("SKILL").value=json.Skill;
		//document.getElementById("SKILL").value=3;
		document.getElementById("DMGS").value=json.BFDamageShort;
		document.getElementById("DMGM").value=json.BFDamageMedium;
		document.getElementById("DMGL").value=json.BFDamageLong;
		document.getElementById("OV").value=json.BFOverheat;
		document.getElementById("A").value=json.BFArmor;
		document.getElementById("S").value=json.BFStructure;
		document.getElementById("SPCL").value=spcl;
		document.getElementById("PVA").value=json.BFPointValue;
		document.getElementById("F_TON").value=json.Tonnage;
		document.getElementById("TECH").value=json.Technology.Id;
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
	var unittype = document.getElementById("unittype");
	var tonnage = document.getElementById("tonnage");
	var weightBlock = document.getElementById("weightBlock");
	var unittypevalue = unittype.options[unittype.selectedIndex].value;
	var tonnagevalue = tonnage.options[tonnage.selectedIndex].value;
	var filter = document.getElementById("NameFilter").value;

	if (tonnagevalue == '0') {
		tonnagevalue = '';
	}

	if (unittypevalue == "BA") {
		tonnage.disabled = true;
		weightBlock.style.visibility='hidden';
		weightBlock.style.display='none';
	} else {
		tonnage.disabled = false;
		weightBlock.style.visibility='visible';
		weightBlock.style.display='inline';
	}

	// console.log(unittypevalue);
	// console.log(tonnagevalue);

	if (unittypevalue == "BA") {
		getMechList(filter, techid, 0, 2, 'BA', unittypevalue);
	} else if (tonnagevalue == 'LIGHT') {
		getMechList(filter, techid, 20, 35, 'LIGHT', unittypevalue);
	} else if (tonnagevalue == 'MEDIUM') {
		getMechList(filter, techid, 40, 55, 'MEDIUM', unittypevalue);
	} else if (tonnagevalue == 'HEAVY') {
		getMechList(filter, techid, 60, 75, 'HEAVY', unittypevalue);
	} else if (tonnagevalue == 'ASSAULT') {
		getMechList(filter, techid, 80, 100, 'ASSAULT', unittypevalue);
	} else if (tonnagevalue == 'SUPERHEAVY') {
		getMechList(filter, techid, 105, 200, 'SUPERHEAVY', unittypevalue);
//	} else {
//		getMechList(filter, techid, tonnagevalue, tonnagevalue, '');
	}
}
