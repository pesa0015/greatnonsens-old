<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();
	require '../../../mysql/query.php';

	if (strlen($_POST['new_password']) < 6) {
		echo json_encode(array('password_too_short' => true));
		die;
	}
	if (strlen($_POST['new_password']) > 25) {
		echo json_encode(array('password_too_long' => true));
		die;
	}

	$password = sqlEscape($_POST['new_password']);
	$email = sqlEscape($_POST['email']);
	$token = sqlEscape($_POST['token']);

	$getUser = sqlSelect("SELECT user_id FROM users WHERE email = '{$email}' AND reset_password_key = '{$token}';");
	if ($getUser) {
		$newPassword = password_hash($password, PASSWORD_DEFAULT);
		if (sqlAction("UPDATE users SET password = '{$newPassword}', reset_password_key = null WHERE user_id = {$getUser[0]['user_id']} AND email = '{$email}' AND reset_password_key = '{$token}';")) {
			echo json_encode(array('success' => true));
			die;
		}
	}
}

?>