function Registration() {

	Registration.prototype.init = function () {

		var profile = new Profile({
							handleUpdateSuccess: redirect,
							handleValidationFailed: refreshCaptcha
						});
		profile.init();

	};

	function redirect(response) {
		window.location = response.url;
	}

	function refreshCaptcha(response) {
		var src = $('#captchaImg').attr('src') + '?' + Math.random();
		$('#captchaImg').attr('src', src);
		$('#captchaValue').val('');
	}
}