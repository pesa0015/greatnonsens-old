<?php

session_start();

header('Content-Type: application/javascript');

?>

var greatnonsens = new Firebase('https://test-greatnonsens.firebaseio.com/');

			var news = greatnonsens.child('users_news_feed/<?=$_SESSION['user']['id']; ?>/newsItem/');
			var chat = greatnonsens.child('groups/' + group_id + '/chat/');

			// alert(newsitem);
			// // var newsitem_read = document.getElementById('news');
			// console.log(newsitem.length);

			news.limitToLast(5).on('child_added', function(snapshot) {
				if (snapshot.key() != null || snapshot.key() != 'undefined')
					$('#nothing_happened').css('display', 'none');
				var key = snapshot.key();
				var data = snapshot.val();
				var unread = data.unread;
				var time = jQuery.timeago(data.time);
				var type = data.type;
				var name = data.name;
				if (type === 'friend_request') {
					$('#news').append('<li id="' + key + '" class="newsitem unread-' + unread + '"><a href="profile?view=friends">' + name + ' vill bli vän med dig<p>' + time + '</p></a></li>');
					// alert(snapshot.val().from);
				}  
			});

			var newsitem = document.getElementById('news');
			// for (var key in newsitem) {
			//   	console.log(key + " -> " + newsitem[key]);
			// }

			// var message = $('#chat');
			var message = document.getElementById('chat');

			// LISTEN FOR KEYPRESS EVENT
			  message.onkeypress = function (e) {
			    if (e.keyCode == 13) {
			      //FIELD VALUES
			      var user_id = '<?=$_SESSION['user']['id']; ?>';
			      var user_name = '<?=$_SESSION['user']['name']; ?>';
			      var message = document.getElementById('chat').value;

			      //SAVE DATA TO FIREBASE AND EMPTY FIELD
			      chat.push({user_id: user_id, user_name: user_name, message: message, time: Firebase.ServerValue.TIMESTAMP});
			      // console.log('user_id: ' + user_id + ', user_name: ' + user_name + ', message: ' + message);
			      // alert(message);
			      message.value = '';
			    }
			  };

			  // Add a callback that is triggered for each chat message.
			  chat.on('child_added', function (snapshot) {
			    //GET DATA
			    var data = snapshot.val();
			    var username = data.user_name;
			    var message = data.message;
			    var time = jQuery.timeago(data.time);

			    $('#chat_box').append('<div class="chat-item"><strong>' + username + '</strong> ' + message + '<p><small>' + time + '</small></p></div>');

			    // //CREATE ELEMENTS MESSAGE & SANITIZE TEXT
			    // var messageElement = $("<li>");
			    // var nameElement = $("<strong class='example-chat-username'></strong>")
			    // nameElement.text(username);
			    // messageElement.text(message).prepend(nameElement);

			    // //ADD MESSAGE
			    // messageList.append(messageElement)

			    // //SCROLL TO BOTTOM OF MESSAGE LIST
			    // messageList[0].scrollTop = messageList[0].scrollHeight;
			  });


			// news.push({'data': false, 'from': 1, 'name': 'soupyfloors', 'type': 'friend_request', 'unread': true, 'time': Firebase.ServerValue.TIMESTAMP});

			// news.on('child_added', function(snapshot) {
			//   	alert(snapshot.val().type);  // Alerts "San Francisco"
			// });