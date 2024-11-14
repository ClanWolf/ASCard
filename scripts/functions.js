var fontsizeLabel = 18;

var minSize = 10;
var maxSize = 60;

var fontsizeLabelthinFactor = 0.6;
var fontsizeLabelthinSmallFactor = 0.6;
var fontsizeValueFactor = 1.3;
var fontsizeValueThinFactor = 0.8;
var fontsizeCircleFactor = 1.1;

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

var mechstatus = 1; // 1: green (untouched) | 2: yellow (hit) | 3: red (crit) | 4: black (wrecked) | 9: crippled
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

var showingMech = false;

var skipTapSample = false;

function setSize(name, value) {
	var list = document.getElementsByClassName(name);
	[].forEach.call(list, function (el) {
		el.style.fontSize="" + value + "px";
	});
}

function readCircles(index3, a_max3, s_max3) {
	//console.log("a_max3=" + a_max3);
	//console.log("s_max3=" + s_max3);
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
	var uov = 0; // used overheat

	var mvmnt = 0;
	var wpnsf = 0;

	var mechstatus = 1;
	var mechstatusstring = "fresh";
	var mechstatusimage = "images/DD_BM_01.png";

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		na = el1.name;
		if (typeof na != 'undefined') {
			if (na.substring(0, 1) == "H"      && el1.checked) { h++;   }
			if (na.substring(0, 1) == "A"      && el1.checked) { a++;   }
			if (na.substring(0, 1) == "S"      && el1.checked) { s++;   }
			if (na.substring(0, 5) == "CD_E_"  && el1.checked) { e++;   }
			if (na.substring(0, 6) == "CD_FC_" && el1.checked) { fc++;  }
			if (na.substring(0, 6) == "CD_MP_" && el1.checked) { mp++;  }
			if (na.substring(0, 5) == "CD_W_"  && el1.checked) { w++;   }
			if (na.substring(0, 3) == "UOV"    && el1.checked) { uov++; }
		}
	});

	var radioMV2_moved2_standstill = document.getElementById("MV2_moved2_standstill");
	var radioMV10_moved10_hulldown = document.getElementById("MV10_moved10_hulldown");
	var radioMV3_moved3_moved = document.getElementById("MV3_moved3_moved");
	var radioMV9_moved9_sprinted = document.getElementById("MV9_moved9_sprinted");
	var radioMV4_moved4_jumped = document.getElementById("MV4_moved4_jumped");
	var radioWF5_WEAPONSFIRED2 = document.getElementById("WF5_WEAPONSFIRED2");
	var radioWF6_WEAPONSFIRED2 = document.getElementById("WF6_WEAPONSFIRED2");

//	console.log("--- Movement changes:");
	if (radioMV2_moved2_standstill.checked && mv_bt_id == 2) { // standstill
		mvmnt = 2;
//		console.log("Movement 2: standstill");
	}
	if (radioMV10_moved10_hulldown.checked && mv_bt_id == 10) { // hulldown
		mvmnt = 10;
//		console.log("Movement 10: hulldown");
	}
	if (radioMV3_moved3_moved.checked && mv_bt_id == 3) { // walked
		mvmnt = 3;
//		console.log("Movement 3: walked");
	}
	if (radioMV9_moved9_sprinted.checked && mv_bt_id == 9) { // sprinted
		mvmnt = 9;
//		console.log("Movement 9: sprinted");
	}
	if (radioMV4_moved4_jumped.checked && mv_bt_id == 4) { // jumped
		mvmnt = 4;
//		console.log("Movement 4: jumped");
	}
	if (mv_bt_id == -1) {
		if (radioMV2_moved2_standstill.checked) { mvmnt = 2;  }
		if (radioMV10_moved10_hulldown.checked) { mvmnt = 10; }
		if (radioMV3_moved3_moved.checked)      { mvmnt = 3;  }
		if (radioMV9_moved9_sprinted.checked)   { mvmnt = 9;  }
		if (radioMV4_moved4_jumped.checked)     { mvmnt = 4;  }
	}

//	console.log("--- Fire changes:");
	if (radioWF5_WEAPONSFIRED2.checked && f_bt_id == 1) { // hold fire
		wpnsf = 1;
//		console.log("Fire 1: hold fire");
	}
	if (radioWF6_WEAPONSFIRED2.checked && f_bt_id == 2) { // weapons fired
		wpnsf = 2;
//		console.log("Fire 2: fired");
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
	// mechstatusstring: fresh, damaged, critical, crippled, destroyed

//	CRIPPLING DAMAGE
//  For the purposes of Forced Withdrawal, a unit that meets any of the following criteria is considered crippled
//  and will be forced to withdraw:
//      - The unit has no Armor remaining and has been reduced to half
//        its starting Structure value (rounded up). If the unit possesses
//        only 1 point of Structure to begin with, it begins retreating as
//        soon as it loses all of its Armor.
//      - The unit has been reduced to a damage value of 0 for all
//        Medium- and Long-range attacks. This condition does not
//        apply if the unit began the scenario with a damage value of 0
//        at Medium and Long range.
//      - The unit has been immobilized through damage, critical, and/
//        or motive hit effects.

//	if (document.getElementById('unit_type').innerText == "BA") {
//		mechstatus = 1;
//		mechstatusstring = "fresh";
//		mechstatusimage = "images/DD_BA_01.png";
//		if (a > 0) {
//			mechstatus = 2;
//			mechstatusstring = "damaged";
//			mechstatusimage = "images/DD_BA_02.png";
//		}
//		if (s > 0) {
//			mechstatus = 3;
//			mechstatusstring = "critical";
//			mechstatusimage = "images/DD_BA_03.png";
//		}
//		if (a == maximalarmorpoints && maximalstructurepoints == 1) {
//			mechstatus = 9;
//			mechstatusstring = "crippled";
//			mechstatusimage = "images/DD_BM_03.png";
//		}
//    	if (s > maximalstructurepoints / 2) {
//    		mechstatus = 9;
//			mechstatusstring = "crippled";
//    		mechstatusimage = "images/DD_BM_03.png";
//    	}
//		if (s == maximalstructurepoints) {
//			mechstatus = 4;
//			mechstatusstring = "destroyed";
//			mechstatusimage = "images/DD_BA_04.png";
//		}
//		if (e == 2) {
//			mechstatus = 4;
//			mechstatusstring = "destroyed";
//			mechstatusimage = "images/DD_BA_04.png";
//		}
//	} else {
//		mechstatus = 1;
//		mechstatusstring = "fresh";
//		mechstatusimage = "images/DD_BM_01.png";
//		if (a > 0) {
//    		mechstatus = 2;
//			mechstatusstring = "ok";
//    		mechstatusimage = "images/DD_BM_02.png";
//    	}
//    	if (s > 0) {
//    		mechstatus = 3;
//			mechstatusstring = "critical";
//    		mechstatusimage = "images/DD_BM_03.png";
//    	}
//		if (a == maximalarmorpoints && maximalstructurepoints == 1) {
//			mechstatus = 9;
//			mechstatusstring = "crippled";
//			mechstatusimage = "images/DD_BM_03.png";
//		}
//    	if (s > maximalstructurepoints / 2) {
//    		mechstatus = 9;
//			mechstatusstring = "crippled";
//    		mechstatusimage = "images/DD_BM_03.png";
//    	}
//    	if (s == maximalstructurepoints) {
//    		mechstatus = 4;
//			mechstatusstring = "destroyed";
//    		mechstatusimage = "images/DD_BM_04.png";
//    		document.getElementById('toprightimage').src='./images/top-right_02.png';
//    	}
//    	if (e == 2) {
//    		mechstatus = 4;
//			mechstatusstring = "destroyed";
//    		mechstatusimage = "images/DD_BM_04.png";
//    		document.getElementById('toprightimage').src='./images/top-right_02.png';
//    	}
//	}

	var currentUnitType = document.getElementById('unit_type').innerText;
	currentUnitType = currentUnitType.substring(0, currentUnitType.indexOf(' ')); // Cut off size and tonnage
	mechstatus = 1;
	mechstatusstring = "fresh";
	mechstatusimage = "images/DD_" + currentUnitType + "_01.png";
	if (a > 0) {
		mechstatus = 2;
		mechstatusstring = "damaged";
		mechstatusimage = "images/DD_" + currentUnitType + "_02.png";
	}
	if (s > 0) {
		mechstatus = 3;
		mechstatusstring = "critical";
		mechstatusimage = "images/DD_" + currentUnitType + "_03.png";
	}
	if (a == maximalarmorpoints && maximalstructurepoints == 1) {
		mechstatus = 9;
		mechstatusstring = "crippled";
		mechstatusimage = "images/DD_" + currentUnitType + "_03.png";
	}
    if (s > maximalstructurepoints / 2) {
        mechstatus = 9;
		mechstatusstring = "crippled";
        mechstatusimage = "images/DD_" + currentUnitType + "_03.png";
    }
	if (s == maximalstructurepoints) {
		mechstatus = 4;
		mechstatusstring = "destroyed";
		mechstatusimage = "images/DD_" + currentUnitType + "_04.png";
	}
	if (e == 2) {
		mechstatus = 4;
		mechstatusstring = "destroyed";
		mechstatusimage = "images/DD_" + currentUnitType + "_04.png";
	}

	document.getElementById('mechstatusimagemenu').src=mechstatusimage;

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
	//console.log("range: " + tc_rangeValueReading);

	setCircles(h, a, s, e, fc, mp, w, uov, mvmnt, wpnsf, tc_rangeValueReading, tc_partialCoverReading, mechstatusstring);
	var url="./save.php?index="+index+"&h="+h+"&a="+a+"&s="+s+"&e="+e+"&fc="+fc+"&mp="+mp+"&w="+w+"&mstat="+mechstatusimage+"&mstatstr="+mechstatusstring+"&uov="+uov+"&mvmnt="+mvmnt+"&wpnsf="+wpnsf;
	// alert(url);
	window.frames['saveframe'].location.replace(url);

	//console.log("Structural damage: " + s);
	//console.log("Structural damage cache: " + structuralDamageCache);
	if (s > structuralDamageCache) {
		showDiceBar();
	}
	structuralDamageCache = s;
	//console.log("New structural damage cache: " + structuralDamageCache);
}

function setStructuralDamageCache(value) {
	structuralDamageCache = value;
}

function setCircles(h, a, s, e, fc, mp, w, uov, mvmnt, wpnsf, tc_rangeValueReading, tc_partialCoverReading, mechstatusstring) {
	var na1 = "";

	tc_heat = h;
	tc_firecontrolDamage = fc * 2;

	var h_c = 0;
	var a_c = 0;
	var s_c = 0;
	var e_c = 0;
	var fc_c = 0;
	var mp_c = 0;
	var w_c = 0;
	var uov_c = 0;

	//console.log("uov: " + uov);

	mechstatus = 1;
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
			if (na1.substring(0, 1) == "H")      { h_c++;   if (h_c<=h)     { el1.checked = true; }}
			if (na1.substring(0, 1) == "A")      { a_c++;   if (a_c<=a)     { el1.checked = true; }}
			if (na1.substring(0, 1) == "S")      { s_c++;   if (s_c<=s)     { el1.checked = true; }}
			if (na1.substring(0, 5) == "CD_E_")  { e_c++;   if (e_c<=e)     { el1.checked = true; }}
			if (na1.substring(0, 6) == "CD_FC_") { fc_c++;  if (fc_c<=fc)   { el1.checked = true; }}
			if (na1.substring(0, 6) == "CD_MP_") { mp_c++;  if (mp_c<=mp)   { el1.checked = true; }}
			if (na1.substring(0, 5) == "CD_W_")  { w_c++;   if (w_c<=w)     { el1.checked = true; }}
			if (na1.substring(0, 3) == "UOV")    { uov_c++; if (uov_c<=uov) { el1.checked = true; }}
		}
	});

	//console.log("range2: " + tc_rangeValueReading);
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
	var updatemovementpointsjump = movementpointsjump;

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
	document.getElementById("firepanel").style.display = "block";
	document.getElementById("firepanel").style.visibility = "visible";
	document.getElementById("firepanelhidden").style.display = "none";
	document.getElementById("firepanelhidden").style.visibility = "hidden";
	if (mvmnt == 2) { // Stationary (AMM -1)
		radioMV2_moved2_standstill.checked = true;
		if (unitType != "BA") {
			document.getElementById("AMM").innerHTML = "-1";
			tc_amm = -1;
		}
	}
	if (mvmnt == 3) { // walked
		radioMV3_moved3_moved.checked = true;
		document.getElementById("AMM").innerHTML = "0";
		tc_amm = 0;
	}
	if (mvmnt == 10) { // hulldown
		radioMV10_moved10_hulldown.checked = true;
		document.getElementById("AMM").innerHTML = "0";
	    updatedmovementpointsground = updatedmovementpointsground - 4;
	    document.getElementById("tmmLabel").innerHTML = "TMM*:";
	    tc_amm = 0;
	}
	if (mvmnt == 9) { // sprinted
		radioMV9_moved9_sprinted.checked = true;
		document.getElementById("AMM").innerHTML = "0";
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
			tc_amm = 2;
		}
	}
	if (wpnsf == 1) { // hold fire
		radioWF5_WEAPONSFIRED2.checked = true;
	}
	if (wpnsf == 2) { // fired
		radioWF6_WEAPONSFIRED2.checked = true;
	}

	if (e == 0) {
//    	document.getElementById("ht_field").style.color ="#000000";
	} else if (e == 1) {
		enginehit = 1;
//		document.getElementById("ht_field").style.color ="#00ff00";
	} else if (e == 2) {
		enginehit = 1;
//		document.getElementById("ht_field").style.color ="#ff0000";
	}
	if (h == 0) {
		updatedshortvalue = 0;
		updatedmediumvalue = 2;
		updatedlongvalue = 4;
	} else if (h == 1) {
//		document.getElementById("ht_field").style.color ="#a49708";
		updatedshortvalue = updatedshortvalue + 1;
		updatedmediumvalue = updatedmediumvalue + 1;
		updatedlongvalue = updatedlongvalue + 1;
	} else if (h == 2) {
//		document.getElementById("ht_field").style.color ="#da8e25";
		updatedshortvalue = updatedshortvalue + 2;
		updatedmediumvalue = updatedmediumvalue + 2;
		updatedlongvalue = updatedlongvalue + 2;
	} else if (h == 3) {
//		document.getElementById("ht_field").style.color ="#ba4112";
		updatedshortvalue = updatedshortvalue + 3;
		updatedmediumvalue = updatedmediumvalue + 3;
		updatedlongvalue = updatedlongvalue + 3;
	} else if (h == 4) {
//		document.getElementById("ht_field").style.color ="#ff0000";
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

	var updatedshortdamage = shortdamage;
	var updatedmediumdamage = mediumdamage;
	var updatedlongdamage = longdamage;

	if (w == 0) {
//		document.getElementById("dmgshort_s").style.color ="#ccc";
//		document.getElementById("dmgmedium_s").style.color ="#ccc";
//		document.getElementById("dmglong_s").style.color ="#ccc";
	} else if (w == 1) {
//		document.getElementById("dmgshort_s").style.color ="#da8e25";
//		document.getElementById("dmgmedium_s").style.color ="#da8e25";
//		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 1;
		updatedmediumdamage = updatedmediumdamage - 1;
		updatedlongdamage = updatedlongdamage - 1;
	} else if (w == 2) {
//		document.getElementById("dmgshort_s").style.color ="#da8e25";
//		document.getElementById("dmgmedium_s").style.color ="#da8e25";
//		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 2;
		updatedmediumdamage = updatedmediumdamage - 2;
		updatedlongdamage = updatedlongdamage - 2;
	} else if (w == 3) {
//		document.getElementById("dmgshort_s").style.color ="#da8e25";
//		document.getElementById("dmgmedium_s").style.color ="#da8e25";
//		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 3;
		updatedmediumdamage = updatedmediumdamage - 3;
 		updatedlongdamage = updatedlongdamage - 3;
	} else if (w == 4) {
//		document.getElementById("dmgshort_s").style.color ="#da8e25";
//		document.getElementById("dmgmedium_s").style.color ="#da8e25";
//		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 4;
		updatedmediumdamage = updatedmediumdamage - 4;
		updatedlongdamage = updatedlongdamage - 4;
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

	document.getElementById("dmgshort_s").innerHTML = updatedshortdamage;
	document.getElementById("dmgmedium_s").innerHTML = updatedmediumdamage;
	document.getElementById("dmglong_s").innerHTML = updatedlongdamage;

	if (mp == 0) { // Critical movement point hits
//		document.getElementById("mv_points").style.color = "#ccc";
//		document.getElementById("TMM").style.color = "#ccc";
	} else if (mp == 1) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 2);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 2);
	} else if (mp == 2) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 4);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 4);
	} else if (mp == 3) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 8);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 8);
	} else if (mp == 4) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 16);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 16);
	}
	if (h == 1) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = updatedmovementpointsground - 2;
//		updatemovementpointsjump = updatemovementpointsjump - 2;
	} else if (h == 2) {
//		document.getElementById("mv_points").style.color ="#a49708";
//    	document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = updatedmovementpointsground - 4;
//		updatemovementpointsjump = updatemovementpointsjump - 4;
	} else if (h == 3) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = updatedmovementpointsground - 6;
//		updatemovementpointsjump = updatemovementpointsjump - 6;
	} else if (h == 4) {
//		document.getElementById("mv_points").style.color ="#ff0000";
//		document.getElementById("TMM").style.color ="#ff0000";
		updatedmovementpointsground = 0;
		updatemovementpointsjump = 0;
	}
	if (updatedmovementpointsground < 0) {
//		document.getElementById("mv_points").style.color ="#ff0000";
		updatedmovementpointsground = 0;
	}
    if (updatemovementpointsjump < 0) {
//		document.getElementById("mv_points").style.color ="#ff0000";
		updatemovementpointsjump = 0;
	}

	//console.log("MV: " + updatedmovementpointsground);
	//console.log("MVj: " + updatemovementpointsjump);
	//console.log("Rounding up to hex value");

	if (showDistancesHexes == 1) {
		var updatedmovementpointsgroundHexes =  Math.ceil(updatedmovementpointsground / 2);
		var updatedmovementpointsjumpHexes = Math.ceil(updatemovementpointsjump / 2);

		var mvstring = updatedmovementpointsgroundHexes + "<span style='font-size:0.6em;'>&#11043;</span>"; // Unicode for Hexagon
		mvstring = mvstring + MV_TYPE;
		if (updatedmovementpointsjumpHexes > 0) {
			mvstring = mvstring + "/" + updatedmovementpointsjumpHexes + "<span style='font-size:0.6em;'>&#11043;</span>j"; // Unicode for Hexagon
		}
		document.getElementById("mv_points").innerHTML = mvstring;
	} else {
		var mvstring = updatedmovementpointsground + "&rdquo;";
		mvstring = mvstring + MV_TYPE;
		if (updatemovementpointsjump > 0) {
			mvstring = mvstring + "/" + updatemovementpointsjump + "&rdquo;j";
		}
		document.getElementById("mv_points").innerHTML = mvstring;
	}

	//console.log("TMM ------------>");
	var tmpTMM = originalTMM;
	//console.log("Mech: " + mechmodel);
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
//		document.getElementById("minrollshort").style.color ="#00ff00";
		document.getElementById("minrollshort").innerHTML="S (" + updatedshortvalue + ")";
	} else if (updatedshortvalue == 0) {
//		document.getElementById("minrollshort").style.color ="#999";
		document.getElementById("minrollshort").innerHTML="S (+" + updatedshortvalue + ")";
	} else if (updatedshortvalue > 0) {
//		document.getElementById("minrollshort").style.color ="#a49708";
		document.getElementById("minrollshort").innerHTML="S (+" + updatedshortvalue + ")";
	}

	if (updatedmediumvalue < 0) {
//		document.getElementById("minrollmedium").style.color ="#00ff00";
		document.getElementById("minrollmedium").innerHTML="M (" + updatedmediumvalue + ")";
	} else if (updatedmediumvalue == 0) {
//		document.getElementById("minrollmedium").style.color ="#a49708";
		document.getElementById("minrollmedium").innerHTML="M (+" + updatedmediumvalue + ")";
	} else if (updatedmediumvalue > 0) {
//		document.getElementById("minrollmedium").style.color ="#a49708";
		document.getElementById("minrollmedium").innerHTML="M (+" + updatedmediumvalue + ")";
	}
	if (updatedmediumvalue == 2) {
//		document.getElementById("minrollmedium").style.color ="#999";
	}

	if (updatedlongvalue < 0) {
//		document.getElementById("minrolllong").style.color ="#00ff00";
		document.getElementById("minrolllong").innerHTML="L (" + updatedlongvalue + ")";
	} else if (updatedlongvalue == 0) {
//		document.getElementById("minrolllong").style.color ="#a49708";
		document.getElementById("minrolllong").innerHTML="L (+" + updatedlongvalue + ")";
	} else if (updatedlongvalue > 0) {
//		document.getElementById("minrolllong").style.color ="#a49708";
		document.getElementById("minrolllong").innerHTML="L (+" + updatedlongvalue + ")";
	}
	if (updatedlongvalue == 4) {
//		document.getElementById("minrolllong").style.color ="#999";
	}

	if (a > 1) {
		mechstatus = 2;
	}
	if (s > 1) {
		mechstatus = 3;
	}
	if (s == maximalstructurepoints) {
		mechstatus = 4;
	}
	if (e == 2) {
		mechstatus = 4;
	}
	if (mechstatusstring == 'crippled') {
		mechstatus = 9;
	}

	var temp0 = "./images/temp_0.png";
	var temp1 = "./images/temp_1.png";
	var temp2 = "./images/temp_2.png";
	var temp3 = "./images/temp_3.png";
	var temp4 = "./images/temp_4.png";

	$("#crippledIndicator").hide();
	if (mechstatus == 9) {
		// Mech crippled
		$("#crippledIndicator").show();
	}

	$("#shutdownIndicator").hide();
	if (h == 4) {
		// Mech destroyed
		$("#crippledIndicator").hide();
		$("#shutdownIndicator").show();
	}

	$("#destroyedIndicator").hide();
	if (mechstatus == 4) {
		// Mech destroyed
		$("#shutdownIndicator").hide();
		$("#crippledIndicator").hide();
		$("#destroyedIndicator").show();
	}

	if (h == 0) {
		document.getElementById('heatimage_' + chosenmechindex).src=temp0;
	}
	if (h == 1) {
		document.getElementById('heatimage_' + chosenmechindex).src=temp1;
	}
	if (h == 2) {
		document.getElementById('heatimage_' + chosenmechindex).src=temp2;
	}
	if (h == 3) {
		document.getElementById('heatimage_' + chosenmechindex).src=temp3;
	}
	if (h == 4 && mechstatus != 4) {
		document.getElementById('heatimage_' + chosenmechindex).src=temp4;
		document.getElementById('mechalive_status').src="./images/heatalarm.gif";
	}

	var tmmDiceValue = document.getElementById("TMM").innerHTML;
	var movementdiestring = "";
	document.getElementById('firecontainer').className = "datalabel_thin";
	if (mvmnt == "0") { // not moved yet
	    movementdiestring = movementdiestring + "empty.png";
	    document.getElementById('INFOMOVED').innerHTML = "";
	} else if (mvmnt == "2") { // stationary
	    movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
	    document.getElementById('INFOMOVED').innerHTML = "STD";
	} else if (mvmnt == "3") { // walked
	    movementdiestring = movementdiestring + "d6_" + tmmDiceValue + ".png";
	    document.getElementById('INFOMOVED').innerHTML = "WLK";
	} else if (mvmnt == "10") { // hulldown
		movementdiestring = movementdiestring + "bd6_" + tmmDiceValue + ".png";
		document.getElementById('INFOMOVED').innerHTML = "HDWN";
	}  else if (mvmnt == "4") { // jumped
	    movementdiestring = movementdiestring + "rd6_" + tmmDiceValue + ".png";
	    document.getElementById('INFOMOVED').innerHTML = "JMP";
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

	document.getElementById('movementtokenimage').src="./images/dice/" + movementdiestring;

	if (mvmnt == 0 && wpnsf == 0) {
		document.getElementById('phasebuttonimage').src="./images/top-right_phase01.png";
	} else if (mvmnt > 0 && wpnsf == 0) {
		document.getElementById('phasebuttonimage').src="./images/top-right_phase02.png";
	} else if (mvmnt > 0 && wpnsf > 0) {
		document.getElementById('phasebuttonimage').src="./images/top-right_phase03.png";
	} else {
		document.getElementById("WF5_WEAPONSFIRED2").checked = false;
		document.getElementById("WF6_WEAPONSFIRED2").checked = false;
		document.getElementById('INFOFIRED').innerHTML = "";
		document.getElementById('phasebuttonimage').src="./images/top-right_phase01.png";

		playErrorSound();
	}
	updateOverAllToHitValue(1);
}

function textSize(dec) {
	fontsizeLabel += (dec==1) ? 1 : (-1);

	if (fontsizeLabel < minSize) {
		fontsizeLabel = minSize;
	} else if (fontsizeLabel > maxSize) {
		fontsizeLabel = maxSize;
	}

	fontsizeLabelthin = fontsizeLabel * fontsizeLabelthinFactor;
	fontsizeLabelthinSmall = fontsizeLabel * fontsizeLabelthinSmallFactor;
	fontsizeValue = fontsizeLabel * fontsizeValueFactor;
	fontsizeValueThin = fontsizeLabel * fontsizeValueThinFactor;
	fontsizeCircle = fontsizeLabel * fontsizeCircleFactor;

	setSize("datalabel", fontsizeLabel);
	setSize("datalabel_button", fontsizeLabel);
	setSize("datalabel_disabled_solid", fontsizeLabel);
	setSize("datalabel_disabled_dashed", fontsizeLabel);
	setSize("datalabel_thin", fontsizeLabelthin);
	setSize("datalabel_thin_small", fontsizeLabelthinSmall);
	setSize("datalabel_thin_disabled", fontsizeLabelthin);
	setSize("datavalue", fontsizeValue);
	setSize("datavalue_small", fontsizeValue);
	setSize("datavalue_thin", fontsizeValueThin);
	setSize("datavalue_special", fontsizeLabel);
	setSize("bigcheck-target", fontsizeCircle);

	setCookie("fontsizeLabel", fontsizeLabel, 365);
	setCookie("fontsizeLabelthin", fontsizeLabelthin, 365);
	setCookie("fontsizeLabelthinSmall", fontsizeLabelthin, 365);
	setCookie("fontsizeValue", fontsizeValue, 365);
	setCookie("fontsizeCircle", fontsizeCircle, 365);
	setCookie("savedBefore", "true", 365);
}

function increaseENGN_PREP() {
	//console.log("ENGN_PREP: " + ENGN_PREP);
	ENGN_PREP = ENGN_PREP + 1;
	if (ENGN_PREP > 2) {
		ENGN_PREP = 0;
	}
	document.getElementById("label_ENGN_PREP").innerHTML = ENGN_PREP;
	var url="./save_PREP.php?index="+chosenmechdbid+"&desc=ENGN_PREP&value="+ENGN_PREP;
	window.frames['saveframe'].location.replace(url);
}
function increaseFCTL_PREP() {
	//console.log("FCTL_PREP: " + FCTL_PREP);
	FCTL_PREP = FCTL_PREP + 1;
	if (FCTL_PREP > 4) {
		FCTL_PREP = 0;
	}
	document.getElementById("label_FCTL_PREP").innerHTML = FCTL_PREP;
	var url="./save_PREP.php?index="+chosenmechdbid+"&desc=FCTL_PREP&value="+FCTL_PREP;
	window.frames['saveframe'].location.replace(url);
}
function increaseMP_PREP() {
	//console.log("MP_PREP: " + MP_PREP);
	MP_PREP = MP_PREP + 1;
	if (MP_PREP > 4) {
		MP_PREP = 0;
	}
	document.getElementById("label_MP_PREP").innerHTML = MP_PREP;
	var url="./save_PREP.php?index="+chosenmechdbid+"&desc=MP_PREP&value="+MP_PREP;
	window.frames['saveframe'].location.replace(url);
}
function increaseWPNS_PREP() {
	//console.log("WPNS_PREP: " + WPNS_PREP);
	WPNS_PREP = WPNS_PREP + 1;
	if (WPNS_PREP > 4) {
		WPNS_PREP = 0;
	}
	document.getElementById("label_WPNS_PREP").innerHTML = WPNS_PREP;
	var url="./save_PREP.php?index="+chosenmechdbid+"&desc=WPNS_PREP&value="+WPNS_PREP;
	window.frames['saveframe'].location.replace(url);
}

function increaseHT_PREP() {
	//console.log("HT_PREP: " + HT_PREP);
	HT_PREP = HT_PREP + 1;
	if (HT_PREP > 4) {
		HT_PREP = 0;
	}
	document.getElementById("label_HT_PREP").innerHTML = HT_PREP;
	var url="./save_PREP.php?index="+chosenmechdbid+"&desc=HT_PREP&value="+HT_PREP;
	window.frames['saveframe'].location.replace(url);
}

function rand(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}

function rolldice() {
	ccc++;
	var die_01 = rand(1, 6);
	var die_02 = rand(1, 6);
	var res = die_01 + die_02;
	var die_01_image = document.getElementById("die1");
	var die_02_image = document.getElementById("die2");

	die_01_image.src = "./images/dice/d6_" + die_01 + ".png";
	die_02_image.src = "./images/dice/d6_" + die_02 + ".png";

	rolling--;

	if (ccc == 12) {
		var t = document.getElementById("unit_type").innerHTML.slice(0, 2);
    	// console.log(t.slice(0, 2));

		var resMes = "";
		if (t == "BM") {
			     if (res ==  2) { resMes = "Ammo hit [BM]"; }
			else if (res ==  3) { resMes = "Engine hit [BM]"; }
			else if (res ==  4) { resMes = "Fire control hit [BM]"; }
			else if (res ==  5) { resMes = "No critical hit [BM]"; }
			else if (res ==  6) { resMes = "Weapon hit [BM]"; }
			else if (res ==  7) { resMes = "Movement points hit [BM]"; }
			else if (res ==  8) { resMes = "Weapon hit [BM]"; }
			else if (res ==  9) { resMes = "No critical hit [BM]"; }
			else if (res == 10) { resMes = "Fire control hit [BM]"; }
			else if (res == 11) { resMes = "Engine hit [BM]"; }
			else if (res == 12) { resMes = "Unit destroyed [BM]"; }
		} else if (t == "CV") {
			     if (res ==  2) { resMes = "Ammo hit [CV]"; }
            else if (res ==  3) { resMes = "Crew stunned [CV]"; }
            else if (res ==  4) { resMes = "Fire control hit [CV]"; }
            else if (res ==  5) { resMes = "Fire control hit [CV]"; }
            else if (res ==  6) { resMes = "No critical hit [CV]"; }
            else if (res ==  7) { resMes = "No critical hit [CV]"; }
            else if (res ==  8) { resMes = "No critical hit [CV]"; }
            else if (res ==  9) { resMes = "Weapon hit [CV]"; }
            else if (res == 10) { resMes = "Weapon hit [CV]"; }
            else if (res == 11) { resMes = "Crew killed [CV]"; }
            else if (res == 12) { resMes = "Engine hit [CV]"; }
		}

		document.getElementById("criticalhit").innerHTML=res + ": " + resMes;
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
		document.getElementById("mechimage").src=mechImageURLMUL;
		const allDataAreas = document.getElementsByClassName("dataarea");
		for (let i = 0; i < allDataAreas.length; i++) {
			allDataAreas[i].style.backgroundColor="rgba(255,255,255,0.85)"
		}
		const allDataAreaReds = document.getElementsByClassName("dataarea_red");
		for (let i = 0; i < allDataAreaReds.length; i++) {
			//allDataAreaReds[i].style.backgroundColor="rgba(255,255,255,0.85)";
			allDataAreaReds[i].style.backgroundColor="rgba(10,10,10,0.70)";
		}
		const allDataValues = document.getElementsByClassName("datavalue");
		for (let i = 0; i < allDataValues.length; i++) {
			allDataValues[i].style.color="#000"
		}
		const allDataValueThins = document.getElementsByClassName("datavalue_thin");
		for (let i = 0; i < allDataValueThins.length; i++) {
			allDataValueThins[i].style.color="#000"
		}
	} else {
		// Set use MUL images to 0 on database (dark background + alternative images)
		var url="./save_UseMULImages.php?playerId="+playerId+"&useMulImages=0";
		window.frames['saveframe'].location.replace(url);
		document.getElementById("mechimage").src=mechImageURL;
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
	}
}

function showMech() {
	if (!showingMech) {
		$("#movementtoken").fadeOut(500, "linear");
	    $(".dataarea").each(function() {
			$(this).fadeOut(500, "linear");
		});
	    $(".dataarea_red").each(function() {
			$(this).fadeOut(500, "linear");
		});
		showingMech = true;
	} else {
		/*
		$("#movementtoken").fadeIn(500, "linear");
		$(".dataarea").each(function() {
			$(this).fadeIn(500, "linear");
		});
		*/
		showingMech = false;
		location.reload();
	}

	/*
	if (mvmnt == 9) { // sprinted
		document.getElementById("firepanel").style.display = "none";
		document.getElementById("firepanel").style.visibility = "hidden";
		document.getElementById("firepanelhidden").style.display = "block";
		document.getElementById("firepanelhidden").style.visibility = "visible";
	} else {
		document.getElementById("firepanel").style.display = "block";
		document.getElementById("firepanel").style.visibility = "visible";
		document.getElementById("firepanelhidden").style.display = "none";
		document.getElementById("firepanelhidden").style.visibility = "hidden";
	}
	*/
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
	//console.log("tap");
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

	//console.log("Skill: " + tc_skill);

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
	$("#destroyedIndicator").fadeOut(500, "linear");
}
function hideCrippled() {
	$("#crippledIndicator").fadeOut(500, "linear");
}
function hideShutdownIndicator() {
	$("#shutdownIndicator").fadeOut(500, "linear");
}

$(window).resize(function() {
	var mechimage = document.getElementById("mechimage");
	mechimage.style.height="" + $(document).height() * 0.8 + "px";
});

//$(window).load(function() {
//     alert("hi 2");
//});

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

	var mechimage = document.getElementById("mechimage");
	mechimage.style.height="" + ($(document).height() * 0.8 + "px");

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		el1.addEventListener('click', function() {
			if (context != null ) {
				context.resume().then(() => {
				//console.log('Playback resumed successfully');
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
				//console.log('Playback resumed successfully');
			});
		} else {
            context = new AudioContext();
		}
	});

	var diceButton = document.getElementById("DiceButton");
	diceButton.addEventListener('click', function() {
		if (context != null ) {
			context.resume().then(() => {
				//console.log('Playback resumed successfully');
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

	if (getCookie("savedBefore") === "true") {
		fontsizeLabel = parseInt(getCookie("fontsizeLabel"));
		if (fontsizeLabel < minSize) {
			fontsizeLabel = minSize;
		}
		if (fontsizeLabel > maxSize) {
			fontsizeLabel = maxSize;
		}
		fontsizeLabelthin = fontsizeLabel * fontsizeLabelthinFactor;
		fontsizeLabelthinSmall = fontsizeLabel * fontsizeLabelthinSmallFactor;
		fontsizeValue = fontsizeLabel * fontsizeValueFactor;
		fontsizeValueThin = fontsizeLabel * fontsizeValueThinFactor;
		fontsizeCircle = fontsizeLabel * fontsizeCircleFactor;

		setSize("datalabel", fontsizeLabel);
		setSize("datalabel_button", fontsizeLabel);
		setSize("datalabel_disabled_solid", fontsizeLabel);
		setSize("datalabel_disabled_dashed", fontsizeLabel);
		setSize("datalabel_thin", fontsizeLabelthin);
		setSize("datalabel_thin_small", fontsizeLabelthinSmall);
		setSize("datalabel_thin_disabled", fontsizeLabelthin);
		setSize("datavalue", fontsizeValue);
		setSize("datavalue_small", fontsizeValue);
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
		document.getElementById("mechimage").src=mechImageURLMUL;
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
			allDataAreaReds[i].style.backgroundColor="rgba(10,10,10,0.70)";
		}
	} else {
		// Set use MUL images to 0 on database (dark background + alternative images)
		var url="./save_UseMULImages.php?playerId="+playerId+"&useMulImages=0";
		window.frames['saveframe'].location.replace(url);
		document.getElementById("mechimage").src=mechImageURL;
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
	}

//	$("#cover").fadeOut(350, "linear", function() {
//		$("#cover").hide();
//		document.getElementById("cover").style.visibility = "hidden";
//	});

});
