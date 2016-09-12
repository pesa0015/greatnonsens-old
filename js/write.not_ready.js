var story = firebase.database().ref('stories/not_ready/' + storyId);

var numWriters = document.getElementById('writers');
story.on('child_changed', function(childSnapshot) {
	numWriters.innerHTML = childSnapshot.val();
});