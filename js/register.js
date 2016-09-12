var success = document.getElementById('success');
var signup_form = document.getElementById('signup_form');
var hideIfRegistered = document.getElementById('hide-if-registered');
var loginForm = '<form action="form/post/user/auth" method="post" id="signup_form" class="form-horizontal login-register-form">'
					+ '<div class="form-group">'
					+		'<input type="text" name="user" class="form-control" placeholder="Användarnamn">'
					+			'</div>'
					+			'<div class="form-group">'
					+				'<input type="password" name="password" class="form-control" placeholder="Lösenord">'
					+			'</div>'
					+			'<div class="form-group">'
					+				'<input type="submit" class="btn btn-success" value="Logga in">'
					+			'</div>'
					+		'</form>';
function registerFormSubmitted(response, data) {
	$('.input-error.input-show-error').attr('class', 'input-error');
	var result = JSON.parse(response);
	if (result.success) {
		var saveUser = firebase.database().ref('users/' + result.user_id);
		saveUser.set({news: false, on_turn: false, story_began: false, story_finish: false});
		$(signup_form).fadeOut(1000);
		$(hideIfRegistered).fadeOut(1000);
			setTimeout(function() {
				$(success).prepend('<h1>Välkommen till Great nonsens, ' + data.username + '</h1><h1>Logga in</h1><hr />');
				$(success).append(loginForm);
				}, 1000);
		}
	else {
		for (var i = 0; i < result.text.length; i++) {
			document.getElementById('error-' + result.type[i]).innerHTML = result.text[i];
			document.getElementById('error-' + result.type[i]).className += ' input-show-error';
		}
	}
}
function register(e) {
	e.preventDefault();
	var user = document.getElementById('user');
	var email = document.getElementById('email');
	var password = document.getElementById('password');
	var password_repeat = document.getElementById('password_repeat');
	var param = 'user=' + user.value + '&email=' + email.value + '&password=' + password.value + '&password_repeat=' + password_repeat.value;
	sendXhttp(registerFormSubmitted, 'form/post/user/new', param, {username: user.value});
}