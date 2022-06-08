var fontsizeLabel = 18;
var fontsizeLabelthin = 10;
var fontsizeValue = 22;
var fontsizeCircle = 24;
var rolling = 0;
var ccc = 1;
var structuralDamageCache = 0;

var mechstatus = 1; // 1: green (untouched) | 2: yellow (hit) | 3: red (crit) | 4: black (wrecked)
var enginehit = 0;
var updatedshortvalue = 0;
var updatedmediumvalue = 2;
var updatedlongvalue = 4;

var context = null;

// http://goldfirestudios.com/blog/104/howler.js-Modern-Web-Audio-Javascript-Library
var sound_dice = null;
var sound_key = null;

function setSize(name, value) {
	var list = document.getElementsByClassName(name);
	[].forEach.call(list, function (el) {
		el.style.fontSize="" + value + "px";
	});
}

function readCircles(index, a_max, s_max) {
	if (context != null) {
		playTapSound();
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

	var mechstatus = 1;
	var mechstatusimage = "images/DD_01.png";

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
	if (document.getElementById('unit_type').innerText == "BA") {
		mechstatusimage = "images/DD_ELE_01.png";
		if (a > 0) {
			mechstatus = 2;
			mechstatusimage = "images/DD_ELE_02.png";
		}
		if (s > 0) {
			mechstatus = 3;
			mechstatusimage = "images/DD_ELE_03.png";
		}
		if (s == maximalstructurepoints) {
			mechstatus = 4;
			mechstatusimage = "images/DD_ELE_04.png";
		}
		if (e == 2) {
			mechstatus = 4;
			mechstatusimage = "images/DD_ELE_04.png";
		}
	} else {
		mechstatusimage = "images/DD_01.png";
		if (a > 0) {
    		mechstatus = 2;
    		mechstatusimage = "images/DD_02.png";
    	}
    	if (s > 0) {
    		mechstatus = 3;
    		mechstatusimage = "images/DD_03.png";
    	}
    	if (s == maximalstructurepoints) {
    		mechstatus = 4;
    		mechstatusimage = "images/DD_04.png";
    		document.getElementById('toprightimage').src='./images/top-right_02.png';
    	}
    	if (e == 2) {
    		mechstatus = 4;
    		mechstatusimage = "images/DD_04.png";
    		document.getElementById('toprightimage').src='./images/top-right_02.png';
    	}
	}

	document.getElementById('mechstatusimagemenu').src=mechstatusimage;

	setCircles(h, a, s, e, fc, mp, w, uov);
	var url="./save.php?index="+index+"&h="+h+"&a="+a+"&s="+s+"&e="+e+"&fc="+fc+"&mp="+mp+"&w="+w+"&mstat="+mechstatusimage+"&uov="+uov;
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

function setCircles(h, a, s, e, fc, mp, w, uov) {
	var na1 = "";

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

	var updatedmovementpointsground = movementpointsground;
	var updatemovementpointsjump = movementpointsjump;
	if (mp == 0) {
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
		updatemovementpointsjump = updatemovementpointsjump - 2;
	} else if (h == 2) {
//		document.getElementById("mv_points").style.color ="#a49708";
//    	document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = updatedmovementpointsground - 4;
		updatemovementpointsjump = updatemovementpointsjump - 4;
	} else if (h == 3) {
//		document.getElementById("mv_points").style.color ="#a49708";
//		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = updatedmovementpointsground - 6;
		updatemovementpointsjump = updatemovementpointsjump - 6;
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

	// SPRINTED
	if (movement == '9') {
//		document.getElementById("mv_points").style.color ="#a49708";
	    updatedmovementpointsground = updatedmovementpointsground + (updatedmovementpointsground / 2);
	}

	var mvstring = updatedmovementpointsground + "&rdquo;";
	if (updatemovementpointsjump > 0) {
		mvstring = mvstring + "/" + updatemovementpointsjump + "&rdquo;j";
	}
	document.getElementById("mv_points").innerHTML = mvstring;

	var tmpTMM = originalTMM;
	if (movement == 0) {                            // 0:   NOT MOVED YET
        if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	} else if (movement == 1 || h == 4) {           // 1:	TMM -4					Immobile (Shutdown?)
		tmpTMM = -4;
	} else if (movement == 2) {                     // 2:	TMM 0 AMM -1			Stationary
		updatedshortvalue = updatedshortvalue - 1;
		updatedmediumvalue = updatedmediumvalue - 1;
        updatedlongvalue = updatedlongvalue - 1;
		tmpTMM = 0;
        if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	} else if (movement == 3) {                 	// 3:	TMM #		            Walked (>1")
		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	} else if (movement == 4) {                     // 4:	TMM 1 (#+SPCL) AMM +2	Jumped
		updatedshortvalue = updatedshortvalue + 2;
		updatedmediumvalue = updatedmediumvalue + 2;
		updatedlongvalue = updatedlongvalue + 2;

		if (unitType == "BA") {
			console.log("BattleArmor --> NO +1 TMM modifier (jump).");
		} else {
			console.log("NO BattleArmor --> +1 TMM modifier (jump).");
			tmpTMM = tmpTMM + 1;
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
					console.log("Found JMPS: " + value);
                }
	            if (element.indexOf('JMPW') !== -1) {
	                var num = element.replace(/[^0-9]/g,'');
					var value = parseInt(num, 10);
					console.log("Found JMPW: " + value);
	            }
            }
		}
	} else if (movement == 9) { 	                // 9:	TMM #		            Sprinted (>1")
		if (h > 1 && h < 4) { tmpTMM = tmpTMM - 1; }
	}
	console.log("H (Heat) = " + h + " / movement = " + movement + " --> TMM: " + tmpTMM);
	document.getElementById("TMM").innerHTML = tmpTMM;

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

	var wallpaperNorm = "./images/body-bg_2.png";
	var wallpaperName = getCookie("wallpaper");
	if ((wallpaperName !== null) && (typeof wallpaperName != 'undefined')) {
		if (parseFloat(wallpaperName) > 0 && parseFloat(wallpaperName) < 9) {
			wallpaperNorm = wallpaperName;
		}
	}

	// console.log(wallpaperNorm);

	var wallpaperWrecked = "./images/body-bg_wrecked2.jpg";
	var wallpaperHeated = "./images/body-bg_heated.jpg";
	var temp0 = "./images/temp_0.png";
	var temp1 = "./images/temp_1.png";
	var temp2 = "./images/temp_2.png";
	var temp3 = "./images/temp_3.png";
	var temp4 = "./images/temp_4.png";

	if (mechstatus == 4) {
		// Mech destroyed
		// document.body.style.backgroundImage = "url('" + wallpaperWrecked + "')";
		//document.getElementById('mechalive_status').src="./images/skull.png";
		//document.getElementById('toprightimage').src="./images/top-right_phase00.png";
	} else {
		// document.body.style.backgroundImage = "url('./images/body-bg_" + wallpaperNorm + ".png')";
		// document.getElementById('mechalive_status').src="./images/vitalmonitor.gif";
		// console.log(movement);
		if ((movement == 0 || movement === undefined) && weaponsfired == 0) {
		//	document.getElementById('toprightimage').src="./images/top-right_phase01.png";
		}
		if ((movement > 0 && movement < 5) && weaponsfired == 0) {
		//	document.getElementById('toprightimage').src="./images/top-right_phase02.png";
		}
		if ((movement > 0 && movement < 5) && weaponsfired == 1) {
		//	document.getElementById('toprightimage').src="./images/top-right_phase03.png";
		}
		if ((movement > 0 && movement < 5) && weaponsfired == 2) {
		//	document.getElementById('toprightimage').src="./images/top-right_phase03.png";
		}
		if ((movement > 0 && movement < 5) && weaponsfired == 3) {
		//	document.getElementById('toprightimage').src="./images/top-right_phase03.png";
		}
		if ((movement > 0 && movement < 5) && weaponsfired == 4) {
		//	document.getElementById('toprightimage').src="./images/top-right_phase03.png";
		}
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
		// document.body.style.backgroundImage = "url('" + wallpaperHeated + "')";
		document.getElementById('heatimage_' + chosenmechindex).src=temp4;
		document.getElementById('mechalive_status').src="./images/heatalarm.gif";
	}
}

function textSize(dec) {
	fontsizeLabel += (dec==1) ? 1 : (-1);
	fontsizeLabelthin += (dec==1) ? 1 : (-1);
	fontsizeValue += (dec==1) ? 1 : (-1);
	fontsizeCircle += (dec==1) ? 1 : (-1);

	if (fontsizeLabelthin < 10) {
		fontsizeLabel = 18;
		fontsizeLabelthin = 10;
		fontsizeValue = 22;
		fontsizeCircle = 24;
	}
	if (fontsizeLabel < 18) {
		fontsizeLabel = 18;
		fontsizeLabelthin = 10;
		fontsizeValue = 22;
		fontsizeCircle = 24;
	}
	if (fontsizeValue < 22) {
		fontsizeLabel = 18;
		fontsizeLabelthin = 10;
		fontsizeValue = 22;
		fontsizeCircle = 24;
	}
	if (fontsizeCircle < 24) {
		fontsizeLabel = 18;
		fontsizeLabelthin = 10;
		fontsizeValue = 22;
		fontsizeCircle = 24;
	}
	if (fontsizeLabelthin > 73) {
		fontsizeLabel = 81;
		fontsizeLabelthin = 73;
		fontsizeValue = 85;
		fontsizeCircle = 87;
	}
	if (fontsizeLabel > 81) {
		fontsizeLabel = 81;
		fontsizeLabelthin = 73;
		fontsizeValue = 85;
		fontsizeCircle = 87;
	}
	if (fontsizeValue > 85) {
		fontsizeLabel = 81;
		fontsizeLabelthin = 73;
		fontsizeValue = 85;
		fontsizeCircle = 87;
	}
	if (fontsizeCircle > 87) {
		fontsizeLabel = 81;
		fontsizeLabelthin = 73;
		fontsizeValue = 85;
		fontsizeCircle = 87;
	}

	setSize("datalabel", fontsizeLabel);
	setSize("datalabel_thin", fontsizeLabelthin);
	setSize("datavalue", fontsizeValue);
	setSize("datavalue_thin", fontsizeLabel);
	setSize("bigcheck-target", fontsizeCircle);

	setCookie("fontsizeLabel", fontsizeLabel, 365);
	setCookie("fontsizeLabelthin", fontsizeLabelthin, 365);
	setCookie("fontsizeValue", fontsizeValue, 365);
	setCookie("fontsizeCircle", fontsizeCircle, 365);
	setCookie("savedBefore", "true", 365);
}

$(document).ready(function() {
	$("#cover").fadeOut(150, "linear");

	var mechimage = document.getElementById("mechimage");
	mechimage.style.height="" + ($(document).height() * 0.8 + "px");

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		el1.addEventListener('click', function() {
			if (context != null ) {
				context.resume().then(() => {
				// console.log('Playback resumed successfully');
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
				// console.log('Playback resumed successfully');
			});
		} else {
            context = new AudioContext();
		}
	});

	var diceButton = document.getElementById("DiceButton");
	diceButton.addEventListener('click', function() {
		if (context != null ) {
			context.resume().then(() => {
				// console.log('Playback resumed successfully');
			});
		} else {
			context = new AudioContext();
		}
    });

	var moveButton = document.getElementById("MoveButton");
	moveButton.addEventListener('click', function() {
		if (context != null ) {
            context.resume().then(() => {
				// console.log('Playback resumed successfully');
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
		fontsizeLabelthin = parseInt(getCookie("fontsizeLabelthin"));
		fontsizeValue = parseInt(getCookie("fontsizeValue"));
		fontsizeCircle = parseInt(getCookie("fontsizeCircle"));
		setSize("datalabel", fontsizeLabel);
		setSize("datalabel_thin", fontsizeLabelthin);
		setSize("datavalue", fontsizeValue);
		setSize("datavalue_thin", fontsizeLabel);
		setSize("bigcheck-target", fontsizeCircle);
	}

	var wallpaperName = getCookie("wallpaper");
	if ((wallpaperName !== null) && (typeof wallpaperName != 'undefined')) {
		if (wallpaperName > 0 && wallpaperName < 9) {
			document.body.style.backgroundImage = "url('./images/body-bg_" + wallpaperName + ".png')";
		}
	}

	//$("#toprightimage").fadeOut(0, "linear");
	//$("#toprightimage").fadeIn(1000, "linear");
});

$(window).resize(function() {
	var mechimage = document.getElementById("mechimage");
	mechimage.style.height="" + $(document).height() * 0.8 + "px";
});

function rand (min, max) {
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
		var resMes = "";
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

		document.getElementById("criticalhit").innerHTML=res + ": " + resMes;
		ccc = 1;
	}
}

function changeWallpaper() {
	var wallpaperName = getCookie("wallpaper");
	if (isNaN(parseFloat(wallpaperName)) || parseFloat(wallpaperName) > 8 || parseFloat(wallpaperName) < 0) {
		wallpaperName = 0;
	}

	var wallpaperNameRand = parseFloat(wallpaperName) + 1;
	if (wallpaperNameRand > 8) {
		wallpaperNameRand = 1;
	}
   	// console.log(wallpaperNameRand);
	document.body.style.backgroundImage = "url('./images/body-bg_" + wallpaperNameRand + ".png')";
	setCookie("wallpaper", wallpaperNameRand, 365);
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

//function touchStarted() {
//
//}

//window.onload = function() {
//
//}

// function updateSite(event) {
// 	window.location.reload();
// }

// window.applicationCache.addEventListener('updateready', updateSite, false);
