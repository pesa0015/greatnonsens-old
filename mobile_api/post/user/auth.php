<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$postdata = file_get_contents('php://input');
	$request = json_decode($postdata);

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$user = sqlEscape($request->user);
	$password = sqlEscape($request->password);

	$user_exists = sqlSelect("SELECT user_id, username, password FROM `users` WHERE type = 1 AND username = '$user' OR email = '$user';");

	$_SESSION['errors'] = array();
	$_SESSION['login'] = array();

	if (!$user_exists) {
		echo 'Fel användarnamn';
	}

	else {
		$pwd = $user_exists[0]['password'];

		if (password_verify($password, $pwd)) {
			$data['user']['id'] = $user_exists[0]['user_id'];
			$data['user']['name'] = $user_exists[0]['username'];
			echo json_encode($data['user']);
		}

		else {
			echo 'Fel lösenord';
		}
	}
}

?>