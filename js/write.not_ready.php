<?php

session_start();

header('Content-Type: application/javascript');

?>
$.fn.center = function () {
	this.css("position","absolute");
	this.css("top", ( $(window).height() - this.height() ) / 2  + "px");
	this.css("left", ( $(window).width() - this.width() ) / 2 + "px");
	return this;
}
$('#content').center();

$(window).resize(function(){ // whatever the screen size this
	$("#content").center();       // this will make it center when
});

var story = greatnonsens.child('stories/not_ready/<?=$_GET['story']; ?>/');

var started = greatnonsens.child('stories/started/<?=$_GET['story']; ?>/');

var start = greatnonsens.child('stories/started/');

var begin = false;  

story.on('value', function(snapshot) {
document.getElementById('writers').innerHTML = snapshot.val().writers;

	<?php if (isset($_GET['started_by']) && $_GET['started_by'] == $_SESSION['me']['id']): ?>
	if (snapshot.val().writers >= 3 && !begin) {
		$('#content').append('<a href="form/get/story/start?story=<?=$_GET['story']; ?>" id="begin" class="btn btn-default btn-lg" style="float: right;">Börja</a>');
		begin = true;
	}
	else {
		$('#begin').remove();
		begin = false;
	}
	<?php endif; ?>
	if (snapshot.val().on_turn && !document.contains(document.getElementById('on_turn'))) {
		
			if (snapshot.val().on_turn.user_id == <?=$_SESSION['me']['id']; ?>) {
				if (snapshot.val().on_turn.user_name == 'Guest')
					$('#content').append('<h3 id="on_turn">Jag (' + snapshot.val().on_turn.user_name + '' + snapshot.val().on_turn.user_id + ') fortsätter berättelsen</h3>');
				else
					$('#content').append('<h3 id="on_turn">Jag (' + snapshot.val().on_turn.user_name + ') fortsätter berättelsen</h3>');
			}
			else {
				if (snapshot.val().on_turn.user_name == 'Guest')
					$('#content').append('<h3 id="on_turn">' + snapshot.val().on_turn.user_name + '' + snapshot.val().on_turn.user_id + ' fortsätter berättelsen</h3>');
				else
					$('#content').append('<h3 id="on_turn">' + snapshot.val().on_turn.user_name + ' fortsätter berättelsen</h3>');
			}
	}
	else {
		if (document.contains(document.getElementById('on_turn')))
			$('#on_turn').remove();
	}
	if (snapshot.val().writers >= <?=$_GET['max_writers']; ?>) {
		start.set({<?=$_GET['story']; ?>: {'title': snapshot.val().title, 'on_turn': snapshot.val().on_turn, 'latest_words': snapshot.val().opening_words, 'total_rounds': 5, 'current_round': 1, 'nonsens_mode': snapshot.val().nonsens_mode}});
	}
});

story.on('child_changed', function(childSnapshot, prevChildKey) {
	if (childSnapshot.val().on_turn && !document.contains(document.getElementById('on_turn'))) {
		if (snapshot.val().on_turn.user_id == <?=$_SESSION['me']['id']; ?>) {
			if (snapshot.val().on_turn.user_name == 'Guest')
				$('#content').append('<h3 id="on_turn">Jag (' + snapshot.val().on_turn.user_name + '' + snapshot.val().on_turn.user_id + ') fortsätter berättelsen</h3>');
			else
				$('#content').append('<h3 id="on_turn">Jag (' + snapshot.val().on_turn.user_name + ') fortsätter berättelsen</h3>');
		}
		else {
			if (snapshot.val().on_turn.user_name == 'Guest')
				$('#content').append('<h3 id="on_turn">' + snapshot.val().on_turn.user_name + '' + snapshot.val().on_turn.user_id + ' fortsätter berättelsen</h3>');
			else
				$('#content').append('<h3 id="on_turn">' + snapshot.val().on_turn.user_name + ' fortsätter berättelsen</h3>');
		}
	}
	else {
		if (document.contains(document.getElementById('on_turn')))
			$('#on_turn').remove();
	}
});

story.on('child_removed', function(oldChildSnapshot) {
	if (oldChildSnapshot.key() == <?=$_GET['story']; ?>) {
		$('#alright').css('display', 'none');
		$('#cancelled').css('display', 'block');
	}
});

started.on('value', function(snapshot) {
	if (snapshot.exists()) {
		story.remove();
		window.location.replace('write?story=' + snapshot.key());
	}
});