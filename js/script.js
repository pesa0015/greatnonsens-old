$(document).ready(function () {
    $('#newStoryModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});

$(document).ready(function () {
    $('#writeModal').on('hidden.bs.modal', function () {
    	window.history.back();
	});
});

$(document).ready(function(){
  $('#hide_register').on('hidden.bs.dropdown', function(){
        $('#login_form').css('opacity', '1');
    });
});

var password = $('#password');
// var password_repeat = $('#password_repeat');

$(document).ready(function(){
    $(password).on('input', function() {
        if (password.val().length >= 5)
            $('#password_repeat').css('display', 'block');
        else
            $('#password_repeat').css('display', 'none');
    });
});

var register = document.getElementById('register');
var login_form = document.getElementById('login_form');
register.addEventListener('click', function() {
	login_form.style.opacity = '0.1';
});
login_form.addEventListener('click', function() {
	login_form.style.opacity = '1';
});