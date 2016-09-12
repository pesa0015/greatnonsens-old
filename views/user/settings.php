<h2>Ändra beskrivning</h2>
<form action="" method="post" onsubmit="update(event, 'description');">
	<textarea id="description"><?=$info[0]['personal_text']; ?></textarea>
	<input type="submit" class="btn btn-success" value="Spara">
</form>
<div id="success-description" class="success"><img src="assets/images/smileys/joy.png" alt=""><span class="success_text">Beskrivningen har uppdaterats</span><span class="remove-result-box" onclick="$(this).parent().fadeOut(500);">Stäng</span></div>
<hr />
<h2>Ändra email</h2>
<form action="" method="post" onsubmit="update(event, 'email');">
	<input type="email" id="email" value="<?=$info[0]['email']; ?>" placeholder="Email">
	<input type="password" id="email-confirm-password" placeholder="Ange lösenord">
	<input type="submit" class="btn btn-success" value="Spara">
</form>
<div id="success-email" class="success"><img src="assets/images/smileys/joy.png" alt=""><span class="success_text">Din e-mailadress har uppdaterats</span><span class="remove-result-box" onclick="$(this).parent().fadeOut(500);">Stäng</span></div>
<hr />
<h2>Ändra lösenord</h2>
<form action="" method="post" onsubmit="update(event, 'password');">
	<input type="password" id="password" placeholder="Nuvarande lösenord">
	<input type="password" id="new-password" placeholder="Nytt lösenord">
	<input type="password" id="password-confirm-password" placeholder="Upprepa nytt lösenord">
	<input type="submit" class="btn btn-success" value="Spara">
</form>
<div id="success-password" class="success"><img src="assets/images/smileys/joy.png" alt=""><span class="success_text">Lösenordet har uppdaterats</span><span class="remove-result-box" onclick="$(this).parent().fadeOut(500);">Stäng</span></div>