<?php

session_start();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta description="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Great nonsens</title>
		<?php if (isset($_SESSION['theme'])): ?>
			<link id="theme" href="vendor/css/bootstrap.min.<?=$_SESSION['theme']; ?>.css" rel="stylesheet">
		<?php else: ?>
			<link href="vendor/css/bootstrap.min.superhero.css" rel="stylesheet">
		<?php endif; ?>
		<link href="vendor/css/ionicons.min.css" rel="stylesheet"></a>
		<link href="css/style.css" rel="stylesheet">
	</head>
	<body>
		<div class="container">
			<?php require 'post/show_errors.php'; ?>
			<form action="post/user/auth" method="post" id="signup_form" class="form-horizontal login-register-form">
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

<?php

require 'footer.php';

?>