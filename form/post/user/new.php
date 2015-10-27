<?php

// require '../../../lib/Firebase/url.php';
// getFirebase($require = true);

// // $url = 'https://test-greatnonsens.firebaseio.com/';
// // $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhZG1pbiI6ZmFsc2UsImRlYnVnIjpmYWxzZSwiZCI6eyJ1aWQiOiJleGFtcGxlSUQifSwidiI6MCwiaWF0IjoxNDQ1NDQ1ODI3fQ.EULQYboGViEQ4plfWNrVDhpIapJ_sBlz9UVoVuBeXso';

// $firebase = new Firebase\FirebaseLib($url, $token);

// $test = array(
	
// 				'data' => 'false',
// 				'from' => 'false',
// 				'name' => 'false',
// 				'time' => time(),
// 				'type' => 'account_registered',
// 				'unread' => 'false'
		
// 	);
// // $dateTime = new DateTime();
// if ($firebase->push('/users_news_feed/16/', $test))
// 	echo 1;

// // if ($firebase->set('/groups/7/', $test))
// // 	echo 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$user = $_POST['user'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password_repeat = $_POST['password_repeat'];

	$_SESSION['errors'] = array();
	$_SESSION['register'] = array();

	if (empty($user) && empty($email) && empty($password) && empty($password_repeat)) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Fyll i fälten");
		header('Location: ../../../signup');
		die;
	}

	if (strlen($user) <= 3) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> För kort användarnamn (minst 4 tecken)");
		$_SESSION['register']['user'] = $user;
	}

	if (strlen($user) >= 25) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> För lång användarnamn (max 25 tecken)");
		$_SESSION['register']['user'] = $user;
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Ogiltig email");
		$_SESSION['register']['email'] = $email;
	}

	if (strlen($password) <= 4) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> För kort lösenord");
		$_SESSION['register']['password'] = $password;
	}

	if (strlen($password) >= 25) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> För långt lösenord");
		$_SESSION['register']['password'] = $password;
	}

	if ($password_repeat != $password) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Lösenorden matchar inte varandra");
		$_SESSION['register']['password_repeat'] = $password_repeat;
		$_SESSION['register']['password'] = $password;
	}

	if ($_SESSION['errors']) {
		if (!isset($_SESSION['register']['user']))
			$_SESSION['register']['user'] = $user;
		if (!isset($_SESSION['register']['email']))
			$_SESSION['register']['email'] = $email;
		if (!isset($_SESSION['register']['password']))
			$_SESSION['register']['email'] = $password;
		if (!isset($_SESSION['register']['password_repeat']))
			$_SESSION['register']['email'] = $password_repeat;
		header('Location: ../../../signup');
	}

	else {
		$user_exists = sqlSelect("SELECT username, email FROM (SELECT username FROM users WHERE username = '$user') A, (SELECT email FROM users WHERE email = '$email') B;");

		if ($user_exists) {
			// echo "SELECT username, email FROM (SELECT username FROM users WHERE username = '$user') A, (SELECT email FROM users WHERE email = '$email') B;<br />";
			// echo '<pre>';
			// print_r($user_exists);
			// echo '</pre>';
			// die;
			if ($user_exists[0]['username']) {
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Användarnamnet är upptaget");
				$_SESSION['register']['user'] = $user;
			}
			if ($user_exists[0]['email']) {
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> E-mailadressen är upptaget");
				$_SESSION['register']['email'] = $email;
			}

			if (!isset($_SESSION['register']['password']))
				$_SESSION['register']['email'] = $password;
			if (!isset($_SESSION['register']['password_repeat']))
				$_SESSION['register']['email'] = $password_repeat;
			header('Location: ../../../signup');
		}

		else {
			$password = password_hash($password, PASSWORD_DEFAULT);

			require '../../../lib/Firebase/url.php';
			getFirebase($require = true);

			$firebase = new Firebase\FirebaseLib($url, $token);

			$user_id = sqlAction("INSERT INTO users (facebook_id, username, password, email, registration_date, profile_img, personal_text, reset_password_key, theme) VALUES (null, '$user', '$password', '$email', now(), null, null, null, null);", $getLastId = true);

			$firebaseArray = array(
				'data' => 'false',
				'from' => 'false',
				'name' => 'false',
				'time' => time(),
				'type' => 'account_registered',
				'unread' => 'false'
				);

			if ($user_id && $firebase->push("/users_news_feed/$user_id/", $firebaseArray)) {
					$_SESSION['noty_message'] = array(
						'text' => $translate['noty_message']['user_created']['text'],
						'type' => $translate['noty_message']['user_created']['type'],
						'dismissQueue' => $translate['noty_message']['user_created']['dismissQueue'],
						'layout' => $translate['noty_message']['user_created']['layout'],
						'theme' => $translate['noty_message']['user_created']['theme'],
						'timeout' => $translate['noty_message']['user_created']['timeout']
						);
					header('Location: ../../../login');
			}
			// if (sqlAction("INSERT INTO users (facebook_id, username, password, email, registration_date, profile_img, personal_text, reset_password_key, theme) VALUES (null, '$user', '$password', '$email', now(), null, null, null, null);")) {
			// 	$_SESSION['noty_message'] = array(
			// 		'text' => $translate['noty_message']['user_created']['text'],
			// 		'type' => $translate['noty_message']['user_created']['type'],
			// 		'dismissQueue' => $translate['noty_message']['user_created']['dismissQueue'],
			// 		'layout' => $translate['noty_message']['user_created']['layout'],
			// 		'theme' => $translate['noty_message']['user_created']['theme'],
			// 		'timeout' => $translate['noty_message']['user_created']['timeout']
			// 		);
			// 	header('Location: ../../login');
			// }
		}
	}
}

?>