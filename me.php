<?php

$route = explode('/',$_SERVER['REQUEST_URI']);
$baseHref = '../';
$me = true;
$page = false;
if (isset($route[2]))
	$page = $route[2];

session_start();
require 'layout/header.php';
if (!isset($_SESSION['user']) && $page === 'settings'): ?>
	<h1>Du är inte inloggad.</h1>	
<?php
else:
$info = sqlSelect("SELECT email, personal_text FROM users WHERE user_id = {$_SESSION['user']['id']};");

function isPage($menuItem) {
	global $page;
	return ($page === $menuItem) ? ' class="active"' : '';
}

require 'views/user/nav.php';
require 'views/user/me.php';
require 'views/user/settings.php';
$script = 'js/user_settings.js';
endif;
require 'footer.php';

?>