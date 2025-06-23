// Until the masterunitlist is served over https, a CORS proxy is used to access mul
// in order to avoid security error messages and content blocking
var corsproxyprefix1 = "https://cors-anywhere.herokuapp.com/";
var corsproxyprefix2 = "https://cors.io/?";
var corsproxyprefix3 = "https://yacdn.org/proxy/";
var corsproxyprefix4 = "https://api.allorigins.win/get?url=";
var corsproxyprefix5 = "https://jsonp.afeld.me/?url=";

var corsproxyprefix = corsproxyprefix5;

function getUnitList(filter, tech, minTon, maxTon, category, unittypeString) {

	//console.log (filter);

	if (filter.length < 3) {
		filter = "";
	}

	var optionList = '';
	optionList = optionList + "<option><<< Select unit >>></option>";

	var url = corsproxyprefix + 'http://www.masterunitlist.info/Unit/QuickList';
		if (filter.length >= 3) {
			url = url + '?Name='				+ filter;
		} else {
			url = url + '?Name=';
		}
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
			url = url + '&Types=18';                    // BM
			url = url + '&Types=19';                    // Combat vehicles / Tanks
		}

	var cache_url = 'cache/mul/';
		if (tech == '2') {
			cache_url = cache_url + 'CLAN';
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

	//console.log("URL: " + url);
	//console.log("Cache: " + cache_url);

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

			//console.log("BFSize: " + unit.BFSize);

			if (unit.BFSize != "0") {
				var eraIdFilter = document.getElementById("CreateUnitEra").value;
				var unitIntroducedInYear = unit.DateIntroduced;

				var unitString = unit.Id + "> " + unit.Tonnage + "t | " + unit.Name + variant + unittypename;
				var unitStringLowerCase = unitString.toLowerCase();
				var filterLowerCase = filter.toLowerCase();

				if (unitStringLowerCase.includes(filterLowerCase)) {
					console.log("---------------------------------------");
					console.log("Unit introduced in year: " + unitIntroducedInYear);
					console.log("EraId (from filter): " + eraIdFilter);

					var unitValidInGivenEra = false;
					switch (eraIdFilter) {
						case "9":                        // 2005-2570: AGE OF WAR
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 2570) {
								unitValidInGivenEra = true;
							}
							break;
						case "10":                       // 2571-2780: STAR LEAGUE
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 2780) {
								unitValidInGivenEra = true;
							}
							break;
						case "11":                       // 2781-2900: EARLY SUCCESSION WARS
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 2900) {
								unitValidInGivenEra = true;
							}
							break;
						case "255":                      // 2901-3019: LATE SUCCESSION WARS - LOSTECH
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3019) {
								unitValidInGivenEra = true;
							}
							break;
						case "256":                      // 3020-3049: LATE SUCCESSION WARS - RENAISSANCE
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3049) {
								unitValidInGivenEra = true;
							}
							break;
						case "13":                       // 3050-3061: CLAN INVASION
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3061) {
								unitValidInGivenEra = true;
							}
							break;
						case "247":                      // 3062-3067: CIVIL WAR
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3067) {
								unitValidInGivenEra = true;
							}
							break;
						case "14":                       // 3068-3080: JIHAD
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3080) {
								unitValidInGivenEra = true;
							}
							break;
						case "15":                       // 3081-3100: EARLY REPUBLIC
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3100) {
								unitValidInGivenEra = true;
							}
							break;
						case "254":                      // 3101-3130: LATE REPUBLIC
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3130) {
								unitValidInGivenEra = true;
							}
							break;
						case "16":                       // 3131-3150: DARK AGE
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 3150) {
								unitValidInGivenEra = true;
							}
							break;
						case "257":                      // 3151-9999: ILCLAN
							if (unitIntroducedInYear >= 2005 && unitIntroducedInYear <= 9999) {
								unitValidInGivenEra = true;
							}
							break;
					}

					if (eraIdFilter == 0 || unitValidInGivenEra) {
						optionList = optionList + "<option value=" + unitString + "</option>";
						console.log("Adding: " + unitString);
					} else {
						console.log("NOT Adding: " + unitString);
					}
				}
			}
		});
	}).then(function data() {
		if (filter != "" && filter.length >= 3) { // If filter is set, user is looking for a specific unit

			document.getElementById("NameFilter").style.color="#fff";

			if (optionList == "<option><<< Select unit >>></option>") {
				// The unit in the filter did not return any matches. Search other brackets!
				console.log(filter + " has not returned any matches in category " + category + "!");

				(async () => {
					const response = await fetch("https://www.ascard.net/app/cache/mul/catalog.csv");
					const data = await response.text();
					const lines = data.split("\n");
					let i = 0;
					while (i < lines.length) {
						if (lines[i] != "") {
							const line = lines[i].split(";");
							// console.log(line[1]);
							if (filter.length >= 3 && line[1] !== undefined && line[1].includes(filter)) {
								let detectedUnitType = line[2];
								let detectedUnitSize = line[3];
								let detectedUnitTech = line[4];

								console.log("Found matching entry in catalog: " + lines[i]);
								console.log("Type: " + detectedUnitType);
								console.log("Size: " + detectedUnitSize);
								console.log("Tech: " + detectedUnitTech);

								// Set filter to new values
								if (detectedUnitType != "" && detectedUnitSize != "" && detectedUnitTech != "") {
									if (detectedUnitTech != 1 && detectedUnitTech != 2) {
										detectedUnitTech = 1;
									}
									// All values are set, we can set the filters
									console.log("Break search, set filter values.");

									document.getElementById("tech").setAttribute("onchange", "");
									document.getElementById("unittype").setAttribute("onchange", "");
									document.getElementById("tonnage").setAttribute("onchange", "");
									document.getElementById("NameFilter").setAttribute("onchange", "");
									document.getElementById("CreateUnitEra").setAttribute("onchange", "");

									document.getElementById("tech").value = detectedUnitTech;
									document.getElementById("CreateUnitEra").value = 0;
									document.getElementById("unittype").value = detectedUnitType;
									if (detectedUnitSize == 1) {
										document.getElementById("tonnage").value = "LIGHT";
									} else if (detectedUnitSize == 2) {
										document.getElementById("tonnage").value = "MEDIUM";
									} else if (detectedUnitSize == 3) {
										document.getElementById("tonnage").value = "HEAVY";
									} else if (detectedUnitSize == 4) {
										document.getElementById("tonnage").value = "ASSAULT";
									} else if (detectedUnitSize == 5) {
										document.getElementById("tonnage").value = "SUPERHEAVY";
									}

									document.getElementById("CreateUnitEra").style.color="#ffa72c";
									document.getElementById("tonnage").style.color="#ffa72c";
									document.getElementById("tech").style.color="#ffa72c";
									document.getElementById("unittype").style.color="#ffa72c";

									document.getElementById("tech").setAttribute("onchange", "fetchUnitList();");
									document.getElementById("unittype").setAttribute("onchange", "fetchUnitList();");
									document.getElementById("tonnage").setAttribute("onchange", "fetchUnitList();");
									document.getElementById("NameFilter").setAttribute("onchange", "fetchUnitList();");
									document.getElementById("CreateUnitEra").setAttribute("onchange", "fetchUnitList();");

									fetchUnitList();

									break;
								} else {
									console.log("Not viable unit found, continue search.");
								}
							}
						}
						i++;
					}
				})();
			} else {
				// Units where found with this filter
				console.log(filter + " matched!");
			}
		} else {
			document.getElementById("NameFilter").style.color="#f00";
			document.getElementById("tonnage").style.color="#fff";
			document.getElementById("tech").style.color="#fff";
			document.getElementById("unittype").style.color="#fff";
		}

		document.getElementById("units").innerHTML = optionList;

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

		document.getElementById("RULES").value="";
		document.getElementById("COST").value="";
		document.getElementById("BV").value="";
		document.getElementById("ERAID").value="";
		document.getElementById("ERASTART").value="";
		document.getElementById("DATEINTRO").value="";
		document.getElementById("UNITCLASS").value="";
		document.getElementById("UNITVARIANT").value="";

		document.getElementById("DMGE").value="";
	});
}

function getUnitDetails(id) {
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

		document.getElementById("RULES").value="";
		document.getElementById("COST").value="";
		document.getElementById("BV").value="";
		document.getElementById("ERAID").value="";
		document.getElementById("ERASTART").value="";
		document.getElementById("DATEINTRO").value="";
		document.getElementById("UNITCLASS").value="";
		document.getElementById("UNITVARIANT").value="";

		document.getElementById("DMGE").value="";

		return;
	}

	var url = corsproxyprefix + 'http://www.masterunitlist.info/Unit/QuickDetails?id=' + id;
	var cache_details_url = 'cache/mul/unitdetails/' + id + '.json';

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

		document.getElementById("RULES").value=json.Rules;
		document.getElementById("COST").value=json.Cost;
		document.getElementById("BV").value=json.BattleValue;
		document.getElementById("ERAID").value=json.EraId;
		document.getElementById("ERASTART").value=json.EraStart;
		document.getElementById("DATEINTRO").value=json.DateIntroduced;
		document.getElementById("UNITCLASS").value=json.Class;
		document.getElementById("UNITVARIANT").value=json.Variant;

		document.getElementById("DMGE").value=json.BFDamageExtreme;
	});
}

function unitSelected() {
	var e = document.getElementById("units");
	var id = e.options[e.selectedIndex].value;
	getUnitDetails(id);
}

function fetchUnitList() {

	//console.log("fetchUnitList");

	setCookie("UnitFilter_Tech", document.getElementById("tech").value, 365);
	setCookie("UnitFilter_Type", document.getElementById("unittype").value, 365);
	setCookie("UnitFilter_Weight", document.getElementById("tonnage").value, 365);
	setCookie("UnitFilter_String", document.getElementById("NameFilter").value, 365);
	setCookie("UnitFilter_Era", document.getElementById("CreateUnitEra").value, 365);

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
		getUnitList(filter, techid, 0, 2, 'BA', unittypevalue);
	} else if (tonnagevalue == 'LIGHT') {
		getUnitList(filter, techid, 20, 35, 'LIGHT', unittypevalue);
	} else if (tonnagevalue == 'MEDIUM') {
		getUnitList(filter, techid, 40, 55, 'MEDIUM', unittypevalue);
	} else if (tonnagevalue == 'HEAVY') {
		getUnitList(filter, techid, 60, 75, 'HEAVY', unittypevalue);
	} else if (tonnagevalue == 'ASSAULT') {
		getUnitList(filter, techid, 80, 100, 'ASSAULT', unittypevalue);
	} else if (tonnagevalue == 'SUPERHEAVY') {
		getUnitList(filter, techid, 105, 200, 'SUPERHEAVY', unittypevalue);
//	} else {
//		getUnitList(filter, techid, tonnagevalue, tonnagevalue, '');
	}
}
