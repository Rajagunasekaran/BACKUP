$(document).ready(function() {
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	function setCookie(name, value, expires) {
		cookieStr = name + "=" + escape(value) + "; ";
		if (expires) {
			expires = setExpiration(expires);
			cookieStr += "expires=" + expires + "; ";
		}
		document.cookie = cookieStr;
	}

	function setExpiration(cookieLife) {
		var today = new Date();
		var expr = new Date(today.getTime() + cookieLife * 24 * 60 * 60 * 1000);
		return expr.toGMTString();
	}

	var cookie = getCookie("visited");
	if (cookie == "") {
		setTimeout(function() {
			displayPopup('show');
			setCookie('visited', 'true', 1);
		}, 600);
	} else {
		displayPopup('hide');
	}

	function displayPopup($action) {
		if ($action == 'show') {
			$('#popup-newsletter').fadeIn();
		} else {
			$('#popup-newsletter').fadeOut();
		}
		return false;
	}
});