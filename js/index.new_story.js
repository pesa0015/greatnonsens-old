mdOverlay = document.getElementsByClassName('md-overlay')[0];
function manageModal(modal, btn = false) {
	md = document.getElementById(modal);
	md.className += ' md-show';
	mdOverlay.style.visibility = 'visible';
	if (btn) {
		$('.md-overlay, .md-close').click(function(){
			md.className = 'md-modal md-effect-1';
			mdOverlay.style.visibility = 'hidden';
		});
		return true;
	}
	mdOverlay.onclick = function() {
		md.className = 'md-modal md-effect-1';
		mdOverlay.style.visibility = 'hidden';
	}
}
document.getElementById('choose-story').onclick = function() {
	manageModal('chooseStoryModal', true);
}
document.getElementById('new-story').onclick = function() {
	manageModal('createStoryModal', true);
}

var openingWords = document.getElementById('opening-words');
var displayCharLimit = document.getElementById('char-left').firstChild;
openingWords.addEventListener('input', function() {
	var maxLength = 50;
	var inputLength = this.value.length;
	var charLeft = maxLength - inputLength;
	displayCharLimit.innerHTML = charLeft;
});

var createStoryForm = document.getElementById('create-story');
createStoryForm.addEventListener('submit', function() {
	event.preventDefault();
	var input = [
	document.getElementById('title'),
	document.getElementById('opening-words'),
	document.getElementById('rounds'),
	document.querySelector('input[name="nonsensmode"]:checked'),
	document.getElementById('num-of-writers'),
	document.querySelector('input[name="public"]:checked')];
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	console.log(xhttp.responseText);
	    	var story = JSON.parse(xhttp.responseText).story_id;
	    	var newStory = firebase.database().ref('stories/not_ready/' + story);
	    	newStory.set({'writers': 1, 'waiting': true});
	    	window.location.replace('write?story=' + story);
	    }
	}
	xhttp.open('POST', 'form/post/story/new', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('title=' + input[0].value + '&text=' + input[1].value + '&rounds=' + input[2].value + '&nonsensmode=' + input[3].value + '&num_of_writers=' + input[4].value + '&public=' + input[5].value);
});

// $('#hide').css('display', 'none');
var tableContent = $('tbody');
function getStories() {
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	if (xhttp.responseText === '')
	    		return;
	    	console.log(xhttp.responseText);
	    	var stories = JSON.parse(xhttp.responseText);
	    	if (stories.length > 0) {
	    		$(tableContent).empty();
	    		var nonsensmode = null;
	    		for (var i = 0; i < stories.length; i++) {
	    			nonsensmode = (stories[i].nonsens_mode) ? 'Ja' : 'Nej';
	    			$(tableContent).append('<tr id="story-' + stories[i].id + '" data-story="' + stories[i].id + '"><td>' + stories[i].title + '</td><td>' + stories[i].opening_words + '</td><td>' + nonsensmode + '</td><td id="writers-' + stories[i].id + '">' + stories[i].max_writers + '/<span class="num-of-writers">' + stories[i].num_of_writers + '</span></td><td><button onClick="joinStory(this);">Gå med</button></td></tr>');
	    		}
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/story/get', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send();
}

setInterval(function(){getStories();},5000);
getStories();

function joinStory(e) {
	var storyId = e.parentNode.parentNode.getAttribute('data-story');
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var status = parseInt(xhttp.responseText);
	    	if (status != 1 && status != 2) {
	    		console.log(xhttp.responseText);
	    		return;
	    	}
	    	// Max writers reached, story started
	    	if (status == 2) {
	    		var not_ready = firebase.database().ref('stories/not_ready/' + storyId);
				not_ready.remove();
	    	}
	    	if (status == 1) {
	    		var writers = firebase.database().ref('stories/not_ready/' + storyId);
	    		writers.once('value', function(dataSnapshot) {
	    			writers.update({'writers': dataSnapshot.val().writers+1});
	    		});
	    		keepTheWritersUpdated();
	    	}
	    	window.location.replace('write?story=' + storyId);
	    }
	}
	xhttp.open('POST', 'form/post/story/join', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + storyId);
}

var stories = firebase.database().ref('stories/not_ready/');

stories.on('child_changed', function(childSnapshot, prevChildKey) {
	$('#writers-' + childSnapshot.key()).find('.num-of-writers').text(childSnapshot.val().writers);
});

stories.on('child_removed', function(oldChildSnapshot) {
	document.getElementById('#story-' + oldChildSnapshot.key()).className += ' started';
});