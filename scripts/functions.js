var fontsizeLabel = 12;

var minSize = 20;
var maxSize = 60;

var fontsizeLabelBigFactor = 1.8;
var fontsizeLabelthinFactor = 0.6;
var fontsizeLabelthinSmallFactor = 0.6;
var fontsizeValueFactor = 1.2;
var fontsizeValueThinFactor = 0.6;
var fontsizeCircleFactor = 0.85;

var fontsizeLabelBig = fontsizeLabel * fontsizeLabelBigFactor;
var fontsizeLabelthin = fontsizeLabel * fontsizeLabelthinFactor;
var fontsizeLabelthinSmall = fontsizeLabel * fontsizeLabelthinSmallFactor;
var fontsizeValue = fontsizeLabel * fontsizeValueFactor;
var fontsizeValueThin = fontsizeLabel * fontsizeValueThinFactor;
var fontsizeCircle = fontsizeLabel * fontsizeCircleFactor;

var tc_enemyTMM = 2;
var tc_amm = 0;
var tc_skill = 0;
var tc_rangeValue = 2;
var tc_partialCover = 0;
var tc_wood = 0;
var tc_heat;
var tc_other = 0;
var tc_firecontrolDamage;

var rolling = 0;
var ccc = 1;
var structuralDamageCache = 0;

var unitstatus = 1; // 1: green (untouched) | 2: yellow (hit) | 3: red (crit) | 4: black (wrecked) | 9: crippled
var enginehit = 0;
var updatedshortvalue = 0;
var updatedmediumvalue = 2;
var updatedlongvalue = 4;

var context = null;

// http://goldfirestudios.com/blog/104/howler.js-Modern-Web-Audio-Javascript-Library
var sound_dice = null;
var sound_key = null;
var sound_keyTC = null;
var sound_openTC = null;
var sound_closeTC = null;
var sound_error = null;
var sound_01 = null;
var sound_02 = null;
var sound_03 = null;
var sound_04 = null;
var sound_05 = null;
var sound_06 = null;
var sound_07 = null;
var sound_08 = null;
var sound_09 = null;
var sound_SB = null;

var showingUnit = false;

var skipTapSample = false;

function setSize(name, value) {
	var list = document.getElementsByClassName(name);
	[].forEach.call(list, function (el) {
		el.style.fontSize="" + value + "px";
	});
}

function readCircles(index3, a_max3, s_max3) {
	readCircles2(index3, a_max3, s_max3, -1, -1);
}

function readCircles2(index, a_max, s_max, mv_bt_id, f_bt_id) {
	if (context != null) {
		if (skipTapSample == false) {
			playTapSound();
		}
	}

	var na = "";

	var h = 0;
	var a = 0;
	var s = 0;
	var e = 0;
	var fc = 0;
	var mp = 0;
	var w = 0;

	var e_cv = 0;  // CV (Combat vehicle: Engine)
	var fc_cv = 0; // CV (Combat vehicle: Fire control)
	var w_cv = 0;  // CV (Combat vehicle: Weapons)
	var ma_cv = 0; // CV (Combat vehicle: Motive A)
	var mb_cv = 0; // CV (Combat vehicle: Motive B)
	var mc_cv = 0; // CV (Combat vehicle: Motive C)

	var uov = 0; // used overheat
	var NARCed = 0;
	var TAGed = 0;
	var WATERed = 0;
	var ROUTed = 0;

	var mvmnt = 0;
	var wpnsf = 0;

	var unitstatus = 1;
	var unitstatusstring = "fresh";
	var unitstatusimage = "images/DD_BM_01.png";

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		na = el1.name;
		if (typeof na != 'undefined') {
			if (na.substring(0, 1) == "H"         && el1.checked) { h++;     }
			if (na.substring(0, 1) == "A"         && el1.checked) { a++;     }
			if (na.substring(0, 1) == "S"         && el1.checked) { s++;     }
			if (na.substring(0, 5) == "CD_E_"     && el1.checked) { e++;     }
			if (na.substring(0, 6) == "CD_FC_"    && el1.checked) { fc++;    }
			if (na.substring(0, 6) == "CD_MP_"    && el1.checked) { mp++;    }
			if (na.substring(0, 5) == "CD_W_"     && el1.checked) { w++;     }

			if (na.substring(0, 8) == "CD_CV-E_"  && el1.checked) { e_cv++;  }
			if (na.substring(0, 9) == "CD_CV-FC_" && el1.checked) { fc_cv++; }
			if (na.substring(0, 8) == "CD_CV-W_"  && el1.checked) { w_cv++;  }
			if (na.substring(0, 9) == "CD_CV-MA_" && el1.checked) { ma_cv++; }
			if (na.substring(0, 9) == "CD_CV-MB_" && el1.checked) { mb_cv++; }
			if (na.substring(0, 9) == "CD_CV-MC_" && el1.checked) { mc_cv++; }

			if (na.substring(0, 3) == "UOV"       && el1.checked) { uov++;   }

			if (na.substring(0, 4) == "NARC"      && el1.checked) { NARCed  = 1; }
			if (na.substring(0, 3) == "TAG"       && el1.checked) { TAGed   = 1; }
			if (na.substring(0, 5) == "WATER"     && el1.checked) { WATERed = 1; }
			if (na.substring(0, 6) == "ROUTED"    && el1.checked) { ROUTed  = 1; }
		}
	});

	var radioMV2_moved2_standstill = document.getElementById("MV2_moved2_standstill");
	var radioMV10_moved10_hulldown = document.getElementById("MV10_moved10_hulldown");
	var radioMV3_moved3_moved = document.getElementById("MV3_moved3_moved");
	var radioMV9_moved9_sprinted = document.getElementById("MV9_moved9_sprinted");
	var radioMV4_moved4_jumped = document.getElementById("MV4_moved4_jumped");
	var radioWF5_WEAPONSFIRED2 = document.getElementById("WF5_WEAPONSFIRED2");
	var radioWF6_WEAPONSFIRED2 = document.getElementById("WF6_WEAPONSFIRED2");

	if (radioMV2_moved2_standstill.checked && mv_bt_id == 2) { // standstill
		mvmnt = 2;
	}
	if (radioMV10_moved10_hulldown.checked && mv_bt_id == 10) { // hulldown
		mvmnt = 10;
	}
	if (radioMV3_moved3_moved.checked && mv_bt_id == 3) { // walked
		mvmnt = 3;
	}
	if (radioMV9_moved9_sprinted.checked && mv_bt_id == 9) { // sprinted
		mvmnt = 9;
	}
	if (radioMV4_moved4_jumped.checked && mv_bt_id == 4) { // jumped
		mvmnt = 4;
	}

	if (mv_bt_id == -1) {
		if (radioMV2_moved2_standstill.checked) { mvmnt = 2;  }
		if (radioMV10_moved10_hulldown.checked) { mvmnt = 10; }
		if (radioMV3_moved3_moved.checked)      { mvmnt = 3;  }
		if (radioMV9_moved9_sprinted.checked)   { mvmnt = 9;  }
		if (radioMV4_moved4_jumped.checked)     { mvmnt = 4;  }
	}

	if (radioWF5_WEAPONSFIRED2.checked && f_bt_id == 1) { // hold fire
		wpnsf = 1;
	}
	if (radioWF6_WEAPONSFIRED2.checked && f_bt_id == 2) { // weapons fired
		wpnsf = 2;
	}

	if (f_bt_id == -1) {
		if (radioWF5_WEAPONSFIRED2.checked) { wpnsf = 1; }
		if (radioWF6_WEAPONSFIRED2.checked) { wpnsf = 2; }
	}

	if (e == 1) {
		if (enginehit == 0) {
			enginehit = 1;
			h = h + 1;
		}
	} else {
		if (enginehit == 1) {
			enginehit = 0;
			h = h - 1;
		}
	}
	if (h > 4) {
		h = 4;
	}
	if (h < 0) {
		h = 0;
	}
	if (e == 1 && h == 0) {
		h = 1;
	}
	if (e == 2) {
		h = 4;
	}
	if (s == 1 && a < maximalarmorpoints) {
		s = 0;
		a = a + 1;
	}
	if (s > 0 && a < maximalarmorpoints) {
		s = s - 1;
		a = a + 1;
	}
	// unitstatusstring: fresh, damaged, critical, crippled, destroyed

	var currentUnitType = document.getElementById('unit_type').innerText;
	currentUnitType = currentUnitType.substring(0, currentUnitType.indexOf('/')); // Cut off size and tonnage
	unitstatus = 1;
	unitstatusstring = "fresh";
	unitstatusimage = "images/DD_" + currentUnitType + "_01.png";
	if (a > 0) {
		unitstatus = 2;
		unitstatusstring = "damaged";
		unitstatusimage = "images/DD_" + currentUnitType + "_02.png";
	}
	if (s > 0) {
		unitstatus = 3;
		unitstatusstring = "critical";
		unitstatusimage = "images/DD_" + currentUnitType + "_03.png";
	}
	if (a == maximalarmorpoints && maximalstructurepoints == 1) {
		unitstatus = 9;
		unitstatusstring = "crippled";
		unitstatusimage = "images/DD_" + currentUnitType + "_03.png";
	}
	if (s >= maximalstructurepoints / 2) {
		unitstatus = 9;
		unitstatusstring = "crippled";
		unitstatusimage = "images/DD_" + currentUnitType + "_03.png";
	}
	if (s == maximalstructurepoints) {
		unitstatus = 4;
		unitstatusstring = "destroyed";
		unitstatusimage = "images/DD_" + currentUnitType + "_04.png";
	}
	if (e == 2) {
		unitstatus = 4;
		unitstatusstring = "destroyed";
		unitstatusimage = "images/DD_" + currentUnitType + "_04.png";
	}

	document.getElementById('unitstatusimagemenu').src=unitstatusimage;

	if (mvmnt == 9) {
		wpnsf = 1;
	}

	var tc_rangeValueReading = 2;
	if (document.getElementById("ToHitShort").checked == true
		&& document.getElementById("ToHitMedium").checked == false
		&& document.getElementById("ToHitLong").checked == false) {
			tc_rangeValueReading = 0;
	} else if (document.getElementById("ToHitShort").checked == false
		&& document.getElementById("ToHitMedium").checked == true
		&& document.getElementById("ToHitLong").checked == false) {
			tc_rangeValueReading = 2;
	} else if (document.getElementById("ToHitShort").checked == false
		&& document.getElementById("ToHitMedium").checked == false
		&& document.getElementById("ToHitLong").checked == true) {
			tc_rangeValueReading = 4;
	}
	var tc_partialCoverReading = 0;
	if (document.getElementById("ToHitCover").checked == true) {
		tc_partialCoverReading = 1;
	} else if (document.getElementById("ToHitCover").checked == false) {
		tc_partialCoverReading = 0;
	}

	if (mvmnt <= 0 && wpnsf > 0) {
		wpnsf = 0; // If weaponsfired was clicked without a movement specified, the weapons value will NOT be saved
	}

	setCircles(h, a, s, e, fc, mp, w, e_cv, fc_cv, w_cv, ma_cv, mb_cv, mc_cv, uov, mvmnt, wpnsf, tc_rangeValueReading, tc_partialCoverReading, unitstatusstring, NARCed, TAGed, WATERed, ROUTed);
	var url="./save.php?index="+index+"&h="+h+"&a="+a+"&s="+s+"&e="+e+"&fc="+fc+"&mp="+mp+"&w="+w+"&e_cv="+e_cv+"&fc_cv="+fc_cv+"&w_cv="+w_cv+"&ma_cv="+ma_cv+"&mb_cv="+mb_cv+"&mc_cv="+mc_cv+"&mstat="+unitstatusimage+"&mstatstr="+unitstatusstring+"&uov="+uov+"&mvmnt="+mvmnt+"&wpnsf="+wpnsf+"&currentRound="+currentRound+"&narc="+NARCed+"&tag="+TAGed+"&water="+WATERed+"&routed="+ROUTed+"&gameid="+gameid;
	//alert(url);
	window.frames['saveframe'].location.replace(url);

	if (currentUnitType == "CV") {
		if ((a > currentA) || (s > currentS)) {
			showDiceBar();
		}
	} else {
		if (currentUnitType != "BA") {
			if (s > structuralDamageCache) {
				showDiceBar();
			}
		}
	}
	currentA = a;
	currentS = s;

	structuralDamageCache = s;
}

function setStructuralDamageCache(value) {
	structuralDamageCache = value;
}

// SetCircles is called from gui_play_unit.php as well!
function setCircles(h, a, s, e, fc, mp, w, e_cv, fc_cv, w_cv, ma_cv, mb_cv, mc_cv, uov, mvmnt, wpnsf, tc_rangeValueReading, tc_partialCoverReading, unitstatusstring, NARCed, TAGed, WATERed, ROUTed) {

	// $("#topmiddlebackground").hide();
	$("#crippledIndicator").hide();
	$("#shutdownIndicator").hide();
	$("#destroyedIndicator").hide();
	$("#narcIndicator").hide();
	$("#tagIndicator").hide();
	$("#waterIndicator").hide();
	$("#routedIndicator").hide();

	var na1 = "";

	tc_heat = h;
	if (unitType == "CV") {
		tc_firecontrolDamage = fc_cv * 2;
	} else if (unitType == "BM" || unitType == "BA") {
		tc_firecontrolDamage = fc * 2;
	}

	var h_c = 0;
	var a_c = 0;
	var s_c = 0;
	var e_c = 0;
	var fc_c = 0;
	var mp_c = 0;
	var w_c = 0;

	var e_cv_c = 0;
	var fc_cv_c = 0;
	var w_cv_c = 0;
	var ma_cv_c = 0;
	var mb_cv_c = 0;
	var mc_cv_c = 0;

	var uov_c = 0;

	unitstatus = 1;
	updatedshortvalue = 0;
	updatedmediumvalue = 2;
	updatedlongvalue = 4;

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		el1.checked = false;
	});
	[].forEach.call(list, function (el1) {
		na1 = el1.name;
		if (typeof na1 != 'undefined') {
			if (na1.substring(0, 1) == "H")         { h_c++;    if (h_c<=h)          { el1.checked = true; }}
			if (na1.substring(0, 1) == "A")         { a_c++;    if (a_c<=a)          { el1.checked = true; }}
			if (na1.substring(0, 1) == "S")         { s_c++;    if (s_c<=s)          { el1.checked = true; }}
			if (na1.substring(0, 5) == "CD_E_")     { e_c++;    if (e_c<=e)          { el1.checked = true; }}
			if (na1.substring(0, 6) == "CD_FC_")    { fc_c++;   if (fc_c<=fc)        { el1.checked = true; }}
			if (na1.substring(0, 6) == "CD_MP_")    { mp_c++;   if (mp_c<=mp)        { el1.checked = true; }}
			if (na1.substring(0, 5) == "CD_W_")     { w_c++;    if (w_c<=w)          { el1.checked = true; }}
			if (na1.substring(0, 3) == "UOV")       { uov_c++;  if (uov_c<=uov)      { el1.checked = true; }}

			if (na1.substring(0, 8) == "CD_CV-E_")  { e_cv_c++;  if (e_cv_c<=e_cv)   { el1.checked = true; }}
			if (na1.substring(0, 9) == "CD_CV-FC_") { fc_cv_c++; if (fc_cv_c<=fc_cv) { el1.checked = true; }}
			if (na1.substring(0, 8) == "CD_CV-W_")  { w_cv_c++;  if (w_cv_c<=w_cv)   { el1.checked = true; }}
			if (na1.substring(0, 9) == "CD_CV-MA_") { ma_cv_c++; if (ma_cv_c<=ma_cv) { el1.checked = true; }}
			if (na1.substring(0, 9) == "CD_CV-MB_") { mb_cv_c++; if (mb_cv_c<=mb_cv) { el1.checked = true; }}
			if (na1.substring(0, 9) == "CD_CV-MC_") { mc_cv_c++; if (mc_cv_c<=mc_cv) { el1.checked = true; }}

			if (na1.substring(0, 4) == "NARC")      {            if (NARCed==1)      { el1.checked = true; }}
			if (na1.substring(0, 3) == "TAG")       {            if (TAGed==1)       { el1.checked = true; }}
			if (na1.substring(0, 5) == "WATER")     {            if (WATERed==1)     { el1.checked = true; }}
			if (na1.substring(0, 6) == "ROUTED")    {            if (ROUTed==1)      { el1.checked = true; }}
		}
	});

	if (tc_rangeValueReading == 0) {
		document.getElementById("ToHitShort").checked = true;
		document.getElementById("ToHitMedium").checked = false;
		document.getElementById("ToHitLong").checked = false;
	}
	if (tc_rangeValueReading == 2) {
		document.getElementById("ToHitShort").checked = false;
		document.getElementById("ToHitMedium").checked = true;
		document.getElementById("ToHitLong").checked = false;
	}
	if (tc_rangeValueReading == 4) {
		document.getElementById("ToHitShort").checked = false;
		document.getElementById("ToHitMedium").checked = false;
		document.getElementById("ToHitLong").checked = true;
	}
	if (tc_partialCoverReading == 1) {
		document.getElementById("ToHitCover").checked = true;
	}

	var updatedmovementpointsground = movementpointsground;
	var updatedmovementpointsjump = movementpointsjump;

	var updatedshortdamage = shortdamage;
	var updatedmediumdamage = mediumdamage;
	var updatedlongdamage = longdamage;
	var shortdamageZeroStar = false;
	var mediumdamageZeroStar = false;
	var longdamageZeroStar = false;

	var radioMV2_moved2_standstill = document.getElementById("MV2_moved2_standstill");
	var radioMV10_moved10_hulldown = document.getElementById("MV10_moved10_hulldown");
	var radioMV3_moved3_moved = document.getElementById("MV3_moved3_moved");
	var radioMV9_moved9_sprinted = document.getElementById("MV9_moved9_sprinted");
	var radioMV4_moved4_jumped = document.getElementById("MV4_moved4_jumped");
	var radioWF5_WEAPONSFIRED2 = document.getElementById("WF5_WEAPONSFIRED2");
	var radioWF6_WEAPONSFIRED2 = document.getElementById("WF6_WEAPONSFIRED2");
	radioMV2_moved2_standstill.checked = false;
	radioMV10_moved10_hulldown.checked = false;
	radioMV3_moved3_moved.checked = false;
	radioMV9_moved9_sprinted.checked = false;
	radioMV4_moved4_jumped.checked = false;
	radioWF5_WEAPONSFIRED2.checked = false;
	radioWF6_WEAPONSFIRED2.checked = false;

	tc_amm = 0;
	document.getElementById("tmmLabel").innerHTML = "TMM:";
	document.getElementById("AMM").innerHTML = "0";
	document.getElementById("TC_AMM").innerHTML = "0";
	document.getElementById("firepanel").style.display = "block";
	document.getElementById("firepanel").style.visibility = "visible";
	document.getElementById("firepanelhidden").style.display = "none";
	document.getElementById("firepanelhidden").style.visibility = "hidden";

	if (mvmnt == 2) { // Stationary (AMM -1)
		radioMV2_moved2_standstill.checked = true;
		if (unitType != "BA") {
			document.getElementById("AMM").innerHTML = "-1";
			document.getElementById("TC_AMM").innerHTML = "-1";
			tc_amm = -1;
		}
	}
	if (mvmnt == 3) { // walked
		radioMV3_moved3_moved.checked = true;
		document.getElementById("AMM").innerHTML = "0";
		document.getElementById("TC_AMM").innerHTML = "0";
		tc_amm = 0;
	}
	if (mvmnt == 10) { // hulldown
		radioMV10_moved10_hulldown.checked = true;
		document.getElementById("AMM").innerHTML = "0";
		document.getElementById("TC_AMM").innerHTML = "0";
		updatedmovementpointsground = updatedmovementpointsground - 4;
		document.getElementById("tmmLabel").innerHTML = "TMM*:";
		tc_amm = 0;
	}
	if (mvmnt == 9) { // sprinted
		radioMV9_moved9_sprinted.checked = true;
		document.getElementById("AMM").innerHTML = "0";
		document.getElementById("TC_AMM").innerHTML = "0";
		updatedmovementpointsground = updatedmovementpointsground + (updatedmovementpointsground / 2);
		document.getElementById("firepanel").style.display = "none";
		document.getElementById("firepanel").style.visibility = "hidden";
		document.getElementById("firepanelhidden").style.display = "block";
		document.getElementById("firepanelhidden").style.visibility = "visible";
		tc_amm = 0;
	}
	if (mvmnt == 4) { // Jumped (AMM +2)
		radioMV4_moved4_jumped.checked = true;
		if (unitType != "BA") {
			document.getElementById("AMM").innerHTML = "2";
			document.getElementById("TC_AMM").innerHTML = "2";
			tc_amm = 2;
		}
	}
	if (wpnsf == 1) { // hold fire
		radioWF5_WEAPONSFIRED2.checked = true;
	}
	if (wpnsf == 2) { // fired
		radioWF6_WEAPONSFIRED2.checked = true;
	}








	if (unitType == "CV") {
		if (e_cv == 0) {
			//
		} else if (e_cv => 1) {
			enginehit = 1;
			if (updatedshortdamage > 0) { updatedshortdamage = Math.ceil(updatedshortdamage / 2); }
			if (updatedmediumdamage > 0) { updatedmediumdamage = Math.ceil(updatedmediumdamage / 2); }
			if (updatedlongdamage > 0) { Math.ceil(updatedlongdamage = updatedlongdamage / 2); }
			if (updatedmovementpointsground > 0 ) { updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 2); }
			if (updatedmovementpointsjump > 0 ) { updatedmovementpointsjump = Math.ceil(updatedmovementpointsjump / 2); }
		}

		updatedshortvalue = 0;
		updatedmediumvalue = 2;
		updatedlongvalue = 4;

		if (fc_cv == 0) {
			//
		} else if (fc_cv == 1) {
			updatedshortvalue = updatedshortvalue + 2;
			updatedmediumvalue = updatedmediumvalue + 2;
			updatedlongvalue = updatedlongvalue + 2;
		} else if (fc_cv == 2) {
			updatedshortvalue = updatedshortvalue + 4;
			updatedmediumvalue = updatedmediumvalue + 4;
			updatedlongvalue = updatedlongvalue + 4;
		} else if (fc_cv == 3) {
			updatedshortvalue = updatedshortvalue + 6;
			updatedmediumvalue = updatedmediumvalue + 6;
			updatedlongvalue = updatedlongvalue + 6;
		} else if (fc_cv == 4) {
			updatedshortvalue = updatedshortvalue + 8;
			updatedmediumvalue = updatedmediumvalue + 8;
			updatedlongvalue = updatedlongvalue + 8;
		}

		if (w_cv == 0) {
		    //
		} else if (w_cv == 1) {
			updatedshortdamage = updatedshortdamage - 1;
			updatedmediumdamage = updatedmediumdamage - 1;
			updatedlongdamage = updatedlongdamage - 1;
		} else if (w_cv == 2) {
			updatedshortdamage = updatedshortdamage - 2;
			updatedmediumdamage = updatedmediumdamage - 2;
			updatedlongdamage = updatedlongdamage - 2;
		} else if (w_cv == 3) {
			updatedshortdamage = updatedshortdamage - 3;
			updatedmediumdamage = updatedmediumdamage - 3;
			updatedlongdamage = updatedlongdamage - 3;
		} else if (w_cv == 4) {
			updatedshortdamage = updatedshortdamage - 4;
			updatedmediumdamage = updatedmediumdamage - 4;
			updatedlongdamage = updatedlongdamage - 4;
		}
		if (updatedshortdamage == 0) {
			shortdamageZeroStar = true;
		}
		if (updatedmediumdamage == 0) {
			mediumdamageZeroStar = true;
		}
		if (updatedlongdamage == 0) {
			longdamageZeroStar = true;
		}
		if (updatedshortdamage == -1) {
			shortdamageZeroStar = false;
			updatedshortdamage = 0;
		}
		if (updatedmediumdamage == -1) {
			mediumdamageZeroStar = false;
			updatedmediumdamage = 0;
		}
		if (updatedlongdamage == -1) {
			longdamageZeroStar = false;
			updatedlongdamage = 0;
		}
		if (updatedshortdamage < 0) updatedshortdamage = 0;
		if (updatedmediumdamage < 0) updatedmediumdamage = 0;
		if (updatedlongdamage < 0) updatedlongdamage = 0;

		// movement



// 2D6 -->
// 2–8    No effect
// 9–10   −2” Move, −1 TMM*      (* A unit reduced to 0” (or less) Move is immobilized)
// 11     −50% Move, −50% TMM*†  († If a fractional Move rating results, round it down. There is a minimum Move loss of 2” and TMM loss of 1.)
// 12+    Unit immobilized

//ma_cv
//mb_cv
//mc_cv




	} if (unitType == "BM") {
		if (e == 0) {
			//
		} else if (e == 1) {
			enginehit = 1;
		} else if (e == 2) {
			enginehit = 1;
		}
		if (h == 0) {
			updatedshortvalue = 0;
			updatedmediumvalue = 2;
			updatedlongvalue = 4;
		} else if (h == 1) {
			updatedshortvalue = updatedshortvalue + 1;
			updatedmediumvalue = updatedmediumvalue + 1;
			updatedlongvalue = updatedlongvalue + 1;
		} else if (h == 2) {
			updatedshortvalue = updatedshortvalue + 2;
			updatedmediumvalue = updatedmediumvalue + 2;
			updatedlongvalue = updatedlongvalue + 2;
		} else if (h == 3) {
			updatedshortvalue = updatedshortvalue + 3;
			updatedmediumvalue = updatedmediumvalue + 3;
			updatedlongvalue = updatedlongvalue + 3;
		} else if (h == 4) {
			updatedshortvalue = updatedshortvalue + 4;
			updatedmediumvalue = updatedmediumvalue + 4;
			updatedlongvalue = updatedlongvalue + 4;
		}
		if (fc == 0) {
			//
		} else if (fc == 1) {
			updatedshortvalue = updatedshortvalue + 2;
			updatedmediumvalue = updatedmediumvalue + 2;
			updatedlongvalue = updatedlongvalue + 2;
		} else if (fc == 2) {
			updatedshortvalue = updatedshortvalue + 4;
			updatedmediumvalue = updatedmediumvalue + 4;
			updatedlongvalue = updatedlongvalue + 4;
		} else if (fc == 3) {
			updatedshortvalue = updatedshortvalue + 6;
			updatedmediumvalue = updatedmediumvalue + 6;
			updatedlongvalue = updatedlongvalue + 6;
		} else if (fc == 4) {
			updatedshortvalue = updatedshortvalue + 8;
			updatedmediumvalue = updatedmediumvalue + 8;
			updatedlongvalue = updatedlongvalue + 8;
		}

		if (w == 0) {
			//
		} else if (w == 1) {
			updatedshortdamage = updatedshortdamage - 1;
			updatedmediumdamage = updatedmediumdamage - 1;
			updatedlongdamage = updatedlongdamage - 1;
		} else if (w == 2) {
			updatedshortdamage = updatedshortdamage - 2;
			updatedmediumdamage = updatedmediumdamage - 2;
			updatedlongdamage = updatedlongdamage - 2;
		} else if (w == 3) {
			updatedshortdamage = updatedshortdamage - 3;
			updatedmediumdamage = updatedmediumdamage - 3;
			updatedlongdamage = updatedlongdamage - 3;
		} else if (w == 4) {
			updatedshortdamage = updatedshortdamage - 4;
			updatedmediumdamage = updatedmediumdamage - 4;
			updatedlongdamage = updatedlongdamage - 4;
		}

		if (updatedshortdamage == 0) {
			shortdamageZeroStar = true;
		}
		if (updatedmediumdamage == 0) {
			mediumdamageZeroStar = true;
		}
		if (updatedlongdamage == 0) {
			longdamageZeroStar = true;
		}
		if (updatedshortdamage == -1) {
			shortdamageZeroStar = false;
			updatedshortdamage = 0;
		}
		if (updatedmediumdamage == -1) {
			mediumdamageZeroStar = false;
			updatedmediumdamage = 0;
		}
		if (updatedlongdamage == -1) {
			longdamageZeroStar = false;
			updatedlongdamage = 0;
		}

		if (updatedshortdamage < 0) updatedshortdamage = 0;
		if (updatedmediumdamage < 0) updatedmediumdamage = 0;
		if (updatedlongdamage < 0) updatedlongdamage = 0;

		if (updatedshortdamage > 0) { updatedshortdamage = updatedshortdamage + uov; }
		if (updatedmediumdamage > 0) { updatedmediumdamage = updatedmediumdamage + uov; }
		if (document.getElementById('sa_field').innerText.indexOf('OVL') !== -1) {
			if (updatedlongdamage > 0) { updatedlongdamage = updatedlongdamage + uov; }
		} else {
			if (updatedlongdamage > 0) { updatedlongdamage = updatedlongdamage; }
		}

		if (mp == 0) { // Critical movement point hits
			//
		} else if (mp == 1) {
			updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 2);
			updatedmovementpointsjump = Math.ceil(updatedmovementpointsjump / 2);
		} else if (mp == 2) {
			updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 4);
			updatedmovementpointsjump = Math.ceil(updatedmovementpointsjump / 4);
		} else if (mp == 3) {
			updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 8);
			updatedmovementpointsjump = Math.ceil(updatedmovementpointsjump / 8);
		} else if (mp == 4) {
			updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 16);
			updatedmovementpointsjump = Math.ceil(updatedmovementpointsjump / 16);
		}
		if (h == 1) {
			updatedmovementpointsground = updatedmovementpointsground - 2;
		} else if (h == 2) {
			updatedmovementpointsground = updatedmovementpointsground - 4;
		} else if (h == 3) {
			updatedmovementpointsground = updatedmovementpointsground - 6;
		} else if (h == 4) {
			updatedmovementpointsground = 0;
			updatedmovementpointsjump = 0;
		}
		if (updatedmovementpointsground < 0) {
			updatedmovementpointsground = 0;
		}
		if (updatedmovementpointsjump < 0) {
			updatedmovementpointsjump = 0;
		}
	}

	if (shortdamageZeroStar && shortdamage > 0) {
		document.getElementById("dmgshort_s").innerHTML = updatedshortdamage + "*";
	} else {
		document.getElementById("dmgshort_s").innerHTML = updatedshortdamage;
	}
	if (mediumdamageZeroStar && mediumdamage > 0) {
		document.getElementById("dmgmedium_s").innerHTML = updatedmediumdamage + "*";
	} else {
		document.getElementById("dmgmedium_s").innerHTML = updatedmediumdamage;
	}
	if (longdamageZeroStar && longdamage > 0) {
		document.getElementById("dmglong_s").innerHTML = updatedlongdamage + "*";
	} else {
		document.getElementById("dmglong_s").innerHTML = updatedlongdamage;
	}













	if (showDistancesHexes == 1) {
		var updatedmovementpointsgroundHexes =  Math.ceil(updatedmovementpointsground / 2);
		var updatedmovementpointsjumpHexes = Math.ceil(updatedmovementpointsjump / 2);

		var mvstring = updatedmovementpointsgroundHexes + "<span style='font-size:0.6em;'>&#11043;</span>"; // Unicode for Hexagon
		mvstring = mvstring + MV_TYPE;
		if (updatedmovementpointsjumpHexes > 0) {
			mvstring = mvstring + "/" + updatedmovementpointsjumpHexes + "<span style='font-size:0.6em;'>&#11043;</span>j"; // Unicode for Hexagon
		}
		document.getElementById("mv_points").innerHTML = mvstring;
	} else {
		var mvstring = updatedmovementpointsground + "&rdquo;";
		mvstring = mvstring + MV_TYPE;
		if (updatedmovementpointsjump > 0) {
			mvstring = mvstring + "/" + updatedmovementpointsjump + "&rdquo;j";
		}
		document.getElementById("mv_points").innerHTML = mvstring;
	}

	//console.log("TMM ------------>");
	var tmpTMM = originalTMM;
	//console.log("Starting with TMM: " + tmpTMM);
	if (mvmnt == 0) {                            // -------------- 0:   NOT MOVED YET
		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
		if (h == 4) { tmpTMM = -4; }
	} else if (mvmnt == 1 || h == 4) {           // -------------- 1:	TMM -4					Immobile (Shutdown?)
		tmpTMM = -4;
	} else if (mvmnt == 2) {                     // -------------- 2:	TMM 0 AMM -1			Stationary
		if (unitType != "BA") {
			updatedshortvalue = updatedshortvalue - 1;
			updatedmediumvalue = updatedmediumvalue - 1;
			updatedlongvalue = updatedlongvalue - 1;
		}
		tmpTMM = 0;
		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	} else if (mvmnt == 3) {                 	// -------------- 3:	TMM #		            Walked (>1")
		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	} else if (mvmnt == 4) {                     // -------------- 4:	TMM 1 (#+SPCL) AMM +2	Jumped
		if (unitType == "BA") {
			//console.log("BattleArmor --> NO +1 TMM modifier (jump)");
		} else {
			//console.log("NO BattleArmor --> +1 TMM modifier (jump)");
			tmpTMM = tmpTMM + 1;
			updatedshortvalue = updatedshortvalue + 2;
			updatedmediumvalue = updatedmediumvalue + 2;
			updatedlongvalue = updatedlongvalue + 2;
		}

		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }

		// SPCL JMPS JMPW
		// JMPW# -# from TMM
		// JMPS# +# to TMM
		if (document.getElementById('sa_field').innerText.indexOf('JMPS') !== -1 || document.getElementById('sa_field').innerText.indexOf('JMPW') !== -1) {
			const myArray = document.getElementById('sa_field').innerText.split(",");
			for (let index = 0; index < myArray.length; ++index) {
				const element = myArray[index];
				var value = 0;
				if (element.indexOf('JMPS') !== -1) {
					var num = element.replace(/[^0-9]/g,'');
					var value = parseInt(num, 10);
					//console.log("Found JMPS. Value: " + value);
					//console.log("+" + value + " TMM modifier (strong JJs)");
					tmpTMM = tmpTMM + value;
				}
				if (element.indexOf('JMPW') !== -1) {
					var num = element.replace(/[^0-9]/g,'');
					var value = parseInt(num, 10);
					//console.log("Found JMPW. Value: " + value);
					//console.log("-" + value + " TMM modifier (weak JJs)");
					tmpTMM = tmpTMM - value;
				}
			}
		}
	} else if (mvmnt == 9) { 	                // -------------- 9:	TMM #		            Sprinted (>1")
		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	} else if (mvmnt == 10) { 	                // -------------- 9:	TMM #		            Sprinted (>1")
			if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
			tmpTMM = tmpTMM + 1;
		}
	//console.log("H (Heat) = " + h + " / mvmnt = " + mvmnt + " --> TMM: " + tmpTMM);

	document.getElementById("TMM").innerHTML = tmpTMM;
	//console.log("TMM ------------<");

	if (updatedshortvalue < 0) {
		document.getElementById("minrollshort").innerHTML="S (" + updatedshortvalue + ")";
	} else if (updatedshortvalue == 0) {
		document.getElementById("minrollshort").innerHTML="S (+" + updatedshortvalue + ")";
	} else if (updatedshortvalue > 0) {
		document.getElementById("minrollshort").innerHTML="S (+" + updatedshortvalue + ")";
	}

	if (updatedmediumvalue < 0) {
		document.getElementById("minrollmedium").innerHTML="M (" + updatedmediumvalue + ")";
	} else if (updatedmediumvalue == 0) {
		document.getElementById("minrollmedium").innerHTML="M (+" + updatedmediumvalue + ")";
	} else if (updatedmediumvalue > 0) {
		document.getElementById("minrollmedium").innerHTML="M (+" + updatedmediumvalue + ")";
	}
	if (updatedmediumvalue == 2) {
		//
	}

	if (updatedlongvalue < 0) {
		document.getElementById("minrolllong").innerHTML="L (" + updatedlongvalue + ")";
	} else if (updatedlongvalue == 0) {
		document.getElementById("minrolllong").innerHTML="L (+" + updatedlongvalue + ")";
	} else if (updatedlongvalue > 0) {
		document.getElementById("minrolllong").innerHTML="L (+" + updatedlongvalue + ")";
	}
	if (updatedlongvalue == 4) {
		//
	}

	if (a > 1) {
		unitstatus = 2;
	}
	if (s > 1) {
		unitstatus = 3;
	}
	if (s == maximalstructurepoints) {
		unitstatus = 4;
	}
	if (e == 2) {
		unitstatus = 4;
	}
	if (e_cv == 2) {
		unitstatus = 4;
	}
	if (unitstatusstring == 'crippled') {
		unitstatus = 9;
	}

	var temp0 = "./images/temp_0.png";
	var temp1 = "./images/temp_1.png";
	var temp2 = "./images/temp_2.png";
	var temp3 = "./images/temp_3.png";
	var temp4 = "./images/temp_4.png";

	if (unitstatus == 9) {
		// Unit crippled
		$("#crippledIndicator").show();
	}
	if (h == 4) {
		// Unit shutdown
		$("#shutdownIndicator").show();
	}

	showTopStatusInfo(NARCed, TAGed, WATERed, ROUTed);

	if (unitstatus == 4) {
		// Unit destroyed
		$("#topmiddlebackground").hide();
		$("#narcIndicator").hide();
		$("#tagIndicator").hide();
		$("#waterIndicator").hide();
		$("#routedIndicator").hide();
		$("#shutdownIndicator").hide();
		$("#crippledIndicator").hide();
		$("#destroyedIndicator").show();
	}

	if (h == 0) {
		document.getElementById('heatimage_' + chosenunitindex).src=temp0;
	}
	if (h == 1) {
		document.getElementById('heatimage_' + chosenunitindex).src=temp1;
	}
	if (h == 2) {
		document.getElementById('heatimage_' + chosenunitindex).src=temp2;
	}
	if (h == 3) {
		document.getElementById('heatimage_' + chosenunitindex).src=temp3;
	}
	if (h == 4 && unitstatus != 4) {
		document.getElementById('heatimage_' + chosenunitindex).src=temp4;
	}

	var tmmDiceValue = document.getElementById("TMM").innerHTML;
	var movementdiestring = "";
	document.getElementById('firecontainer').className = "datalabel_thin";
	if (mvmnt == "0") { // not moved yet
		movementdiestring = movementdiestring + "empty.png";
		document.getElementById('INFOMOVED').innerHTML = "";
		document.getElementById('firecontainer').className = "datalabel_thin_disabled";
	} else if (mvmnt == "2") { // stationary
		movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
		document.getElementById('INFOMOVED').innerHTML = "STAND";
	} else if (mvmnt == "3") { // walked
		movementdiestring = movementdiestring + "d6_" + tmmDiceValue + ".png";
		document.getElementById('INFOMOVED').innerHTML = "MOVE";
	} else if (mvmnt == "10") { // hulldown
		movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
		document.getElementById('INFOMOVED').innerHTML = "HDWN";
	}  else if (mvmnt == "4") { // jumped
		movementdiestring = movementdiestring + "rd6_" + tmmDiceValue + ".png";
		document.getElementById('INFOMOVED').innerHTML = "JUMP";
	} else if (mvmnt == "9") { // sprinted
		movementdiestring = movementdiestring + "yd6_" + tmmDiceValue + ".png";
		var e1 = document.getElementById("WF5_WEAPONSFIRED");
		var e2 = document.getElementById("WF6_WEAPONSFIRED");
		if (e1 !== undefined && e1 !== null) { e1.checked = true; }
		if (e2 !== undefined && e2 !== null) { e2.checked = false; }
		var e1a = document.getElementById("WF5_WEAPONSFIRED2");
		var e2a = document.getElementById("WF6_WEAPONSFIRED2");
		if (e1a !== undefined && e1a !== null) { e1a.checked = true; }
		if (e2a !== undefined && e2a !== null) { e2a.checked = false; }
		wpnsf = 1; // HOLD FIRE!
		document.getElementById('INFOMOVED').innerHTML = "SPNT";
		document.getElementById('firecontainer').className = "datalabel_thin_disabled";
	}

	var currentButton = 'phasemovebutton' + mvmnt;
	document.getElementById('phasemovebutton2').className='phase_button_normal';
	document.getElementById('phasemovebutton10').className='phase_button_normal';
	document.getElementById('phasemovebutton3').className='phase_button_normal';
	document.getElementById('phasemovebutton9').className='phase_button_normal';
	document.getElementById('phasemovebutton4').className='phase_button_normal';
	var elx = document.getElementById(currentButton)
	if (typeof(elx) != 'undefined' && elx != null) {
		elx.className='phase_button_selected';
	}

	if (wpnsf == 0) {
		document.getElementById('INFOFIRED').innerHTML = "";
	} else if (wpnsf == 1) {
		document.getElementById('INFOFIRED').innerHTML = "HOLD";
	} else if (wpnsf == 2) {
		document.getElementById('INFOFIRED').innerHTML = "FIRE";
	}

	if (movementdiestring != "") {
		document.getElementById('movementtokenimage').src="./images/dice/" + movementdiestring;
	}

	if (mvmnt == 0 && wpnsf == 0) {
		document.getElementById('phasebuttonimage').src="./images/top-right_phase01.png";
		document.getElementById('overviewcurrentunitstatus').src="./images/top-right_phase01.png";
		document.getElementById('unitroundstatusimagemenu').src="./images/top-right_phase01.png";
	} else if (mvmnt > 0 && wpnsf == 0) {
		document.getElementById('phasebuttonimage').src="./images/top-right_phase02.png";
		document.getElementById('overviewcurrentunitstatus').src="./images/top-right_phase02.png";
		document.getElementById('unitroundstatusimagemenu').src="./images/top-right_phase02.png";
	} else if (mvmnt > 0 && wpnsf > 0) {
		document.getElementById('phasebuttonimage').src="./images/top-right_phase03.png";
		document.getElementById('overviewcurrentunitstatus').src="./images/top-right_phase03.png";
		document.getElementById('unitroundstatusimagemenu').src="./images/top-right_phase03.png";
	} else {
		document.getElementById("WF5_WEAPONSFIRED2").checked = false;
		document.getElementById("WF6_WEAPONSFIRED2").checked = false;
		document.getElementById('INFOFIRED').innerHTML = "";
		document.getElementById('phasebuttonimage').src="./images/top-right_phase01.png";
		document.getElementById('overviewcurrentunitstatus').src="./images/top-right_phase01.png";
		document.getElementById('unitroundstatusimagemenu').src="./images/top-right_phase01.png";
	}
	updateOverAllToHitValue(1);
}

function showTopStatusInfo2() {
	var na = document.getElementById("NARC").checked;
	var ta = document.getElementById("TAG").checked;
	var wa = document.getElementById("WATER").checked;
	var ro = document.getElementById("ROUTED").checked;

	showTopStatusInfo(na, ta, wa, ro);
}

function showTopStatusInfo(NARCed, TAGed, WATERed, ROUTed) {
	var hideBG = true;

	$("#topright").fadeIn(300, "linear");
	$("#pv").fadeIn(300, "linear");
	$("#unit_number").fadeIn(300, "linear");

	if (NARCed == 1) {
		hideBG = false;
		if ($("#topmiddlebackground").is(":hidden")) {
			$("#narcIndicator").fadeIn(200, "linear");
			$("#topmiddlebackground").fadeIn(400, "linear");
		} else {
			$("#narcIndicator").show();
		}
	}
	if (TAGed == 1) {
		hideBG = false;
		if ($("#topmiddlebackground").is(":hidden")) {
			$("#tagIndicator").fadeIn(200, "linear");
			$("#topmiddlebackground").fadeIn(400, "linear");
		} else {
			$("#tagIndicator").show();
		}
	}
	if (WATERed == 1) {
		hideBG = false;
		if ($("#topmiddlebackground").is(":hidden")) {
			$("#waterIndicator").fadeIn(200, "linear");
			$("#topmiddlebackground").fadeIn(400, "linear");
		} else {
			$("#waterIndicator").show();
		}
	}
	if (ROUTed == 1) {
		hideBG = false;
		if ($("#topmiddlebackground").is(":hidden")) {
			$("#routedIndicator").fadeIn(200, "linear");
			$("#topmiddlebackground").fadeIn(400, "linear");
		} else {
			$("#routedIndicator").show();
		}
	}

	if (hideBG) {
		$("#topmiddlebackground").fadeOut(500, "linear");
		hideBG = false;
	}
}

function textSize(dec) {
	fontsizeLabel += (dec==1) ? 1 : (-1);

	if (fontsizeLabel < minSize) {
		fontsizeLabel = minSize;
	} else if (fontsizeLabel > maxSize) {
		fontsizeLabel = maxSize;
	}

	fontsizeLabelBig = fontsizeLabel * fontsizeLabelBigFactor;
	fontsizeLabelthin = fontsizeLabel * fontsizeLabelthinFactor;
	fontsizeLabelthinSmall = fontsizeLabel * fontsizeLabelthinSmallFactor;
	fontsizeValue = fontsizeLabel * fontsizeValueFactor;
	fontsizeValueThin = fontsizeLabel * fontsizeValueThinFactor;
	fontsizeCircle = fontsizeLabel * fontsizeCircleFactor;

	setSize("datalabel", fontsizeLabel);
	setSize("datalabel_big", fontsizeLabelBig);
	setSize("datalabel_button", fontsizeLabel);
	setSize("datalabel_disabled_solid", fontsizeLabel);
	setSize("datalabel_disabled_dashed", fontsizeLabel);
	setSize("datalabel_thin", fontsizeLabelthin);
	setSize("datalabel_thin_small", fontsizeLabelthinSmall);
	setSize("datalabel_thin_disabled", fontsizeLabelthin);
	setSize("datavalue", fontsizeValue);
	setSize("datavalue_small", fontsizeValue);
	setSize("datavalue_small_special", fontsizeLabelthin);
	setSize("datavalue_thin", fontsizeValueThin);
	setSize("datavalue_special", fontsizeLabel);
	setSize("bigcheck-target", fontsizeCircle);

	setCookie("fontsizeLabel", fontsizeLabel, 365);
	setCookie("fontsizelabelBig", fontsizeLabelBig, 365);
	setCookie("fontsizeLabelthin", fontsizeLabelthin, 365);
	setCookie("fontsizeLabelthinSmall", fontsizeLabelthin, 365);
	setCookie("fontsizeValue", fontsizeValue, 365);
	setCookie("fontsizeCircle", fontsizeCircle, 365);
	setCookie("savedBefore", "true", 365);
}

function increaseENGN_PREP() {
	ENGN_PREP = ENGN_PREP + 1;
	if (ENGN_PREP > 2) {
		ENGN_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_ENGN_PREP").innerHTML = ENGN_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=ENGN_PREP&value="+ENGN_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseFCTL_PREP() {
	FCTL_PREP = FCTL_PREP + 1;
	if (FCTL_PREP > 4) {
		FCTL_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_FCTL_PREP").innerHTML = FCTL_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=FCTL_PREP&value="+FCTL_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseMP_PREP() {
	MP_PREP = MP_PREP + 1;
	if (MP_PREP > 4) {
		MP_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_MP_PREP").innerHTML = MP_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=MP_PREP&value="+MP_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseWPNS_PREP() {
	WPNS_PREP = WPNS_PREP + 1;
	if (WPNS_PREP > 4) {
		WPNS_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_WPNS_PREP").innerHTML = WPNS_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=WPNS_PREP&value="+WPNS_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseENGN_CV_PREP() {
	CV_ENGN_PREP = CV_ENGN_PREP + 1;
	if (CV_ENGN_PREP > 2) {
		CV_ENGN_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_CV_ENGN_PREP").innerHTML = CV_ENGN_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=CV_ENGN_PREP&value="+CV_ENGN_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseFCTL_CV_PREP() {
	CV_FCTL_PREP = CV_FCTL_PREP + 1;
	if (CV_FCTL_PREP > 4) {
		CV_FCTL_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_CV_FCTL_PREP").innerHTML = CV_FCTL_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=CV_FCTL_PREP&value="+CV_FCTL_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseWPNS_CV_PREP() {
	CV_WPNS_PREP = CV_WPNS_PREP + 1;
	if (CV_WPNS_PREP > 4) {
		CV_WPNS_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_CV_WPNS_PREP").innerHTML = CV_WPNS_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=CV_WPNS_PREP&value="+CV_WPNS_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseMOTIVEA_PREP() {
	CV_MOTVA_PREP = CV_MOTVA_PREP + 1;
	if (CV_MOTVA_PREP > 2) {
		CV_MOTVA_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_CV_MOTIVA_PREP").innerHTML = CV_MOTVA_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=CV_MOTVA_PREP&value="+CV_MOTVA_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseMOTIVEB_PREP() {
	CV_MOTVB_PREP = CV_MOTVB_PREP + 1;
	if (CV_MOTVB_PREP > 2) {
		CV_MOTVB_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_CV_MOTIVB_PREP").innerHTML = CV_MOTVB_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=CV_MOTVB_PREP&value="+CV_MOTVB_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}
function increaseMOTIVEC_PREP() {
	CV_MOTVC_PREP = CV_MOTVC_PREP + 1;
	if (CV_MOTVC_PREP > 1) {
		CV_MOTVC_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_CV_MOTIVC_PREP").innerHTML = CV_MOTVC_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=CV_MOTVC_PREP&value="+CV_MOTVC_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}

function increaseHT_PREP() {
	HT_PREP = HT_PREP + 1;
	if (HT_PREP > 4) {
		HT_PREP = 0;
		playTCClickSound();
	} else {
		playTapSound();
	}
	document.getElementById("label_HT_PREP").innerHTML = HT_PREP;
	var url="./save_prep.php?index="+chosenunitdbid+"&desc=HT_PREP&value="+HT_PREP+"&currentRound="+currentRound+"&gameid="+gameid;
	window.frames['saveframe'].location.replace(url);
}

function rand(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function rolldice() {
	ccc++;
	var die_01 = rand(1, 6);
	var die_02 = rand(1, 6);
	var die_03 = rand(1, 6); // Motive roll for CV
	var die_04 = rand(1, 6); // Motive roll for CV

	var res = die_01 + die_02;
	var res_motive = die_03 + die_04;

	var die_01_image = document.getElementById("die1");
	var die_02_image = document.getElementById("die2");
	var die_03_image = document.getElementById("die3");
	var die_04_image = document.getElementById("die4");

	die_01_image.src = "./images/dice_dots/d6_" + die_01 + ".png";
	die_02_image.src = "./images/dice_dots/d6_" + die_02 + ".png";

	if (die_03_image != null) {
		die_03_image.src = "./images/dice_dots/bd6_" + die_03 + ".png";
		die_04_image.src = "./images/dice_dots/bd6_" + die_04 + ".png";
	}

	rolling--;

	if (ccc == 12) {
		var t = document.getElementById("unit_type").innerHTML.substring(0, 2);

		var resMes = "";
		if (t == "BM") {
				if (res ==  2) { resMes = "Ammo hit"; }
			else if (res ==  3) { resMes = "Engine hit"; }
			else if (res ==  4) { resMes = "Fire control hit"; }
			else if (res ==  5) { resMes = "No critical hit"; }
			else if (res ==  6) { resMes = "Weapon hit"; }
			else if (res ==  7) { resMes = "Movement points hit"; }
			else if (res ==  8) { resMes = "Weapon hit"; }
			else if (res ==  9) { resMes = "No critical hit"; }
			else if (res == 10) { resMes = "Fire control hit"; }
			else if (res == 11) { resMes = "Engine hit"; }
			else if (res == 12) { resMes = "Unit destroyed"; }

			document.getElementById("criticalhit").innerHTML="[BM] CRIT " + res + ":<br>" + resMes;

		} else if (t == "CV") {

			var add_mv_type = 0;
			if (MV_TYPE == "h") {
				add_mv_type = 1;
			} else if (MV_TYPE == "w") {
				add_mv_type = 1;
			} else if (MV_TYPE == "t") {
				add_mv_type = 0;
			}

				if (res ==  2) { resMes = "Ammo hit"; }
			else if (res ==  3) { resMes = "Crew stunned"; }
			else if (res ==  4) { resMes = "Fire control hit"; }
			else if (res ==  5) { resMes = "Fire control hit"; }
			else if (res ==  6) { resMes = "No critical hit"; }
			else if (res ==  7) { resMes = "No critical hit"; }
			else if (res ==  8) { resMes = "No critical hit"; }
			else if (res ==  9) { resMes = "Weapon hit"; }
			else if (res == 10) { resMes = "Weapon hit"; }
			else if (res == 11) { resMes = "Crew killed"; }
			else if (res == 12) { resMes = "Engine hit"; }

			var criticalHitString = "[CV] CRIT " + res + ":<br>" + resMes;
			document.getElementById("criticalhit").innerHTML=criticalHitString;

				if (res_motive + add_mv_type ==  2) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  3) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  4) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  5) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  6) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  7) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  8) { resMes = "No effect"; }
			else if (res_motive + add_mv_type ==  9) { resMes = "-2 MV / -1 TMM"; }
			else if (res_motive + add_mv_type == 10) { resMes = "-2 MV / -1 TMM"; }
			else if (res_motive + add_mv_type == 11) { resMes = "½ MV / ½ TMM"; }
			else if (res_motive + add_mv_type == 12) { resMes = "Immobilized"; }

			var res_motive_final = res_motive + add_mv_type;
			var motiveString = "[CV] MOTV " + res_motive +  " (+" + add_mv_type + MV_TYPE + ") -> " + res_motive_final + ":<br>" + resMes;

			document.getElementById("motivehit").innerHTML=motiveString;
		}
		ccc = 1;
	}
}

function changeWallpaper() {
	var wallpaperName = getCookie("wallpaper");
	if (isNaN(parseFloat(wallpaperName)) || parseFloat(wallpaperName) > 9 || parseFloat(wallpaperName) < 0) {
		wallpaperName = 0;
	}

	var wallpaperNameRand = parseFloat(wallpaperName) + 1;
	if (wallpaperNameRand > 9) {
		wallpaperNameRand = 1;
	}
	document.body.style.backgroundImage = "url('./images/body-bg_" + wallpaperNameRand + ".jpg')";
	setCookie("wallpaper", wallpaperNameRand, 365);

	if (wallpaperNameRand == 9) {
		// Set use MUL images to 1 on database (white background + MUL images)
		var url="./save_UseMULImages.php?playerId="+playerId+"&useMulImages=1";
		window.frames['saveframe'].location.replace(url);
		document.getElementById("unitimage").src=unitImageURLMUL;
		const allDataAreas = document.getElementsByClassName("dataarea");
		for (let i = 0; i < allDataAreas.length; i++) {
			allDataAreas[i].style.backgroundColor="rgba(255,255,255,0.85)"
		}
		const allDataAreaReds = document.getElementsByClassName("dataarea_red");
		for (let i = 0; i < allDataAreaReds.length; i++) {
			allDataAreaReds[i].style.backgroundColor="rgba(10,10,10,0.65)";
		}
		const allDataValues = document.getElementsByClassName("datavalue");
		for (let i = 0; i < allDataValues.length; i++) {
			allDataValues[i].style.color="#000"
		}
		const allDataValueThins = document.getElementsByClassName("datavalue_thin");
		for (let i = 0; i < allDataValueThins.length; i++) {
			allDataValueThins[i].style.color="#000"
		}
		const allDataValueSmallSpecials = document.getElementsByClassName("datavalue_small_special");
		for (let i = 0; i < allDataValueSmallSpecials.length; i++) {
		    allDataValueSmallSpecials[i].style.color="#000"
		}
	} else {
		// Set use MUL images to 0 on database (dark background + alternative images)
		var url="./save_UseMULImages.php?playerId="+playerId+"&useMulImages=0";
		window.frames['saveframe'].location.replace(url);
		document.getElementById("unitimage").src=unitImageURL;
		const allDataAreas = document.getElementsByClassName("dataarea");
		for (let i = 0; i < allDataAreas.length; i++) {
			allDataAreas[i].style.backgroundColor="rgba(70,70,70,0.85)"
		}
		const allDataAreaReds = document.getElementsByClassName("dataarea_red");
		for (let i = 0; i < allDataAreaReds.length; i++) {
			allDataAreaReds[i].style.backgroundColor="rgba(70,0,0,0.65)";
		}
		const allDataValues = document.getElementsByClassName("datavalue");
		for (let i = 0; i < allDataValues.length; i++) {
			allDataValues[i].style.color="#ccc"
		}
		const allDataValueThins = document.getElementsByClassName("datavalue_thin");
		for (let i = 0; i < allDataValueThins.length; i++) {
			allDataValueThins[i].style.color="#ccc"
		}
		const allDataValueSmallSpecials = document.getElementsByClassName("datavalue_small_special");
		for (let i = 0; i < allDataValueSmallSpecials.length; i++) {
		    allDataValueSmallSpecials[i].style.color="#ccc"
		}
	}
}

function showUnit() {
	if (!showingUnit) {
		$("#movementtoken").fadeOut(500, "linear");
		$(".dataarea").each(function() {
			$(this).fadeOut(500, "linear");
		});
		$(".dataarea_red").each(function() {
			$(this).fadeOut(500, "linear");
		});
		showingUnit = true;
	} else {
		showingUnit = false;
		location.reload();
	}
}

function playDiceSound() {
	if (sound_dice == null) {
		sound_dice = new Howl({ src: ['./audio/dice.mp3', './audio/dice.ogg'] });
	}
	sound_dice.play();
}

function playTapSound() {
	if (sound_key == null) {
		sound_key = new Howl({ src: ['./audio/key.mp3', './audio/key.ogg'] });
	}
	sound_key.play();
}

function playErrorSound() {
	if (sound_error == null) {
		sound_error = new Howl({ src: ['./audio/error.mp3', './audio/error.ogg'] });
	}
	sound_error.play();
}

function playTCOpenSound() {
	if (sound_openTC == null) {
		sound_openTC = new Howl({ src: ['./audio/openTC.mp3', './audio/openTC.ogg'] });
	}
	sound_openTC.play();
}

function playTCCloseSound() {
	if (sound_closeTC == null) {
		sound_closeTC = new Howl({ src: ['./audio/closeTC.mp3', './audio/closeTC.ogg'] });
	}
	sound_closeTC.play();
}

function playTCClickSound() {
	if (sound_keyTC == null) {
		sound_keyTC = new Howl({ src: ['./audio/keyTC.mp3', './audio/keyTC.ogg'] });
	}
	sound_keyTC.play();
}

function playSound_01() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/ACallToTrial.mp3', './audio/samples/ACallToTrial.ogg'] });
	sound_SB.play();
}

function playSound_02() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/AlrightWheresTheCavalry.mp3', './audio/samples/AlrightWheresTheCavalry.ogg'] });
	sound_SB.play();
}

function playSound_03() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/DriveLikeAFreebirth.mp3', './audio/samples/DriveLikeAFreebirth.ogg'] });
	sound_SB.play();
}

function playSound_04() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/KnowThisMercenaries.mp3', './audio/samples/KnowThisMercenaries.ogg'] });
	sound_SB.play();
}

function playSound_05() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/RegisterSibcoIdentity.mp3', './audio/samples/RegisterSibcoIdentity.ogg'] });
	sound_SB.play();
}

function playSound_06() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/SurlyYesSir.mp3', './audio/samples/SurlyYesSir.ogg'] });
	sound_SB.play();
}

function playSound_07() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/ThisOnesAllMine.mp3', './audio/samples/ThisOnesAllMine.ogg'] });
	sound_SB.play();
}

function playSound_08() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/samples/YesSir.mp3', './audio/samples/YesSir.ogg'] });
	sound_SB.play();
}

function playSound_09() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
	sound_SB = new Howl({ src: ['./audio/WeAreClanWolf.mp3', './audio/WeAreClanWolf.ogg'] });
	sound_SB.play();
}

function stopSoundSB() {
	if (sound_SB != null) {
		sound_SB.stop();
		sound_SB.unload();
		sound_SB = null;
	}
}

function hideInfoBar() {
	$("#infobar").hide();
}

function showInfoBar() {
	if($('#infobar').is(':visible')) {
		// the movebar is already open. do nothing
	} else {
		$("#movebar").hide();
		$("#dicebar").hide();
		$("#infobar").show();
		$("#soundboard").hide();

		showTopPanels();
	}
}

function hideSoundBoard() {
	$("#soundboard").hide();
}

function showSoundBoard() {
	if($('#soundboard').is(':visible')) {
		// the movebar is already open. do nothing
	} else {
		$("#movebar").hide();
		$("#dicebar").hide();
		$("#infobar").hide();
		$("#soundboard").show();

		showTopPanels();
	}
}

function hideDiceBar() {
	$("#dicebar").hide();
}

function showDiceBar() {
	if($('#dicebar').is(':visible')) {
		// the dicebar is already open. do nothing
	} else {
		$("#infobar").hide();
		$("#movebar").hide();
		$("#dicebar").show();
		$("#soundboard").hide();

		showTopPanels();

		if (rolling === 0) {
			playDiceSound();
			for (i = 1; i < 12; i++) {
				rolling++;
				setTimeout("rolldice(i)", i * 80);
			}
		}
	}
}

function toggleTargetingComputer() {
	if($('#TargetingComputer').is(':visible')) {
		$("#TargetingComputer").hide();
		document.getElementById("TargetingComputer").style.display = "none";
		document.getElementById("targetcomp").innerHTML = "&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-bullseye' style='color:#999;font-size:40px;'></i>&nbsp;&nbsp;&nbsp;";
		setCookie("tcmp", 0, 365);
		playTCCloseSound();
	} else {
		$("#TargetingComputer").show();
		document.getElementById("TargetingComputer").style.display = "block";
		document.getElementById("targetcomp").innerHTML = "&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-circle-left' style='color:#999;font-size:40px;'></i>&nbsp;&nbsp;&nbsp;";
		setCookie("tcmp", 1, 365);
		playTCOpenSound();
	}
}

function setRangeToShort() {
	document.getElementById("ToHitShort").checked = true;
	document.getElementById("ToHitMedium").checked = false;
	document.getElementById("ToHitLong").checked = false;
	tc_rangeValue = 0;
	//console.log("Set range to S");
	updateOverAllToHitValue();
}

function setRangeToMedium() {
	document.getElementById("ToHitShort").checked = false;
	document.getElementById("ToHitMedium").checked = true;
	document.getElementById("ToHitLong").checked = false;
	tc_rangeValue = 2;
	//console.log("Set range to M");
	updateOverAllToHitValue();
}

function setRangeToLong() {
	document.getElementById("ToHitShort").checked = false;
	document.getElementById("ToHitMedium").checked = false;
	document.getElementById("ToHitLong").checked = true;
	tc_rangeValue = 4;
	//console.log("Set range to L");
	updateOverAllToHitValue();
}

function increaseEnemyTMM() {
	tc_enemyTMM = tc_enemyTMM + 1;
	if (tc_enemyTMM > 6) {
		tc_enemyTMM = 6;
	}
	document.getElementById("EnemyTMM").innerText = tc_enemyTMM;
	updateOverAllToHitValue();
}

function reduceEnemyTMM() {
	tc_enemyTMM = tc_enemyTMM - 1;
	if (tc_enemyTMM < -4) {
		tc_enemyTMM = -4;
	}
	document.getElementById("EnemyTMM").innerText = tc_enemyTMM;
	updateOverAllToHitValue();
}

function increaseForrest() {
	tc_wood = tc_wood + 1;
	if (tc_wood > 6) {
		tc_wood = 6;
	}
	document.getElementById("Forrest").innerText = tc_wood;
	updateOverAllToHitValue();
}

function reduceForrest() {
	tc_wood = tc_wood - 1;
	if (tc_wood < 0) {
		tc_wood = 0;
	}
	document.getElementById("Forrest").innerText = tc_wood;
	updateOverAllToHitValue();
}

function increaseOther() {
	tc_other = tc_other + 1;
	if (tc_other > 6) {
		tc_other = 6;
	}
	document.getElementById("Other").innerText = tc_other;
	updateOverAllToHitValue();
}

function reduceOther() {
	tc_other = tc_other - 1;
	if (tc_other < -4) {
		tc_other = -4;
	}
	document.getElementById("Other").innerText = tc_other;
	updateOverAllToHitValue();
}

function setCover() {
	if (document.getElementById("ToHitCover").checked == true) {
		tc_partialCover = 1;
	} else {
		tc_partialCover = 0;
	}
	updateOverAllToHitValue();
}

function setForrest() {
	if (document.getElementById("ToHitForrest").checked == true) {
		tc_wood = 1;
	} else {
		tc_wood = 0;
	}
	updateOverAllToHitValue();
}

function updateOverAllToHitValue(skipTap) {
	var result = 0;
	tc_skill = parseInt(document.getElementById("skillfield").innerText);

	//console.log("tc_enemyTMM          : " + tc_enemyTMM);
	//console.log("tc_amm               : " + tc_amm);
	//console.log("tc_skill             : " + tc_skill);
	//console.log("tc_rangeValue        : " + tc_rangeValue);
	//console.log("tc_partialCover      : " + tc_partialCover);
	//console.log("tc_wood              : " + tc_wood);
	//console.log("tc_heat              : " + tc_heat);
	//console.log("tc_other             : " + tc_other);
	//console.log("tc_firecontrolDamage : " + tc_firecontrolDamage);

	result += tc_enemyTMM;
	result += tc_amm;
	result += tc_skill;
	result += tc_rangeValue;
	result += tc_partialCover;
	result += tc_wood;
	result += tc_heat;
	result += tc_other;
	result += tc_firecontrolDamage;

	if (result > 12) {
		document.getElementById("ToHitResult").innerText = "∞";
	} else {
		document.getElementById("ToHitResult").innerText = result;
	}

	if (skipTap != 1) {
		playTCClickSound();
	}
}

function hideMoveBar() {
	$("#movebar").hide();
}

function showMoveBar() {
	if($('#movebar').is(':visible')) {
		// the movebar is already open. do nothing
	} else {
		$("#dicebar").hide();
		$("#infobar").hide();
		$("#movebar").show();
	}
}

function hideSkull() {
	$("#destroyedIndicator").fadeOut(300, "linear");
}
function hideCrippled() {
	$("#crippledIndicator").fadeOut(300, "linear");
}
function hideShutdownIndicator() {
	$("#shutdownIndicator").fadeOut(300, "linear");
}
function hideTopPanels() {
	$("#narcIndicator").fadeOut(300, "linear");
	$("#tagIndicator").fadeOut(300, "linear");
	$("#waterIndicator").fadeOut(300, "linear");
	$("#routedIndicator").fadeOut(300, "linear");
	$("#topright").fadeOut(300, "linear");
	$("#pv").fadeOut(300, "linear");
	$("#unit_number").fadeOut(300, "linear");
	$("#topmiddlebackground").fadeOut(300, "linear");
}
function hideNarcIndicator() {
	$("#destroyedIndicator").fadeOut(300, "linear");
	$("#crippledIndicator").fadeOut(300, "linear");
	$("#shutdownIndicator").fadeOut(300, "linear");
	$("#narcIndicator").fadeOut(300, "linear");
	$("#tagIndicator").fadeOut(300, "linear");
	$("#waterIndicator").fadeOut(300, "linear");
	$("#routedIndicator").fadeOut(300, "linear");
}
function hideTagIndicator() {
	$("#destroyedIndicator").fadeOut(300, "linear");
	$("#crippledIndicator").fadeOut(300, "linear");
	$("#shutdownIndicator").fadeOut(300, "linear");
	$("#narcIndicator").fadeOut(300, "linear");
	$("#tagIndicator").fadeOut(300, "linear");
	$("#waterIndicator").fadeOut(300, "linear");
	$("#routedIndicator").fadeOut(300, "linear");
}
function hideWaterIndicator() {
	$("#destroyedIndicator").fadeOut(300, "linear");
	$("#crippledIndicator").fadeOut(300, "linear");
	$("#shutdownIndicator").fadeOut(300, "linear");
	$("#narcIndicator").fadeOut(300, "linear");
	$("#tagIndicator").fadeOut(300, "linear");
	$("#waterIndicator").fadeOut(300, "linear");
	$("#routedIndicator").fadeOut(300, "linear");
}
function hideRoutedIndicator() {
	$("#destroyedIndicator").fadeOut(300, "linear");
	$("#crippledIndicator").fadeOut(300, "linear");
	$("#shutdownIndicator").fadeOut(300, "linear");
	$("#narcIndicator").fadeOut(300, "linear");
	$("#tagIndicator").fadeOut(300, "linear");
	$("#waterIndicator").fadeOut(300, "linear");
	$("#routedIndicator").fadeOut(300, "linear");
}
function hideTopRightPanel() {
	$("#topright").fadeOut(300, "linear");
	$("#pv").fadeOut(300, "linear");
	$("#unit_number").fadeOut(300, "linear");
}
function showTopPanels() {
	$("#topright").fadeIn(300, "linear");
	$("#pv").fadeIn(300, "linear");
	$("#unit_number").fadeIn(300, "linear");

	var na = document.getElementById("NARC").checked;
	var ta = document.getElementById("TAG").checked;
	var wa = document.getElementById("WATER").checked;
	var ro = document.getElementById("ROUTED").checked;
	showTopStatusInfo(na, ta, wa, ro);
}
function changeNARCDesc() {
	var text = document.getElementById("narcDesc").innerHTML;
	var narcdesc = text;
	if (text == "NARC") {
		document.getElementById("narcDesc").innerHTML = "TAG";
		narcdesc = "TAG";
	} else if (text == "TAG") {
		document.getElementById("narcDesc").innerHTML = "BOTH";
		narcdesc = "BOTH";
	} else if (text == "BOTH") {
		document.getElementById("narcDesc").innerHTML = "NARC";
		narcdesc = "NARC";
	}

	var url="./save_narcDesc.php?narcdesc="+narcdesc+"&playerid="+playerId+"&gameid="+gameid+"&unitid="+chosenunitdbid+"&round="+currentRound;
	window.frames['saveframe'].location.replace(url);

	playTCClickSound();
}

$(window).resize(function() {
	var unitimage = document.getElementById("unitimage");
	unitimage.style.height="" + $(document).height() * 0.8 + "px";
});

$(document).ready(function() {
	//	$("#cover").click(function(event) {
	//		$("#cover").fadeOut(350, "linear", function() {
	//			$("#cover").hide();
	//			document.getElementById("cover").style.visibility = "hidden";
	//		});
	//	});

	if (getCookie("tcmp") === "0") {
		$("#TargetingComputer").hide();
		document.getElementById("TargetingComputer").style.display = "none";
		document.getElementById("targetcomp").innerHTML = "&nbsp;&nbsp;&nbsp;<i class='fa-solid fa-bullseye' style='color:#999;font-size:40px;'></i>&nbsp;&nbsp;&nbsp;";
	}
	document.getElementById("ToHitShort").checked = false;
	document.getElementById("ToHitMedium").checked = true;
	document.getElementById("ToHitLong").checked = false;

	var unitimage = document.getElementById("unitimage");
	unitimage.style.height="" + ($(document).height() * 0.8 + "px");

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		el1.addEventListener('click', function() {
			if (context != null ) {
				context.resume().then(() => {
				});
			} else {
				context = new AudioContext();
			}
		});
	});

	var infoButton = document.getElementById("InfoButton");
	infoButton.addEventListener('click', function() {
		if (context != null ) {
			context.resume().then(() => {
			});
		} else {
			context = new AudioContext();
		}
	});

	var diceButton = document.getElementById("DiceButton");
	diceButton.addEventListener('click', function() {
		if (context != null ) {
			context.resume().then(() => {
			});
		} else {
			context = new AudioContext();
		}
	});

	var moveButton = document.getElementById("MoveButton");
	moveButton.addEventListener('click', function() {
		if (context != null ) {
			context.resume().then(() => {
				//console.log('Playback resumed successfully');
			});
		} else {
			context = new AudioContext();
		}
	});

	$("#dice").click(function(event) {
		if (rolling === 0) {
			playDiceSound();
			for (i = 1; i < 12; i++) {
				rolling++;
				setTimeout("rolldice(i)", i * 80);
			}
		}
	});

	$("#motivedice").click(function(event) {
		if (rolling === 0) {
			playDiceSound();
			for (i = 1; i < 12; i++) {
				rolling++;
				setTimeout("rolldice(i)", i * 80);
			}
		}
	});

	if (getCookie("savedBefore") === "true") {
		fontsizeLabel = parseInt(getCookie("fontsizeLabel"));
		if (fontsizeLabel < minSize) {
			fontsizeLabel = minSize;
		}
		if (fontsizeLabel > maxSize) {
			fontsizeLabel = maxSize;
		}
		fontsizeLabelBig = fontsizeLabel * fontsizeLabelBigFactor;
		fontsizeLabelthin = fontsizeLabel * fontsizeLabelthinFactor;
		fontsizeLabelthinSmall = fontsizeLabel * fontsizeLabelthinSmallFactor;
		fontsizeValue = fontsizeLabel * fontsizeValueFactor;
		fontsizeValueThin = fontsizeLabel * fontsizeValueThinFactor;
		fontsizeCircle = fontsizeLabel * fontsizeCircleFactor;

		setSize("datalabel", fontsizeLabel);
		setSize("datalabel_big", fontsizeLabelBig);
		setSize("datalabel_button", fontsizeLabel);
		setSize("datalabel_disabled_solid", fontsizeLabel);
		setSize("datalabel_disabled_dashed", fontsizeLabel);
		setSize("datalabel_thin", fontsizeLabelthin);
		setSize("datalabel_thin_small", fontsizeLabelthinSmall);
		setSize("datalabel_thin_disabled", fontsizeLabelthin);
		setSize("datavalue", fontsizeValue);
		setSize("datavalue_small", fontsizeValue);
		setSize("datavalue_small_special", fontsizeLabelthin);
		setSize("datavalue_thin", fontsizeValueThin);
		setSize("datavalue_special", fontsizeLabel);
		setSize("bigcheck-target", fontsizeCircle);
	}

	var wallpaperName = getCookie("wallpaper");
	if ((wallpaperName !== null) && (typeof wallpaperName != 'undefined')) {
		// A wallpaperName was found in the cookie
	} else {
		// A wallpaperName was NOT found, go with the default
		wallpaperName = 1;
	}

	if (wallpaperName > 0 && wallpaperName < 10) {
		document.body.style.backgroundImage = "url('./images/body-bg_" + wallpaperName + ".jpg')";
	}
	if (wallpaperName == 9) {
		// Set use MUL images to 1 on database (white background + MUL images)
		var url="./save_UseMULImages.php?playerId="+playerId+"&useMulImages=1";
		window.frames['saveframe'].location.replace(url);
		document.getElementById("unitimage").src=unitImageURLMUL;
		const allDataAreas = document.getElementsByClassName("dataarea");
		for (let i = 0; i < allDataAreas.length; i++) {
			allDataAreas[i].style.backgroundColor="rgba(255,255,255,0.90)";
		}
		const allDataValues = document.getElementsByClassName("datavalue");
		for (let i = 0; i < allDataValues.length; i++) {
			allDataValues[i].style.color="#000"
		}
		const allDataValueThins = document.getElementsByClassName("datavalue_thin");
		for (let i = 0; i < allDataValueThins.length; i++) {
			allDataValueThins[i].style.color="#000"
		}
		const allDataAreaReds = document.getElementsByClassName("dataarea_red");
		for (let i = 0; i < allDataAreaReds.length; i++) {
			allDataAreaReds[i].style.backgroundColor="rgba(10,10,10,0.65)";
		}
		const allDataValueSmallSpecials = document.getElementsByClassName("datavalue_small_special");
		for (let i = 0; i < allDataValueSmallSpecials.length; i++) {
		    allDataValueSmallSpecials[i].style.color="#000"
		}
	} else {
		// Set use MUL images to 0 on database (dark background + alternative images)
		var url="./save_UseMULImages.php?playerId="+playerId+"&useMulImages=0";
		window.frames['saveframe'].location.replace(url);
		document.getElementById("unitimage").src=unitImageURL;
		const allDataAreas = document.getElementsByClassName("dataarea");
		for (let i = 0; i < allDataAreas.length; i++) {
			allDataAreas[i].style.backgroundColor="rgba(70,70,70,0.85)";
		}
		const allDataValues = document.getElementsByClassName("datavalue");
		for (let i = 0; i < allDataValues.length; i++) {
			allDataValues[i].style.color="#ccc"
		}
		const allDataValueThins = document.getElementsByClassName("datavalue_thin");
		for (let i = 0; i < allDataValueThins.length; i++) {
			allDataValueThins[i].style.color="#ccc"
		}
		const allDataAreaReds = document.getElementsByClassName("dataarea_red");
		for (let i = 0; i < allDataAreaReds.length; i++) {
			allDataAreaReds[i].style.backgroundColor="rgba(70,0,0,0.60)";
		}
		const allDataValueSmallSpecials = document.getElementsByClassName("datavalue_small_special");
		for (let i = 0; i < allDataValueSmallSpecials.length; i++) {
		    allDataValueSmallSpecials[i].style.color="#ccc"
		}
	}
});
