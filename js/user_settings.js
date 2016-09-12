var success_div = document.getElementById('success');
var success_text = document.getElementById('success_text');
function updated(response, data) {
	console.log(response);
	var result = JSON.parse(response);
	if (result.success) {
		$('#success-' + data.typeSaved).fadeIn(500).css('display', 'inline-block');
	}
}
function update(e, type) {
	e.preventDefault();
	var input = document.getElementById(type);
	var confirmWithPassword = 0;
	var new_password = 0;
	if (type === 'email')
		var confirmWithPassword = document.getElementById(type + '-confirm-password');
	if (type === 'password') {
		var new_password = document.getElementById('new-password');
		var confirmWithPassword = document.getElementById(type + '-confirm-password');
	}
	var param = type + '=' + input.value + '&new_password=' + new_password.value + '&password_confirm=' + confirmWithPassword.value
	sendXhttp(updated, 'form/post/user/change_' + type, param, {typeSaved: type, input: input.value});
}