<h1 id="story-title"><?=$_POST['title']; ?></h1>
<p id="text"><?=$_POST['text']; ?></p>
<form action="form/post/story/write" method="post">
	<textarea id="app" class="form-control" name="words" rows="5" cols="50" placeholder="Skriv något..."></textarea><br/>
	<input type="submit" name="send" class="btn btn-success" value="Skicka">
</form>