var success = document.getElementById('success');
function newPasswordSet(response, data) {
	var result = JSON.parse(response);
	if (result.success) {
		success.innerHTML = '<div>Lösenordet har återställts. <a href="login">Logga in</a>.</div>';
	}
}
function resetPassword(e) {
	e.preventDefault();
	var password = document.getElementById('new_password');
	var email = document.getElementById('email');
	var token = document.getElementById('token');
	var param = 'new_password=' + password.value + '&email=' + email.value + '&token=' + token.value;
	sendXhttp(newPasswordSet, 'form/post/user/reset_password', param, null);
}