<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	$old = sqlEscape($_POST['password']);
	$new = sqlEscape($_POST['new_password']);
	$new_repeat = sqlEscape($_POST['password_confirm']);

	if (strlen($old) > 5 && strlen($old) < 25 && strlen($new) > 5 && strlen($new) < 25 && strlen($new_repeat) > 5 && strlen($new_repeat) < 25 && $new === $new_repeat) {
		$password = sqlSelect("SELECT password FROM users WHERE user_id = {$_SESSION['user']['id']};");
		if (password_verify($old, $password[0]['password'])) {
			$pass = password_hash($new, PASSWORD_DEFAULT);
			if (sqlAction("UPDATE users SET password = '{$pass}' WHERE user_id = {$_SESSION['user']['id']};")) {
				echo json_encode(array('success' => true));
				die;
			}
		}
	}
}

?>