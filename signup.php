<?php

session_start();

require 'header.php';

?>

<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">
				<h3>Registrera</h3>
				<?php require 'form/show_errors.php'; ?>
				<form action="form/post/user/new" method="post" id="signup_form" class="form-horizontal login-register-form">
					<div class="form-group">
					    <div class="col-lg-4 col-lg-offset-4">
							<input type="text" name="user" <?=(isset($_SESSION['register']['user'])) ? "value=\"{$_SESSION['register']['user']}\"" : ''; ?> class="form-control" placeholder="Användarnamn">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-4 col-lg-offset-4">
							<input type="email" name="email" <?=(isset($_SESSION['register']['email'])) ? "value=\"{$_SESSION['register']['email']}\"" : ''; ?> class="form-control" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-4 col-lg-offset-4">
							<input type="password" name="password" <?=(isset($_SESSION['register']['password'])) ? "value=\"{$_SESSION['register']['password']}\"" : ''; ?> id="password" class="form-control" placeholder="Lösenord">
						</div>
					</div>
					<div class="form-group">
						<div id="password_repeat" class="col-lg-4 col-lg-offset-4">
							<input type="password" name="password_repeat" <?=(isset($_SESSION['register']['password_repeat'])) ? "value=\"{$_SESSION['register']['password_repeat']}\"" : ''; ?> class="form-control" placeholder="Repetera lösenord">
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-4 col-lg-offset-4">
							<button type="reset" class="btn btn-default">Cancel</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
				</form>
			</div> <!-- /col -->
		</div> <!-- /row -->
	
	</div>
</section>

<?php

if (isset($_SESSION['register'])) unset($_SESSION['register']);

require 'footer.php';

?>