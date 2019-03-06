var fontsizeLabel = 16;
var fontsizeValue = 16;
var fontsizeCircle = 18;
var rolling = 0;

// http://goldfirestudios.com/blog/104/howler.js-Modern-Web-Audio-Javascript-Library
var sound_dice = null;
var sound_key = null;

function setSize(name, value) {
	var list = document.getElementsByClassName(name);
	[].forEach.call(list, function (el) {
		el.style.fontSize="" + value + "px";
	});
}

function readCircles(index) {
	playTapSound();

	var na = "";

	var h = 0;
	var a = 0;
	var s = 0;
	var e = 0;
	var fc = 0;
	var mp = 0;
	var w = 0;

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
	var url="./save.php?index="+index+"&h="+h+"&a="+a+"&s="+s+"&e="+e+"&fc="+fc+"&mp="+mp+"&w="+w;
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

	var list = document.getElementsByClassName("bigcheck");
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
}

function textSize(dec) {
	fontsizeLabel += (dec==1) ? 1 : (-1);
	fontsizeValue += (dec==1) ? 1 : (-1);
	fontsizeCircle += (dec==1) ? 1 : (-1);

	if (fontsizeLabel < 22) {
		fontsizeLabel = 22;
		fontsizeValue = 22;
		fontsizeValue = 22;
	}
	if (fontsizeValue < 22) {
		fontsizeLabel = 22;
		fontsizeValue = 22;
		fontsizeValue = 22;
	}
	if (fontsizeCircle < 22) {
		fontsizeLabel = 22;
		fontsizeValue = 22;
		fontsizeValue = 22;
	}

	if (fontsizeLabel > 75) {
		fontsizeLabel = 75;
		fontsizeValue = 75;
		fontsizeValue = 75;
	}
	if (fontsizeValue > 75) {
		fontsizeLabel = 75;
		fontsizeValue = 75;
		fontsizeValue = 75;
	}
	if (fontsizeCircle > 75) {
		fontsizeLabel = 75;
		fontsizeValue = 75;
		fontsizeValue = 75;
	}

	setSize("datalabel", fontsizeLabel);
	setSize("datavalue", fontsizeValue);
	setSize("datavalue_thin", fontsizeLabel);
	setSize("bigcheck-target", fontsizeCircle);

	setCookie("fontsizeLabel", fontsizeLabel, 365);
	setCookie("fontsizeValue", fontsizeValue, 365);
	setCookie("fontsizeCircle", fontsizeCircle, 365);
	setCookie("savedBefore", "true", 365);
}

$(document).ready(function() {
	if (getCookie("savedBefore") === "true") {
		fontsizeLabel = parseInt(getCookie("fontsizeLabel"));
		fontsizeValue = parseInt(getCookie("fontsizeValue"));
		fontsizeCircle = parseInt(getCookie("fontsizeCircle"));
		setSize("datalabel", fontsizeLabel);
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

function updateSite(event) {
	window.location.reload();
}
window.applicationCache.addEventListener('updateready', updateSite, false);
