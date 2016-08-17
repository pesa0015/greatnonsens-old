<?php

require 'session.php';

require 'lang/list.php';

if (isset($_GET['lang'])) {
	$_SESSION['lang'] = $_GET['lang'];
	header('Location: index');
}

require 'lang/config.php';

if (isset($_SESSION['user']))
	$groups = sqlSelect("SELECT DISTINCT(groups.id), groups.name FROM groups INNER JOIN `groups_activity_history` ON groups.id = groups_activity_history.group_id WHERE user_id = {$_SESSION['user']['id']} ORDER BY groups_activity_history.id DESC LIMIT 5;");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="Sergey Pozhilov (GetTemplate.com)">
	
	<title>Great nonsens</title>

	<link rel="shortcut icon" href="assets/images/gt_favicon.png">
	<!-- Bootstrap itself -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Custom styles -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.css">
	<link rel="stylesheet" href="assets/css/magister.css">
	<link rel="stylesheet" href="assets/css/ionicons.min.css">
	<link rel="stylesheet" href="css/style.css">

	<!-- Fonts -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
</head>

<!-- use "theme-invert" class on bright backgrounds, also try "text-shadows" class -->
<body class="theme-invert">
	<div id="wrapper">
	<?php if (isset($_COOKIE['cookie_information'])): ?>
	<div id="login-signup-cookies-area">
		<form action="form/post/user/auth" method="post" id="login-form">
			<span>Användarnamn: </span>
			<input type="text" name="user" autofocus>
			<span>Lösenord: </span>
			<input type="password" name="password">
			<input type="submit" name="login" value="Logga in" style="padding-bottom: 1px; margin-right: 10px;">
		</form>
		<span style="margin-right: 10px;"> | </span>
		<a href="signup">Registrera</a>
		<span style="margin-left: 10px; margin-right: 10px;"> | </span>
		<span><a href="">Great nonsens använder cookies</a></span>
		<span style="margin-left: 10px; margin-right: 10px;"> | </span>
		<span id="close-cookie-info" class="ion-ios-close-outline" style="font-size: 20px; vertical-align: middle;"></span>
	</div>
	<?php endif; ?>
	<header>
		<a href="http://localhost:8888/great_nonsens-v.12/" id="logo"><img src="assets/images/magic.png" style="width:35px;" alt=""></a>
		<span id="toggle-menu" class="ion-navicon"></span>
		<span id="hide-menu" class="ion-arrow-up-b" style="display: none;"></span>
	</header>
	<nav id="nav" style="display: none;">
		<?php if (isset($_SESSION['user'])): ?>
		<ul style="float: left; margin-left: 20px; margin-right: 100px;">
			<li><a href="logout">Logga ut</a></li>
		</ul>
		<?php else: ?>
		<ul style="float: left; margin-left: 20px; margin-right: 100px;">
			<li><a href="login">Logga in</a></li>
			<li><a href="signup">Registrera</a></li>
		</ul>
		<ul>
			<li><a href="">Om Great nonsens</a></li>
			<li><a href="">Användning av cookies</a></li>
		</ul>
		<?php endif; ?>
	</nav>
	<div id="content">