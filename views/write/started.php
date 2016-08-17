<div id="content">
	<h1 id="story-title"><?=$_POST['title']; ?></h1>
	<p id="text"><?=$_POST['text']; ?></p>
	<?php if ($_POST['my_turn'] == 1): ?>
	<form action="form/post/story/write" id="story-form" method="post">
		<textarea id="app" class="form-control" name="words" rows="5" cols="50" placeholder="Skriv något..."></textarea><br/>
		<input type="submit" name="send" id="send" class="btn btn-success" value="Skicka">
	</form>
	<?php endif; ?>
</div>