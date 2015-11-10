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
		$users = sqlSelect("SELECT user_id, username FROM `users` WHERE type = 1 AND user_id IN ({$friends}) OR username IN ({$friends});");

		if (!$users) {
			if (strlen($friends) >= 3)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelarna finns inte");
			if (strlen($friends) == 1)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelaren finns inte");
		}

		else {
			$already_friends = sqlSelect("SELECT users.user_id, users.username, friends.status, friends.sender FROM users INNER JOIN `friends` ON users.user_id = friends.user_id WHERE friends.user_id IN ({$friends}) UNION SELECT users.user_id, users.username, friends.status, friends.sender FROM users INNER JOIN `friends` ON users.user_id = friends.friend_user_id WHERE friends.friend_user_id IN ({$friends});");

			if ($already_friends) {
				foreach ($already_friends as $friend) {
					if ($friend['status'] == 1)
						array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Du är redan vän med <a href=\"profile?view={$friend['user_id']}\">{$friend['username']}</a>");
					if ($friend['status'] == 0 && $friend['sender'] == $_SESSION['user']['id'])
						array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Du har redan skickat vänförfrågan till <a href=\"profile?view={$friend['user_id']}\">{$friend['username']}</a>");
					if ($friend['status'] == 0 && $friend['sender'] != $_SESSION['user']['id'])
						array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"><a href=\"profile?view={$friend['user_id']}\">{$friend['username']}</a> har redan skickat vänförfrågan till dig");
				}
			}
		}
	}

	if ($_SESSION['errors'])
		header('Location: ../../../profile?view=friends');

	if (!$_SESSION['errors']) {
		require '../../../lib/Firebase/url.php';
		getFirebase($require = true);

		$firebase = new Firebase\FirebaseLib($url, $token);

		$firebaseArray = array(
			'from' => array('user_id' => $_SESSION['user']['id'], 'user_name' => "{$_SESSION['user']['name']}"),
			'group' => 'false',
			'story' => 'false',
			'time' => time(),
			'type' => 'friend_request',
			'unread' => 'true'
		);

		$friend_request = "INSERT INTO friends (user_id, friend_user_id, status, sender, date) VALUES ";

		foreach ($users as $friend) {
			$friend_request .= "({$_SESSION['user']['id']}, {$friend['user_id']}, 0, {$_SESSION['user']['id']}, now()), ";
		}

		$friend_request = rtrim($friend_request, ', ');
		$friend_request .= ';';

		foreach ($users as $new_friend) {
			$firebase->push(usersNewsFeed($new_friend['user_id']), $firebaseArray);
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
}

?>