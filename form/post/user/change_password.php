<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	$_SESSION['password_success'] = false;

	require '../../../mysql/query.php';

	$current = sqlEscape($_POST['current_pwd']);
	$new = sqlEscape($_POST['new_pwd']);

	if (strlen($current) > 3 && strlen($new) > 3) {
		$password = sqlSelect("SELECT password FROM users WHERE user_id = {$_SESSION['user']['id']};");
		if (password_verify($current, $password[0]['password'])) {
			$pass = password_hash($new, PASSWORD_DEFAULT);
			if (sqlAction("UPDATE users SET password = '$pass' WHERE user_id = {$_SESSION['user']['id']};")) {
				$_SESSION['password_success'] = true; 
				header("Location: ../../../profile?view=change_password");
			}
		}
	}
}

?>