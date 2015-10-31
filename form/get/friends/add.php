<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	if (isset($_SESSION['user']) && isset($_GET['friend']) && is_numeric($_GET['friend'])) {
		if (sqlAction("INSERT INTO friends (user_id, friend_user_id, status, sender, date) VALUES ({$_SESSION['user']['id']}, {$_GET['friend']}, 0, {$_SESSION['user']['id']}, now());")) {
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

			$firebase->push(usersNewsFeed($_GET['friend']), $firebaseArray);

			if (isset($_GET['return_to_profile']))
				header("Location: ../../../profile?view={$_GET['friend']}");
			header('Location: ../../../profile?view=friends');
		}
	}
}

?>