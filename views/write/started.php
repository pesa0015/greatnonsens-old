<div id="my-turn">
<?php if ($on_turn[0]['user_id'] == $_SESSION['me']['id']): ?>
<form action="form/post/story/write" id="story-form" method="post">
	<div id="char-left"><span>50</span> tecken kvar</div>
	<textarea id="app" class="form-control" name="words" rows="5" cols="50" placeholder="Skriv något..."></textarea><br/>
	<input type="submit" name="send" id="send" class="btn btn-success" value="Skicka">
</form>
<?php else: ?>
	<div id="waiting">Väntar på <span id="waiting-on"><?=$on_turn[0]['username']; ?> <?=$on_turn[0]['user_id']; ?></span></div>
<?php endif; ?>
</div>