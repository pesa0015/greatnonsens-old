<?php
$route = explode('/',$_SERVER['REQUEST_URI']);
session_start();
$loginPage = true;
if (isset($route[2]) && $route[2] === 'forgot_password') {
	$page = 'views/login/forgot_password.php';
	$script = 'js/login.forgot_password.js';
	$baseHref = '../';
}
if (isset($route[2]) && $route[2] !== 'forgot_password' && isset($route[3]) && !empty($route[3])) {
	$page = 'views/login/reset_password.php';
	$script = 'js/login.reset_password.js';
	$email = $route[2];
	$token = $route[3];
	$baseHref = '../../../';
}
if (isset($route[2]) && empty($route[2]) || !isset($route[2])) {
	$page = 'views/login/login.php';
	$baseHref = '../';
}
require 'layout/header.php';
require $page;
if (isset($_SESSION['login'])) unset($_SESSION['login']);
require 'footer.php';
?>