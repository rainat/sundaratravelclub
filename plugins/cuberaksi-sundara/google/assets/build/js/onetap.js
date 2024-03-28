window.LoginWithGoogleDataCallBack = function (e) {
	var t = new XMLHttpRequest();
	t.open("POST", TempAccessOneTap.ajaxurl, !0),
		t.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"),
		(t.onreadystatechange = function () {
			if (t.readyState === XMLHttpRequest.DONE && 200 === t.status) {
				var e = JSON.parse(t.responseText);
				if (!e.success) return void alert(e.data);
				try {
					var a = new URL(e.data.redirect),
						n = new URL(TempAccessOneTap.homeurl);
					if (a.host !== n.host)
						throw new URIError(
							wp.i18n.__(
								"Invalid URL for Redirection",
								"login-with-google",
							),
						);
				} catch (e) {
					return void alert(e.message);
				}
				// console.log({redirect:e.data.redirect})
				window.location = e.data.redirect;
			}
		}),
		t.send(
			"action=validate_id_token&token=" +
				e.credential +
				"&state=" +
				TempAccessOneTap.state,
		);
};
