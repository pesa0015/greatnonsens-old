<?php
session_start();
require 'layout/header.php';
?>
<h3 id="hide-if-registered">Registrera</h3>
				<form action="" method="post" id="signup_form" class="form-horizontal login-register-form" onsubmit="register(event);">
					<div class="form-group">
					    <input type="text" name="user" id="user" class="form-control" placeholder="Användarnamn">
					    <div id="error-user" class="input-error"></div>
					</div>
					<div class="form-group">
						<input type="email" name="email" id="email" class="form-control" placeholder="Email">
						<div id="error-email" class="input-error"></div>
					</div>
					<div class="form-group">
						<input type="password" name="password" id="password" class="form-control" placeholder="Lösenord">
						<div id="error-password" class="input-error"></div>
					</div>
					<div class="form-group">
						<input type="password" name="password_repeat" id="password_repeat" class="form-control" placeholder="Repetera lösenord">
						<div id="error-password_repeat" class="input-error"></div>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-success" value="Registrera">
					</div>
				</form>
				<div id="success"></div>
<?php $script = 'js/register.js';require 'footer.php'; ?>