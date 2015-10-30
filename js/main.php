<?php

session_start();

header('Content-Type: application/javascript');

?>

var greatnonsens = new Firebase('https://greatnonsens.firebaseio.com/');

var news = greatnonsens.child('users/<?=$_SESSION['user']['id']; ?>/news_feed/');

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

// news.push({'data': false, 'from': 1, 'name': 'soupyfloors', 'type': 'friend_request', 'unread': true, 'time': Firebase.ServerValue.TIMESTAMP});

// news.on('child_added', function(snapshot) {
//   	alert(snapshot.val().type);  // Alerts "San Francisco"
// });