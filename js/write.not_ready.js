// $.getScript('js/my_stories.js');
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

/*

var myId = document.getElementById('me').value;
story.on('child_changed', function(childSnapshot, prevChildKey) {
	if (childSnapshot.val().on_turn && !document.contains(document.getElementById('on_turn'))) {
		if (snapshot.val().on_turn.user_id == myId) {
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

*/

var story = firebase.database().ref('stories/not_ready/' + storyId);

story.on('child_removed', function(oldChildSnapshot) {
	// if (oldChildSnapshot.key() == storyId) {
	// 	$('#alright').css('display', 'none');
	// 	$('#cancelled').css('display', 'block');
	// }
	$('#content').remove();
	myTurn();
});

// started.on('value', function(snapshot) {
// 	if (snapshot.exists()) {
// 		window.location.reload();
// 	}
// });