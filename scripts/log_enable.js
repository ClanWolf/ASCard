document.addEventListener('keydown', function(event) {
	if (event.ctrlKey && event.shiftKey && event.key === 'L') {
		if (document.getElementById("iframe_save") != null) {
			if (document.getElementById("iframe_save").style.visibility == "visible") {
				document.getElementById("iframe_save").style.visibility = "hidden";
				document.getElementById("iframe_save").style.display = "none";
				setCookie("showLog", 0, 1);
			} else {
				document.getElementById("iframe_save").style.visibility = "visible";
				document.getElementById("iframe_save").style.display = "block";
				setCookie("showLog", 1, 1);
			}
		}
		event.preventDefault();
	}
});

let showLogCookieValue = getCookie("showLog");

if (showLogCookieValue) {
	if (showLogCookieValue == 1) {
		if (document.getElementById("iframe_save") != null) {
			document.getElementById("iframe_save").style.visibility = "visible";
			document.getElementById("iframe_save").style.display = "block";
		}
	} else {
		if (document.getElementById("iframe_save") != null) {
			document.getElementById("iframe_save").style.visibility = "hidden";
			document.getElementById("iframe_save").style.display = "none";
		}
	}
}
