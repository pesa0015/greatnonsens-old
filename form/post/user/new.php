<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	$user = sqlEscape($_POST['user']);
	$email = sqlEscape($_POST['email']);
	$password = sqlEscape($_POST['password']);
	$password_repeat = sqlEscape($_POST['password_repeat']);

	$errors = array(
		'type' => array(),
		'text' => array()
	);

	function addToArray($type, $text) {
		global $errors;
		array_push($errors['type'], $type);
		array_push($errors['text'], $text);
	}

	if (empty($user) && empty($email) && empty($password) && empty($password_repeat)) {
		addToArray('all_fields', '<span class="ion-android-warning"> Fyll i fälten');
		echo json_encode($errors);
		die;
	}

	if (strlen($user) < 3) {
		if (empty($user)) {
			addToArray('user', 'Användarnamn saknas');
		}
		else {
			addToArray('user', 'För kort användarnamn (minst 3 tecken)');
		}
	}

	if (strlen($user) > 25) {
		addToArray('user', 'För lång användarnamn (max 25 tecken)');
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		if (empty($email)) {
			addToArray('email', 'Email saknas');
		}
		else {
			addToArray('email', 'Ogiltig email');
		}
	}

	if (strlen($password) < 6) {
		if (empty($email)) {
			addToArray('password', 'Lösenord saknas');
		}
		else
			addToArray('password', 'För kort lösenord (minst 6 tecken)');
	}

	if (strlen($password) > 25) {
		addToArray('password', 'För långt lösenord');
	}

	if (strlen($password) >= 6 && strlen($password) <= 25 && strlen($password_repeat) >= 6 && strlen($password_repeat) <= 25 && $password_repeat != $password) {
		addToArray('password_repeat', 'Lösenorden matchar inte varandra');
	}

	if (strlen($user) > 2 && strlen($user) < 20) {
		$user_exists = sqlSelect("SELECT username, email FROM (SELECT username FROM users WHERE type = 1 AND username = '$user') A, (SELECT email FROM users WHERE email = '$email') B;");

		if ($user_exists) {
			if ($user_exists[0]['username']) {
				addToArray('user', 'Användarnamnet är upptaget');
			}
			if ($user_exists[0]['email']) {
				addToArray('email', 'E-mailadressen är upptagen');
			}
		}
	}

	if (count($errors['type']) > 0) {
		echo json_encode($errors);
		die;
	}

	else {
		$password = password_hash($password, PASSWORD_DEFAULT);
		$user = sqlAction("INSERT INTO users (type, facebook_id, username, password, email, registration_date, profile_img, personal_text, reset_password_key) VALUES (1, null, '$user', '$password', '$email', now(), null, null, null);", true);
		if ($user) {
			echo json_encode(array('success' => true, 'user_id' => $user));
		}
	}
}

?>