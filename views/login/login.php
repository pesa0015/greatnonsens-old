<h3>Logga in</h3>
			<?php require 'form/show_errors.php'; ?>
			<form action="form/post/user/auth" method="post" id="signup_form" class="form-horizontal login-register-form">
				<div class="form-group">
				    <input type="text" name="user" <?=(isset($_SESSION['login']['user'])) ? "value=\"{$_SESSION['login']['user']}\"" : ''; ?> class="form-control" placeholder="Användarnamn">
				</div>
				<div class="form-group">
					<input type="password" name="password" <?=(isset($_SESSION['login']['password'])) ? "value=\"{$_SESSION['login']['password']}\"" : ''; ?> id="password" class="form-control" placeholder="Lösenord">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="Logga in">
					<a href="login/forgot_password" class="btn btn-primary">Glömt lösenord</a>
				</div>
			</form>