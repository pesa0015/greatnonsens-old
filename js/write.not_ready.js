var story = firebase.database().ref('stories/not_ready/' + storyId);
var numWriters = document.getElementById('writers');
var alright = document.getElementById('alright');
var startedByMe = document.contains(document.getElementById('story_started_by_me'));
story.on('child_changed', function(childSnapshot) {
	numWriters.innerHTML = childSnapshot.val();
	if (childSnapshot.val() > 2 && startedByMe) {
		$(alright).prepend('<span id="begin" class="btn btn-default btn-lg" style="float: right;" onclick="startStory();">Börja</span>');
	}
});
function startedStory(response, data) {
	var result = JSON.parse(response);
	if (result.success) {
		var not_ready = firebase.database().ref('stories/not_ready/' + result.story_id);
		not_ready.remove();
		sendXhttp(beginStory, 'form/post/writers/get', 'story=' + result.story_id, {id: result.story_id});
		storyHasBegan(result.story_id);
	}
}
function startStory() {
	sendXhttp(startedStory, 'form/post/story/start', 'story=' + getStoryId(), null);
}
function deletedStory(response, data) {
	var result = JSON.parse(response);
	if (result.success) {
		if (result.writers.length > 0) {
			for (var i = 0; i < result.writers.length; i++) {
	    		var writer = firebase.database().ref('users/' + result.writers[i].user_id);
				writer.update({story_deleted: result.story_id});
	    	}
		}
		else window.location.reload();
	}
}
function deleteStory() {
	sendXhttp(deletedStory, 'form/post/story/delete', 'story=' + getStoryId(), null);
}
function leavedStory(response, data) {
	var result = JSON.parse(response);
	if (result.success) {
		var writers = firebase.database().ref('stories/not_ready/' + result.story_id);
		writers.once('value', function(dataSnapshot) {
			writers.update({'writers': dataSnapshot.val().writers-1});
		});
		window.location.replace('/');
	}
}
function leaveStory() {
	sendXhttp(leavedStory, 'form/post/story/leave', 'story=' + getStoryId(), null);
}
