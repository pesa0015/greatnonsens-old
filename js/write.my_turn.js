var text = document.getElementById('app');
document.getElementById('send').onclick = function(e) {
	e.preventDefault();
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	console.log(xhttp.responseText);
	    	var response = JSON.parse(xhttp.responseText);
	    	if (!response.success)
	    		return;
	    	$('#story-form').remove();
	    	if (nonsens_mode)
	    		textOnPage.innerHTML = text.value;
	    	else
	    		textOnPage.innerHTML += text.value;
	    	if (response.status === 'story is finished') {
	    		$('#my-turn').prepend('<div>Berättelsen är färdig!</div><div><a href="read/' + response.story + '" class="btn btn-success">Läs den!</a></div>');
	    		keepTheWritersUpdated(response.story, {story_finish: response.story});
	    	}
	    	else {
	    		$('#my-turn').load('views/write/wait.php', {'username': response.on_turn[0].username + ' ' + response.on_turn[0].user_id});
	    		$('#page-js').remove();
	    		keepTheWritersUpdated(response.story, {on_turn: response.story});
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/story/write', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + getStoryId() + '&words=' + text.value);
}
var displayCharLimit = document.getElementById('char-left').firstChild;
text.addEventListener('input', function() {
	var maxLength = 50;
	var inputLength = this.value.length;
	var charLeft = maxLength - inputLength;
	displayCharLimit.innerHTML = charLeft;
});