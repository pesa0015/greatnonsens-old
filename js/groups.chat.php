<?php

session_start();

header('Content-Type: application/javascript');

?>

var chat = greatnonsens.child('groups/<?=$_GET['view']; ?>/chat');

var message = $('#chat');
var enter = document.getElementById('enter_send');

// LISTEN FOR KEYPRESS EVENT
message.keypress(function (e) {
	if (e.keyCode == 13 && !e.shiftKey && message.val().length !== 0) {
		//FIELD VALUES
		var user_id = '<?=$_SESSION['user']['id']; ?>';
		var user_name = '<?=$_SESSION['user']['name']; ?>';

		//SAVE DATA TO FIREBASE AND EMPTY FIELD
		chat.push({'user_id': user_id, 'user_name': user_name, 'message': message.val(), 'time': Firebase.ServerValue.TIMESTAMP});
		document.getElementById('chat').value = '';
	}
});

// Add a callback that is triggered for each chat message.
chat.on('child_added', function (snapshot) {
	//GET DATA
	var data = snapshot.val();
	var username = validator.escape(data.user_name);
	var message = validator.escape(data.message);
	message = message.replace(/(?:\r\n|\r|\n)/g, '<br />');
	var time = jQuery.timeago(data.time);

	$('#chat_box').prepend('<div class="chat-item"><span class="bold">' + username + '</span> ' + message + '<p><span class="light">' + time + '</span></p></div>');
});