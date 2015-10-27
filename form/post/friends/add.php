<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$friends = sqlEscape($_POST['friends']);

	$_SESSION['errors'] = array();

	if (empty($friends)) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Fyll i fältet");
		header('Location: ../../../profile?view=friends');
	}

	if (!empty($friends)) {
		$users_exists = sqlSelect("SELECT user_id, username FROM `users` WHERE user_id IN ({$friends}) OR username IN ('{$friends}');");

		if (!$users_exists) {
			if (strlen($friends) >= 3)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelarna finns inte");
			if (strlen($friends) == 1)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelaren finns inte");
		}
	}

	if (!$_SESSION['errors']) {
		require '../../../lib/Firebase/url.php';
		getFirebase($require = true);

		$firebase = new Firebase\FirebaseLib($url, $token);

		$firebaseArray = array(
			'data' => 'false',
			'from' => $_SESSION['user']['id'],
			'name' => "{$_SESSION['user']['name']}",
			'time' => time(),
			'type' => 'friend_request',
			'unread' => 'true'
		);

		$friend_request = "INSERT INTO friends (user_id, friend_user_id, status, date) VALUES ";

		foreach ($users_exists as $friend) {
			$friend_request .= "({$_SESSION['user']['id']}, {$friend['user_id']}, 0, now()), ";
		}

		$friend_request = rtrim($friend_request, ', ');
		$friend_request .= ';';

		foreach ($users_exists as $new_friend) {
			$firebase->push("/users_news_feed/{$new_friend['user_id']}/", $firebaseArray);
		}

		if (sqlAction($friend_request)) {
			$_SESSION['noty_message'] = array(
				'text' => $translate['noty_message']['friend_request_sent']['text'],
				'type' => $translate['noty_message']['friend_request_sent']['type'],
				'dismissQueue' => $translate['noty_message']['friend_request_sent']['dismissQueue'],
				'layout' => $translate['noty_message']['friend_request_sent']['layout'],
				'theme' => $translate['noty_message']['friend_request_sent']['theme'],
				'timeout' => $translate['noty_message']['friend_request_sent']['timeout']
			);
			header('Location: ../../../profile?view=friends');
		}
	}

	// echo '<pre>';
	// print_r($friends);
	// echo '</pre>';

}

?>