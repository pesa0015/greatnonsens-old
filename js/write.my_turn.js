document.getElementById('send').onclick = function() {
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	keepTheWritersUpdated(storyId);
	    }
	}
	xhttp.open('POST', 'form/post/story/write', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('words=' + document.getElementById('app').value);
}