<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$user = sqlEscape($_POST['user']);
	$password = sqlEscape($_POST['password']);

	$user_exists = sqlSelect("SELECT user_id, username, password FROM `users` WHERE type = 1 AND username = '$user' OR email = '$user';");

	$_SESSION['errors'] = array();
	$_SESSION['login'] = array();

	if (!$user_exists) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\">Fel användarnamn");
		$_SESSION['login']['user'] = $user;
		header('Location: ../../../login');
	}

	else {
		$pwd = $user_exists[0]['password'];

		if (password_verify($password, $pwd)) {

			$_SESSION['user']['id'] = $user_exists[0]['user_id'];
			$_SESSION['user']['name'] = $user_exists[0]['username'];

			unset($_SESSION['login']);

			header('Location: ../../../');
		}

		else {
			array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Fel lösenord");
			$_SESSION['login']['user'] = $user;
			$_SESSION['login']['password'] = $password;
			header('Location: ../../../login');
		}
	}
}

?>