<?php

$route = explode('/',$_SERVER['REQUEST_URI']);
$baseHref = '../';
$page = false;
if (isset($route[2]))
	$userId = $route[2];
if (isset($route[3])) {
	$page = $route[3];
	$baseHref = '../../';
}

session_start();

require 'layout/header.php';

function isPage($menuItem) {
	global $page;
	return ($page === $menuItem) ? ' class="active"' : '';
}

if (isset($userId) && is_numeric($userId)) {
	$me = (isset($_SESSION['user']) && $userId == $_SESSION['user']['id']) ? true : false;
	require 'views/user/nav.php';
	if ($me) {
		require 'views/user/me.php';
	}
	else {

	}
}

require 'footer.php';

?>