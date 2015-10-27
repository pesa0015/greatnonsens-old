// $(document).ready(function(){
//   $('#hide_register').on('hidden.bs.dropdown', function(){
//         $('#login_form').css('opacity', '1');
//     });
// });

$(document).ready(function(){
    $('#select2_family').select2({
      tags: true,
      ajax: {
       url: 'form/search.php',
       type: 'POST',
       dataType: 'json',
       minimumInputLength: 1,
       data: function (writers) {
           return {
             writers: writers,
           };
       },
       results: function (data) {
                var myResults = [];
                $.each(data, function (index, item) {
                    myResults.push({
                        'id': item.user_id,
                        'text': item.username
                    });
                });
                return {
                    results: myResults
                };
            }
      }
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