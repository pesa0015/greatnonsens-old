var xhttp = new XMLHttpRequest();
function getParameterByName(name, url) {
	// If url = write/{$id}
	// window.location.href.split('/').pop()
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
function getStoryId() {
	return parseInt(window.location.href.split('/')[4]);
}
function getGroupId() {
	return parseInt(window.location.href.split('/')[4]);
}
function sendXhttp(callback, file, param, data) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	// console.log(xhttp.responseText);
	    	callback(xhttp.responseText, data);
	    }
	}
	xhttp.open('POST', file, true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send(param);
}
function manageNews(list, news_item) {
	list.list.innerHTML = news_item;
	list.counter.innerHTML++;
	if (list.counter.className !== 'nr-show')
		list.counter.className = 'nr-show';
}
function readNewsFeed(news_feed, redirect) {
	var xhttp = new XMLHttpRequest();
	var page = redirect || false;
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	// console.log(xhttp.responseText);
	    	if (xhttp.responseText === 'have_read') {
	    		if (page !== false) window.location.replace(page);
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/user/read_news_feed', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('news_id=' + news_feed);
}
var listRead = {list: document.getElementById('header-read'), counter: document.getElementById('nr-read')};
var listWrite = {list: document.getElementById('header-write'), counter: document.getElementById('nr-write')};
var listNews = {list: document.getElementById('header-news'), counter: document.getElementById('nr-news')};
function checkNewsFeed(type, markAsRead) {
	var xhttp = new XMLHttpRequest();
	var read = markAsRead || false;
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	// console.log(xhttp.responseText);
	    	if (xhttp.responseText === 'no news')
	    		return;
	    	var result = JSON.parse(xhttp.responseText);
	    	if (read === true) readNewsFeed(result[0].id);
	    	else {
	    		console.log(1);
	    		var page = ''; 
	    		if (result[0].group_name)
	    			page = 'groups';
	    		if (result[0].username)
	    			page = 'users';
	    		var title = result[0].group_name || result[0].title || result[0].username;
	    		var pageId = result[0].group_id || result[0].story_id || result[0].user_id;
	    		var text = '';
	    		var ul_list = '';
	    		switch(type) {
	    			case 'my_turn':
	    				page = 'write';
	    				text = 'Min tur';
	    				ul_list = listWrite;
	    				break;
	    			case 'story_began':
	    				page = 'write';
	    				text = 'Storyn har börjat';
	    				ul_list = listWrite;
	    				break;
	    			case 'story_finished':
	    				page = 'read';
	    				text = 'Storyn är färdig';
	    				ul_list = listNews;
	    				break;
	    			default: break;
	    		}
	    		var html = '<li onclick="readNewsFeed(' + result[0].id + ', \'' + page + '/' + pageId + '\');">'
	    					+ '<div class="title">' + title
	    					+ '</div>'
	    					+ '<div class="news-type">' + text
	    					+ '</div>'
	    					+ '</li>';
	    		manageNews(ul_list, html);
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/user/check_news_feed', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('news_type=' + type);
}
function changeJsFile(src) {
	var ref = document.getElementById('new-script'),
    script = document.createElement('script');
  	script.setAttribute('type', 'text/javascript');
  	script.setAttribute('src',  src);
  	script.setAttribute('id',   'page-js');
  	ref.parentNode.insertBefore(script, ref);
}
function joinedGroup(response, data) {
	var result = JSON.parse(response);
	if (result.success) {
		var page = window.location.href.split('/')[5];
		if (page === 'news') {
			window.location.reload();
		}
		else {
			window.location.replace('groups/' + data.group_Id + '/news');
		}
	}
}
function joinGroup() {
	var groupId = parseInt(window.location.href.split('/')[4]);
	sendXhttp(joinedGroup, 'form/post/group/join', 'groupId=' + groupId, {group_Id: groupId});
}
function keepTheWritersUpdated(story, value) {
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var writers = JSON.parse(xhttp.responseText);
	    	for (var i = 0; i < writers.length; i++) {
	    		if (writers[i].user_id != me) {
	    			var writer = firebase.database().ref('users/' + writers[i].user_id);
					writer.update(value);
				}
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/writers/get', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + story);	
}
var textOnPage = document.getElementById('text');
function getStory(story) {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var story = JSON.parse(xhttp.responseText);
	    	if (story.status === 'my turn') {
	    		textOnPage.innerHTML = story.words[0].words;
	    		$('#my-turn').load('views/write/my_turn.php', {'username': story.words[0].username}, function() {
	    			changeJsFile('js/write.my_turn.js');
	    		});
	    		$('#page-js').remove();
	    	}
	    	else {
	    		$('#my-turn').load('views/write/wait.php', {'username': story.on_turn[0].username + ' ' + story.on_turn[0].user_id});
	    	}
	    }
	}
	xhttp.open('POST', 'form/post/story/words', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + story);
}
function beginStory(json, story) {
	var writers = JSON.parse(json);
	for (var i = 0; i < writers.length; i++) {
	    var writer = firebase.database().ref('users/' + writers[i].user_id);
		writer.update({story_began: story.id});
	}
}
var storyId = (document.contains(document.getElementById('story-id'))) ? document.getElementById('story-id').getAttribute('data-story') : 0;
function joinStory(e, modal) {
	if (e !== false)
		storyId = e.parentNode.parentNode.getAttribute('data-story');
	xhttp.onreadystatechange = function() {
	    if (xhttp.readyState == 4 && xhttp.status == 200) {
	    	var status = parseInt(xhttp.responseText);
	    	if (status != 1 && status != 2) {
	    		// console.log(xhttp.responseText);
	    		return;
	    	}
	    	// Max writers reached, story started
	    	if (status == 2) {
	    		var not_ready = firebase.database().ref('stories/not_ready/' + storyId);
				not_ready.remove();
				if (modal) {
					document.getElementById('join-story-with-link-modal').className = 'md-modal md-effect-1';
					storyHasBegan(storyId);
					// return;
				}
				sendXhttp(beginStory, 'form/post/writers/get', 'story=' + storyId, {id: storyId});
	    	}
	    	if (status == 1) {
	    		var writers = firebase.database().ref('stories/not_ready/' + storyId);
	    		writers.once('value', function(dataSnapshot) {
	    			writers.update({'writers': dataSnapshot.val().writers+1});
	    		});
	    		if (modal) {
	    			document.getElementById('join-story-with-link-modal').className = 'md-modal md-effect-1';
	    			// return;
	    		}
	    	}
	    	if (!modal) window.location.replace('write/' + storyId);
	    }
	}
	xhttp.open('POST', 'form/post/story/join', true);
	xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhttp.send('story=' + storyId);
}
// console.log(storyId);
function onTurn(story) {
	if (story == storyId) {
		checkNewsFeed('my_turn', true);
		getStory(storyId);
		return;
	}
	checkNewsFeed('my_turn', false);
	// var xhttp = new XMLHttpRequest();
	// xhttp.onreadystatechange = function() {
	//     if (xhttp.readyState == 4 && xhttp.status == 200) {
	//     	var stories = JSON.parse(xhttp.responseText);
	//     	var current;
	//     	for (var i = 0; i < stories.length; i++) {
	//     		if (stories[i].story_id != storyId && stories[i].status == 1 && stories[i].on_turn == 1) {
	//     			// Update on-turn-icon
	//     		}
	//     		if (stories[i].story_id == storyId && stories[i].status == 2) {
	//     			// Story finished
	//     			console.log('story finished');
	//     		}
	//     	}
	//     }
	// }
	// xhttp.open('POST', 'form/post/story/get', true);
	// xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	// xhttp.send();
}
function showForm(status, data) {
	var response = JSON.parse(status);
	if (parseInt(response.my_turn) == 1) {
		$('#page-js').remove();
		$('#my-turn').load('views/write/my_turn.php', null, function() {
			changeJsFile('js/write.my_turn.js');
		});
	}
	else {
		$('#my-turn').prepend('<div>Väntar på ' + response.on_turn[0].username + ' ' + response.on_turn[0].user_id + '</div>');
	}
}
function storyFinished(story) {
	if (story == storyId) {
		checkNewsFeed('story_finished', true);
		$('#waiting').remove();
		$('#my-turn').prepend('<div>Berättelsen är färdig!</div><div><a href="read/' + story + '" class="btn btn-success">Läs den!</a></div>');
	}
	else checkNewsFeed('story_finished', false);
}
function storyHasBegan(story) {
	if (parseInt(story) == parseInt(storyId)) {
		$('#status').remove();
		sendXhttp(showForm, 'form/post/story/check_turn', 'story=' + storyId, null);
		checkNewsFeed('story_began', true);
	}
	else checkNewsFeed('story_began', false);
}
var user = firebase.database().ref('users/' + me);
user.on('child_changed', function(childSnapshot) {
	if (!childSnapshot.val())
		return;
	var changed = childSnapshot.getKey();
	var value = childSnapshot.val();
	if (changed === 'news') {
		user.update({'news': false});
	}
	if (changed === 'on_turn') {
		user.update({'on_turn': false});
		onTurn(value);
	}
	if (changed === 'story_began') {
		user.update({'story_began': false});
		storyHasBegan(value);
	}
	if (changed === 'story_finish') {
		user.update({'story_finish': false});
		storyFinished(value);
	}
});
if (document.contains(document.getElementById('close-cookie-info'))) {
	var closeCookieInfo = document.getElementById('close-cookie-info');
	closeCookieInfo.onclick = function() {
		Cookies.set('cookie_information', 0);
		$('#login-signup-cookies-area').slideUp();
	}
	closeCookieInfo.onmouseover = function() {
		closeCookieInfo.className = 'ion-ios-close';	
	}
	closeCookieInfo.onmouseout = function() {
		closeCookieInfo.className = 'ion-ios-close-outline';
	}
}