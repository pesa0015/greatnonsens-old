<?php
$user = sqlSelect("SELECT username FROM users WHERE email = '{$email}';");
?>
<h1>Återställ lösenord för <?=$user[0]['username']; ?></h1>
<div>Ange nytt lösenord:</div>
<form action="" method="post" onsubmit="resetPassword(event);">
	<input type="hidden" id="email" value="<?=$email; ?>">
	<input type="hidden" id="token" value="<?=$token; ?>">
	<div class="form-group">
		<input type="text" id="new_password" class="form-control" placeholder="Lösenord">
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-success" value="Skicka">
	</div>
</form>
<div id="success"></div>