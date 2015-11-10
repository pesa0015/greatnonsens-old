<?php

session_start();

if (isset($_SESSION['user'])) {

header('Content-Type: application/javascript');

?>
var news = greatnonsens.child('users/<?=$_SESSION['user']['id']; ?>/news_feed/');

var read = document.getElementById('newsitem_read');

var read_single = document.getElementById('news');

function updateNews() {
	if (localStorage.news == 1)
		localStorage.news = 0;
	else if (localStorage.news > 1)
		localStorage.news--;
}

read.addEventListener('click', function() {
	var to_read = document.getElementsByClassName('unread-true');

	if (typeof to_read[0] !== 'undefined') {
		for (var i = to_read.length-1; i >= 0; i--) { 
			news.child(to_read[i].id).update({unread: 'false'});
			updateNews();
		}
		document.getElementById('num_of_news').innerHTML = localStorage.news;
	}	
});

var i = 0;

localStorage.news = 0;

news.on('child_added', function(snapshot) {
	var key = snapshot.key();
	var data = snapshot.val();
	var unread = data.unread;
	var time = data.time;
	var type = data.type;
	var name = data.from.user_name;

	i++;

	if (unread == 'true') {
		localStorage.news++;
		num_of_news.innerHTML = localStorage.news;
	}

	if (i <= 5) {
		if (type === 'friend_request') {
			$('#news').append('<li id="' + key + '" class="newsitem unread-' + unread + '" title="profile?view=friends">' + name + ' vill bli vän med dig<p><span data-livestamp="' + time + '"></span></p></li>');
		}
	}  
});

if (num_of_news.style.display == 'none')
	num_of_news.style.display = 'block';

news.on('value', function(snapshot) {
	if (snapshot.numChildren() > 5 && !document.contains(document.getElementById('more')))
		$('#news').append('<li id="more" title="news">Mer</li>');
});

read_single.addEventListener('click', function(event) {
	if (event.target.id != 'newsitem_read' && event.target.id != 'more') {
		if (event.target.className == 'newsitem unread-true') {
			news.child(event.target.id).update({unread: 'false'});
			updateNews();
			window.location.replace(event.target.title);
		}
		else {
			window.location.replace(event.target.title);
		}
	}
});

news.on('child_changed', function(childSnapshot, prevChildKey) {
	document.getElementById(childSnapshot.key()).className = 'newsitem unread-' + childSnapshot.val().unread;
});
<?php } ?>