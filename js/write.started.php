<?php

session_start();

// $guest_id = (!$_SESSION['guest_id']) ? 0 : $_SESSION['guest_id'];

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
	$("#spin").center();       // this will make it center when
});

var opts = {
  lines: 17 // The number of lines to draw
, length: 35 // The length of each line
, width: 2 // The line thickness
, radius: 84 // The radius of the inner circle
, scale: 1 // Scales overall size of the spinner
, corners: 1 // Corner roundness (0..1)
, color: '#000' // #rgb or #rrggbb or array of colors
, opacity: 0.10 // Opacity of the lines
, rotate: 0 // The rotation offset
, direction: 1 // 1: clockwise, -1: counterclockwise
, speed: 1 // Rounds per second
, trail: 50 // Afterglow percentage
, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
, zIndex: 2e9 // The z-index (defaults to 2000000000)
, className: 'spinner' // The CSS class to assign to the spinner
, top: '50%' // Top position relative to parent
, left: '50%' // Left position relative to parent
, shadow: false // Whether to render a shadow
, hwaccel: false // Whether to use hardware acceleration
, position: 'absolute' // Element positioning
}
var target = document.getElementById('spin');
var spinner = new Spinner(opts).spin(target);

var started = greatnonsens.child('stories/started/<?=$_GET['story']; ?>/');

var finished = greatnonsens.child('stories/finished/<?=$_GET['story']; ?>/');

started.on('value', function(snapshot) {
	$('#spin').remove();
	if (snapshot.val().on_turn.user_id === <?=$_SESSION['me']['id']; ?>) {
		$('#content').append('<div id="write"></div>');
		$('#write').load('views/write/my_turn.php?story=<?=$_GET['story']; ?>');
	}
	else {
		$('#write').remove();
		$('#content').append('<div id="wait"></div>');
		
			//if (document.contains(document.getElementById('wait')))
			//	$('#wait').replaceWith('<h1 id="wait">Väntar på ' + snapshot.val().on_turn.user.user_name + '</h1>');
			//else
			//	$('#wait').append('<h1 id="wait">Väntar på ' + snapshot.val().on_turn.user.user_name + '</h1>');
			if (snapshot.val().on_turn.user_name == 'Guest')
				$('#wait').html('<h1>Väntar på ' + snapshot.val().on_turn.user_name + '' + snapshot.val().on_turn.user_id + '</h1>');
			else
				$('#wait').html('<h1>Väntar på ' + snapshot.val().on_turn.user.user_name + '</h1>');
	}
});

started.on('child_changed', function(childSnapshot, prevChildKey) {
	if (childSnapshot.val().user_id === <?=$_SESSION['me']['id']; ?>) {
		$('#wait').remove();
		if (!document.contains(document.getElementById('write')))
			$('#content').append('<div id="write"></div>');
		$('#write').load('views/write/my_turn.php?story=<?=$_GET['story']; ?>');
	}
	else {
		$('#write').remove();
		if (snapshot.val().on_turn.user_name == 'Guest')
			$('#wait').html('<h1>Väntar på ' + snapshot.val().on_turn.user_name + '' + snapshot.val().on_turn.user_id + '</h1>');
		else
			$('#wait').html('<h1>Väntar på ' + snapshot.val().on_turn.user.user_name + '</h1>');
	}
});

finished.on('value', function(snapshot) {
	if (snapshot.exists()) {
		$('#spin').remove();
		$('#write').remove();
		$('#wait').remove();
		$('#content').append('<div id="read"></div>');
		$('#read').append('<h1>Berättelsen är färdig</h1><a href="read.php?story=<?=$_GET['story']; ?>" class="btn btn-success">Läs den</a>');
	}
});