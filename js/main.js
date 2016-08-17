var xhttp = new XMLHttpRequest();
function keepTheWritersUpdated(story) {
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var writers = JSON.parse(xhttp.responseText);
	    	for (var i = 0; i < writers.length; i++) {
	    		var writer = firebase.database().ref('users/' + writers[i].user_id);
				writer.update({on_turn: true});
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/writers/get', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + story);	
}
function getStory(story, my_turn) {
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var story = JSON.parse(xhttp.responseText)[0];
	    	var itsMyTurn = (my_turn == 1) ? 1 : 0;
	    	$('#content').load('started.php', {'title': story.title, 'text': story.words, 'my_turn': itsMyTurn});
	    	document.getElementById('page-js').src = 'js/write.my_turn.js';
	    }
	}
	xhttp.open('POST', 'form/post/story/words', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + story + '&turn=' + my_turn);
}
var storyId = (document.contains(document.getElementById('story-id'))) ? document.getElementById('story-id').getAttribute('data-story') : 0;
function myTurn() {
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var stories = JSON.parse(xhttp.responseText);
	    	var current;
	    	for (var i = 0; i < stories.length; i++) {
	    		if (stories[i].story_id != storyId && stories[i].status == 1 && stories[i].on_turn == 1) {
	    			// Update on-turn-icon
	    		}
	    		if (stories[i].story_id == storyId && stories[i].status == 1) {
	    			// Load the new words and form
	    			getStory(storyId, stories[i].on_turn);
	    		}
	    		if (stories[i].story_id == storyId && stories[i].status == 0) {
	    			// Update not-ready-page
	    			var xhttp = new XMLHttpRequest();
	    			xhttp.onreadystatechange = function() {
					    if (xhttp.readyState == 4 && xhttp.status == 200) {
					    	var writers = JSON.parse(xhttp.responseText);
					    	document.getElementById('writers').innerHTML = writers.length;
					    }
					}
					xhttp.open('POST', 'form/post/writers/get', true);
					xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					xhttp.send('story=' + storyId);
	    		}
	    		if (stories[i].story_id == storyId && stories[i].status == 2) {
	    			// Story finished
	    			console.log('story finished');
	    		}
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/story/get', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send();
}
var user = firebase.database().ref('users/' + me);
user.on('child_changed', function(childSnapshot) {
	if (!childSnapshot.val())
		return;
	var changed = childSnapshot.getKey();
	if (changed === 'news') {
		
	}
	if (changed === 'on_turn') {
		myTurn();
	}
});