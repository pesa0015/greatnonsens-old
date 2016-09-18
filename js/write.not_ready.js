function startedStory(response, data) {
	var result = JSON.parse(response);
	if (result.success) storyHasBegan(result.story_id);
}
function startStory() {
	sendXhttp(startedStory, 'form/post/story/start', 'story=' + getStoryId(), null);
}
function deletedStory(response, data) {
	var result = JSON.parse(response);
	if (result.success) window.location.reload();
}
function deleteStory() {
	sendXhttp(deletedStory, 'form/post/story/delete', 'story=' + getStoryId(), null);
}
function leavedStory(response, data) {
	var result = JSON.parse(response);
	if (result.success) window.location.replace('/');
}
function leaveStory() {
	sendXhttp(leavedStory, 'form/post/story/leave', 'story=' + getStoryId(), null);
}
