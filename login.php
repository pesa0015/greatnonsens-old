<?php

session_start();

require 'header.php';

?>

<section class="section" id="head">
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 text-center">
				<h3>Logga in</h3>
			<?php require 'form/show_errors.php'; ?>
			<form action="form/post/user/auth" method="post" id="signup_form" class="form-horizontal login-register-form">
				<div class="form-group">
				    <div class="col-lg-4 col-lg-offset-4">
						<input type="text" name="user" <?=(isset($_SESSION['login']['user'])) ? "value=\"{$_SESSION['login']['user']}\"" : ''; ?> class="form-control" placeholder="Användarnamn">
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-4 col-lg-offset-4">
						<input type="password" name="password" <?=(isset($_SESSION['login']['password'])) ? "value=\"{$_SESSION['login']['password']}\"" : ''; ?> id="password" class="form-control" placeholder="Lösenord">
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

if (isset($_SESSION['login'])) unset($_SESSION['login']);

require 'footer.php';

?>