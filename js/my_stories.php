<?php

session_start();

header('Content-Type: application/javascript');

?>
var my_turn = greatnonsens.child('users/<?=$_SESSION['me']['id']; ?>/my_turn/');
var finished = greatnonsens.child('users/<?=$_SESSION['me']['id']; ?>/finished_stories/');

my_turn.on('child_added', function(snapshot) {

	i++;

	localStorage.my_turn++;
	num_of_news.innerHTML = localStorage.my_turn;

	$('#my-turn-table-body').append('<tr><td class="my-story"><a href="write?story=' + snapshot.key() + '">' + snapshot.val().title + '</a></td></tr>');
	
});

finished.on('child_added', function(snapshot) {

	i++;

	localStorage.finished++;
	num_of_news.innerHTML = localStorage.finished;

	$('#finished-table-body').append('<tr><td class="my-story"><a href="read?story=' + snapshot.key() + '">' + snapshot.val().title + '</a></td></tr>');
	
});

my_turn.on('child_removed', function(oldChildSnapshot) {

	i--;

	localStorage.my_turn--;
	num_of_news.innerHTML = localStorage.my_turn;
	
});

finished.on('child_removed', function(oldChildSnapshot) {

	i++;

	localStorage.finished--;
	num_of_news.innerHTML = localStorage.finished;
	
});
// var show = document.getElementById('show-my-stories');

// show.addEventListener('mouseover', function() { 
// 	document.getElementById('my-stories-table').style.display = 'block'; 
// });

// document.getElementById('head').addEventListener('mouseover', function() { 
// 	document.getElementById('my-stories-table').style.display = 'none'; 
// });