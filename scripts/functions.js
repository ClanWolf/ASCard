var fontsizeLabel = 18;
var fontsizeLabelthin = 10;
var fontsizeValue = 22;
var fontsizeCircle = 24;
var rolling = 0;

var mechstatus = 1; // 1: green (untouched) | 2: yellow (hit) | 3: red (crit) | 4: black (wrecked)
var enginehit = 0;
var updatedshortvalue = 0;
var updatedmediumvalue = 2;
var updatedlongvalue = 4;

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
	playTapSound();

	var na = "";

	var h = 0;
	var a = 0;
	var s = 0;
	var e = 0;
	var fc = 0;
	var mp = 0;
	var w = 0;

	var mechstatus = 1;
	var mechstatusimage = "images/DD_01.png";

	var list = document.getElementsByClassName("bigcheck");
	[].forEach.call(list, function (el1) {
		na = el1.name;
		if (typeof na != 'undefined') {
			if (na.substring(0, 1) == "H"      && el1.checked) { h++;  }
			if (na.substring(0, 1) == "A"      && el1.checked) { a++;  }
			if (na.substring(0, 1) == "S"      && el1.checked) { s++;  }
			if (na.substring(0, 5) == "CD_E_"  && el1.checked) { e++;  }
			if (na.substring(0, 6) == "CD_FC_" && el1.checked) { fc++; }
			if (na.substring(0, 6) == "CD_MP_" && el1.checked) { mp++; }
			if (na.substring(0, 5) == "CD_W_"  && el1.checked) { w++;  }
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
	}
	if (e == 2) {
		mechstatus = 4;
		mechstatusimage = "images/DD_04.png";
	}

	document.getElementById('mechstatusimagemenu').src=mechstatusimage;

	setCircles(h, a, s, e, fc, mp, w);
	var url="./save.php?index="+index+"&h="+h+"&a="+a+"&s="+s+"&e="+e+"&fc="+fc+"&mp="+mp+"&w="+w+"&mstat="+mechstatusimage;
	// alert(url);
	window.frames['saveframe'].location.replace(url);
}

function setCircles(h, a, s, e, fc, mp, w) {
	var na1 = "";

	var h_c = 0;
	var a_c = 0;
	var s_c = 0;
	var e_c = 0;
	var fc_c = 0;
	var mp_c = 0;
	var w_c = 0;

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
			if (na1.substring(0, 1) == "H")      { h_c++;  if (h_c<=h)   { el1.checked = true; }}
			if (na1.substring(0, 1) == "A")      { a_c++;  if (a_c<=a)   { el1.checked = true; }}
			if (na1.substring(0, 1) == "S")      { s_c++;  if (s_c<=s)   { el1.checked = true; }}
			if (na1.substring(0, 5) == "CD_E_")  { e_c++;  if (e_c<=e)   { el1.checked = true; }}
			if (na1.substring(0, 6) == "CD_FC_") { fc_c++; if (fc_c<=fc) { el1.checked = true; }}
			if (na1.substring(0, 6) == "CD_MP_") { mp_c++; if (mp_c<=mp) { el1.checked = true; }}
			if (na1.substring(0, 5) == "CD_W_")  { w_c++;  if (w_c<=w)   { el1.checked = true; }}
		}
	});
	if (e == 0) {
    	document.getElementById("ht_field").style.color ="#000000";
	} else if (e == 1) {
		enginehit = 1;
		document.getElementById("ht_field").style.color ="#00ff00";
	} else if (e == 2) {
		enginehit = 1;
		document.getElementById("ht_field").style.color ="#ff0000";
	}
	if (h == 0) {
		updatedshortvalue = 0;
		updatedmediumvalue = 2;
		updatedlongvalue = 4;
	} else if (h == 1) {
		document.getElementById("ht_field").style.color ="#a49708";
		updatedshortvalue = updatedshortvalue + 1;
		updatedmediumvalue = updatedmediumvalue + 1;
		updatedlongvalue = updatedlongvalue + 1;
	} else if (h == 2) {
		document.getElementById("ht_field").style.color ="#da8e25";
		updatedshortvalue = updatedshortvalue + 2;
		updatedmediumvalue = updatedmediumvalue + 2;
		updatedlongvalue = updatedlongvalue + 2;
	} else if (h == 3) {
		document.getElementById("ht_field").style.color ="#ba4112";
		updatedshortvalue = updatedshortvalue + 3;
		updatedmediumvalue = updatedmediumvalue + 3;
		updatedlongvalue = updatedlongvalue + 3;
	} else if (h == 4) {
		document.getElementById("ht_field").style.color ="#ff0000";
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
		document.getElementById("dmgshort_s").style.color ="#999";
		document.getElementById("dmgmedium_s").style.color ="#999";
		document.getElementById("dmglong_s").style.color ="#999";
	} else if (w == 1) {
		document.getElementById("dmgshort_s").style.color ="#da8e25";
		document.getElementById("dmgmedium_s").style.color ="#da8e25";
		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 1;
		updatedmediumdamage = updatedmediumdamage - 1;
		updatedlongdamage = updatedlongdamage - 1;
	} else if (w == 2) {
		document.getElementById("dmgshort_s").style.color ="#da8e25";
		document.getElementById("dmgmedium_s").style.color ="#da8e25";
		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 2;
		updatedmediumdamage = updatedmediumdamage - 2;
		updatedlongdamage = updatedlongdamage - 2;
	} else if (w == 3) {
		document.getElementById("dmgshort_s").style.color ="#da8e25";
		document.getElementById("dmgmedium_s").style.color ="#da8e25";
		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 3;
		updatedmediumdamage = updatedmediumdamage - 3;
 		updatedlongdamage = updatedlongdamage - 3;
	} else if (w == 4) {
		document.getElementById("dmgshort_s").style.color ="#da8e25";
		document.getElementById("dmgmedium_s").style.color ="#da8e25";
		document.getElementById("dmglong_s").style.color ="#da8e25";
		updatedshortdamage = updatedshortdamage - 4;
		updatedmediumdamage = updatedmediumdamage - 4;
		updatedlongdamage = updatedlongdamage - 4;
	}
	if (updatedshortdamage < 0) updatedshortdamage = 0;
	if (updatedmediumdamage < 0) updatedmediumdamage = 0;
	if (updatedlongdamage < 0) updatedlongdamage = 0;

	document.getElementById("dmgshort_s").innerHTML = updatedshortdamage;
	document.getElementById("dmgmedium_s").innerHTML = updatedmediumdamage;
	document.getElementById("dmglong_s").innerHTML = updatedlongdamage;

	var updatedmovementpointsground = movementpointsground;
	var updatemovementpointsjump = movementpointsjump;
	if (mp == 0) {
		document.getElementById("mv_points").style.color = "#ccc";
		document.getElementById("TMM").style.color = "#ccc";
	} else if (mp == 1) {
		document.getElementById("mv_points").style.color ="#a49708";
		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 2);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 2);
	} else if (mp == 2) {
		document.getElementById("mv_points").style.color ="#a49708";
		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 4);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 4);
	} else if (mp == 3) {
		document.getElementById("mv_points").style.color ="#a49708";
		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 8);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 8);
	} else if (mp == 4) {
		document.getElementById("mv_points").style.color ="#a49708";
		document.getElementById("TMM").style.color = "#a49708";
		updatedmovementpointsground = Math.ceil(updatedmovementpointsground / 16);
		updatemovementpointsjump = Math.ceil(updatemovementpointsjump / 16);
	}
	var mvstring = updatedmovementpointsground + "&rdquo;";
	if (updatemovementpointsjump > 0) {
		mvstring = mvstring + "/" + updatemovementpointsjump + "&rdquo;j";
	}
	document.getElementById("mv_points").innerHTML = mvstring;

	// recalculate the TMM according to changed movement
	var tmpTMM = 0;
	if(updatedmovementpointsground < 5) {
		tmpTMM = 0;
	} else if(updatedmovementpointsground < 9 ) {
		tmpTMM = 1;
	} else if(updatedmovementpointsground < 13 ) {
		tmpTMM = 2;
	} else if(updatedmovementpointsground < 19 ) {
		tmpTMM = 3;
	} else if(updatedmovementpointsground < 35 ) {
		tmpTMM = 4;
	} else {
		tmpTMM = 5;
	}
	document.getElementById("TMM").innerHTML = tmpTMM;

	if (updatedshortvalue == 0) {
		document.getElementById("minrollshort").style.color ="#999";
		document.getElementById("minrollmedium").style.color ="#999";
		document.getElementById("minrolllong").style.color ="#999";
	} else if (updatedshortvalue > 0) {
		document.getElementById("minrollshort").style.color ="#a49708";
		document.getElementById("minrollmedium").style.color ="#a49708";
		document.getElementById("minrolllong").style.color ="#a49708";
	}
	document.getElementById("minrollshort").innerHTML="S (+" + updatedshortvalue + ")";
	document.getElementById("minrollmedium").innerHTML="M (+" + updatedmediumvalue + ")";
	document.getElementById("minrolllong").innerHTML="L (+" + updatedlongvalue + ")";

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
	if (mechstatus == 4) {
		// Mech destroyed
		var wallpaperWrecked = "./images/body-bg_wrecked2.jpg";
		document.body.style.backgroundImage = "url('" + wallpaperWrecked + "')";
		document.getElementById('mechimage').src="./images/mechs/" + deadmechimage;
	} else {
		var wallpaperNorm = "./images/body-bg_2.png";
		document.body.style.backgroundImage = "url('" + wallpaperNorm + "')";
		document.getElementById('mechimage').src="./images/mechs/" + originalmechimage;
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

	var mechimage = document.getElementById("mechimage");
	mechimage.style.height="" + ($(document).height() * 0.8 + "px");

	// var wallpaperName = getCookie("wallpaper");
	// if ((wallpaperName !== null) && (typeof wallpaperName != 'undefined')) {
	// 	var res = wallpaperName.substr(-3);
	// 	if (res === "png") {
	// 		document.body.style.backgroundImage = "url('" + getCookie("wallpaper") + "')";
	// 	}
	// }

	$("#dice").click(function(event) {
		if (rolling === 0) {
			playDiceSound();
			for (i = 1; i < 12; i++) {
				rolling++;
				setTimeout("rolldice()", i * 80);
			}
			var resMes = "";
			if (res ==  2) { resMes = "Ammo hit"; }
			if (res ==  3) { resMes = "Engine hit"; }
			if (res ==  4) { resMes = "Fire control hit"; }
			if (res ==  5) { resMes = "No critical hit"; }
			if (res ==  6) { resMes = "Weapon hit"; }
			if (res ==  7) { resMes = "Movement points hit"; }
			if (res ==  8) { resMes = "Weapon hit"; }
			if (res ==  9) { resMes = "No critical hit"; }
			if (res == 10) { resMes = "Fire control hit"; }
			if (res == 11) { resMes = "Engine hit"; }
			if (res == 12) { resMes = "Unit destroyed"; }
		}
	});

	$("#cover").hide();
	//$("#cover").fadeOut(400, "linear");
});

$(window).resize(function() {
	var mechimage = document.getElementById("mechimage");
	mechimage.style.height="" + $(document).height() * 0.8 + "px";
});

function rand (min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
} 

function rolldice() {
	var die_01 = rand(1, 6);
	var die_02 = rand(1, 6);
	var die_01_image = document.getElementById("die1");
	var die_02_image = document.getElementById("die2");
	die_01_image.src = "./images/dice/d6_" + die_01 + ".png";
	die_02_image.src = "./images/dice/d6_" + die_02 + ".png";
	rolling--;
}

// function changeWallpaper() {
// 	var wallpaperName = getCookie("wallpaper");
// 	do {
// 		var wallpaperNameRand = "./images/body-bg_" + rand(1, 4) + ".png";
// 	} while (wallpaperName === wallpaperNameRand);
// 	document.body.style.backgroundImage = "url('" + wallpaperNameRand+ "')";
// 	setCookie("wallpaper", wallpaperNameRand, 365);
// }

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

// function updateSite(event) {
// 	window.location.reload();
// }
// window.applicationCache.addEventListener('updateready', updateSite, false);
