<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	header('Access-Control-Allow-Origin: *');

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$user = sqlEscape($_POST['user']);
	$password = sqlEscape($_POST['password']);

	$user_exists = sqlSelect("SELECT user_id, username, password FROM `users` WHERE type = 1 AND username = '$user' OR email = '$user';");

	$_SESSION['errors'] = array();
	$_SESSION['login'] = array();

	if (!$user_exists) {
		if (isset($_POST['mobile'])) {
			echo 'Fel användarnamn';
			die;
		}
		else {
			array_push($_SESSION['errors'], "<span class=\"ion-android-warning\">Fel användarnamn");
			$_SESSION['login']['user'] = $user;
			header('Location: ../../../login');
		}
	}

	else {
		$pwd = $user_exists[0]['password'];

		if (password_verify($password, $pwd)) {
			// $_SESSION['user'] = array();

			if (isset($_POST['mobile'])) {
				$user['user']['id'] = $user_exists[0]['user_id'];
				$user['user']['name'] = $user_exists[0]['username'];
				echo json_encode($user['user']);
				die;
			}
			else {
				$_SESSION['user']['id'] = $user_exists[0]['user_id'];
				$_SESSION['user']['name'] = $user_exists[0]['username'];

				unset($_SESSION['login']);

				header('Location: ../../../');
			}
		}

		else {
			if (isset($_POST['mobile'])) {
				echo 'Fel lösenord';
				die;
			}
			else {
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Fel lösenord");
				$_SESSION['login']['user'] = $user;
				$_SESSION['login']['password'] = $password;
				header('Location: ../../../login');
			}
		}
	}
}

?>