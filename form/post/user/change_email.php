<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	$email = sqlEscape($_POST['email']);
	$the_password = sqlEscape($_POST['password_confirm']);

	if (strlen($the_password) > 5 && strlen($the_password) < 25 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$password = sqlSelect("SELECT password FROM users WHERE user_id = {$_SESSION['user']['id']};");
		if (password_verify($the_password, $password[0]['password'])) {
			if (sqlAction("UPDATE users SET email = '{$email}' WHERE user_id = {$_SESSION['user']['id']};")) {
				echo json_encode(array('success' => true));
				die;
			}
		}
	}
}

?>