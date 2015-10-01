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
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$translate['Log_in']; ?></a>
								<ul class="dropdown-menu" role="menu">
            						<form action="login" method="post" class="form-horizontal">
            							<div class="form-group">
									      	<label for="inputEmail" class="col-lg-2 control-label">Email</label>
									      		<div class="col-lg-10">
									        		<input type="text" class="form-control" id="inputEmail" placeholder="Email">
									      		</div>
									    </div>
            							<div class="form-group">
									      	<label for="inputEmail" class="col-lg-2 control-label">Email</label>
									      		<div class="col-lg-10">
									        		<input type="text" class="form-control" id="inputEmail" placeholder="Email">
									      		</div>
									    </div>
            							<div class="form-group">
									      	<div class="col-lg-10 col-lg-offset-2">
									        	<button type="reset" class="btn btn-default">Cancel</button>
									        	<button type="submit" class="btn btn-primary">Submit</button>
									      	</div>
									    </div>
            						</form>
            					</ul>
            				</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$translate['Register']; ?></a>
								<ul class="dropdown-menu" role="menu">
            						<form action="register" method="post" class="form-horizontal">
            							<div class="form-group">
									      	<label for="inputEmail" class="col-lg-2 control-label">Email</label>
									      		<div class="col-lg-10">
									        		<input type="text" class="form-control" id="inputEmail" placeholder="Email">
									      		</div>
									    </div>
            							<div class="form-group">
									      	<label for="inputEmail" class="col-lg-2 control-label">Email</label>
									      		<div class="col-lg-10">
									        		<input type="text" class="form-control" id="inputEmail" placeholder="Email">
									      		</div>
									    </div>
            							<div class="form-group">
									      	<div class="col-lg-10 col-lg-offset-2">
									        	<button type="reset" class="btn btn-default">Cancel</button>
									        	<button type="submit" class="btn btn-primary">Submit</button>
									      	</div>
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