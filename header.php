<?php

require 'session.php';

require 'lang/list.php';

$themes = array(
            1 => 'cerulean',
            2 => 'cosmo',
            3 => 'cyborg',
            4 => 'darkly',
            5 => 'flatly',
            6 => 'journal',
            7 => 'lumen',
            8 => 'paper',
            9 => 'readable',
            10 => 'sandstone',
            11 => 'simplex',
            12 => 'slate',
            13 => 'spacelab',
            14 => 'superhero',
            15 => 'united',
            16 => 'yeti'
            );

if (isset($_GET['theme']) && !is_numeric($_GET['theme'])) {
	$_SESSION['theme'] = $_GET['theme'];
	header('Location: index');
}

// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';

if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
	header('Location: index');
}

require 'lang/config.php';

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
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!--<a class="navbar-brand" href="{{ url('/') }}">Oboy Events</a>-->
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li id="logo"><a href="/">< ? ></a></li>
					</ul>
					<?php if (!isset($_SESSION['user'])): ?>
						<ul class="nav navbar-nav navbar-right">
							<form action="post/user/auth" method="post" id="login_form" class="navbar-form navbar-left">
					        	<div class="form-group">
					          		<input type="text" name="user" class="form-control" placeholder="Användarnamn/email" autofocus>
					        	</div>
					        	<div class="form-group">
					          		<input type="text" name="password" class="form-control" placeholder="Lösenord">
					        	</div>
					        	<input type="submit" class="btn btn-default" value="<?=$translate['Log_in']; ?>">
					      	</form>
							<li id="hide_register" class="dropdown">
								<a href="#" id="register" class="dropdown-toggle" data-toggle="dropdown"><?=$translate['Register']; ?></a>
								<ul id="register_area" class="dropdown-menu" role="menu" style="width: 300px;">
            						<form action="post/user/new" method="post">
            							<div class="col-lg-12">
									        <input type="text" name="user" class="form-control" placeholder="Användarnamn">
									    </div>
									    <div class="col-lg-12" style="margin-top: 10px; margin-bottom: 10px;">
									        <input type="text" name="email" class="form-control" placeholder="Email">
									    </div>
										<div class="col-lg-12" style="margin-bottom: 10px;">
									        <input type="password" name="password" id="password" class="form-control" placeholder="Lösenord" style="margin-bottom: 5px;">
									        <p class="text-warning">Minst 5 tecken</p>
									    </div>
									    <div id="password_repeat" class="col-lg-12" style="margin-bottom: 10px; display: none;">
									    	<h5>Repetera lösenord</h5>
									        <input type="password" name="password_repeat" class="form-control" placeholder="Lösenord">
									    </div>
									    <div class="col-lg-12 col-lg-offset-2">
									        <input type="submit" class="btn btn-primary" value="Registrera">
									    </div>
									</form>
            					</ul>
            				</li>
							<li class="dropdown">
          						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$translate['Language'] . ': ' . $current_lang; ?></a>
          						<ul class="dropdown-menu" role="menu">
            						<?php foreach ($languages as $code => $lang): ?>
            							<li><a href="index?lang=<?=$code; ?>"><?=$lang; ?></a></li>
            						<?php endforeach; ?>
            					</ul>
            				</li>
							<li class="dropdown">
          						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$translate['Change_theme']; ?></a>
          						<ul id="change_theme" class="dropdown-menu" role="menu">
            						<?php foreach ($themes as $code => $theme): ?>
            							<li><a href="index?theme=<?=$theme; ?>" id="<?=$theme; ?>"><?=ucfirst($theme); echo ($theme == $_SESSION['theme']) ? '<span class="ion-checkmark-circled" style="float: right;"></span>' : ''; ?></a></li>
            						<?php endforeach; ?>
            					</ul>
							<li><a href="/"><?=$translate['About']; ?></a></li>
						</ul>
					<?php else: ?>
						<ul class="nav navbar-nav navbar-right">
							<!-- Menu to display when logged in -->
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</nav>
		<div class="wrapper">