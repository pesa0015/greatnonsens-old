var success = document.getElementById('success');
function mailSent(response, data) {
	var result = JSON.parse(response);
	if (result.success) {
		success.innerHTML = '<div>Mail för att återställa lösenord har skickats till ' + result.users_mail + '</div>';
	}
}
function forgotPassword(e) {
	e.preventDefault();
	var user = document.getElementById('user');
	sendXhttp(mailSent, 'form/post/user/forgot_password', 'user=' + user.value, null);
}