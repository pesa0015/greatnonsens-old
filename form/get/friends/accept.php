<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	if (isset($_SESSION['user']) && isset($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['friend']) && is_numeric($_GET['friend'])) {
		if (sqlAction("UPDATE friends SET status = 1 WHERE friend_request_id = {$_GET['id']} AND user_id = {$_GET['friend']} AND friend_user_id = {$_SESSION['user']['id']} AND status = 0 AND sender != {$_SESSION['user']['id']};")) {
			require '../../../lib/Firebase/url.php';
			getFirebase($require = true);

			$firebase = new Firebase\FirebaseLib($url, $token);

			$firebaseArray = array(
				'from' => array('user_id' => $_SESSION['user']['id'], 'user_name' => "{$_SESSION['user']['name']}"),
				'group' => 'false',
				'story' => 'false',
				'time' => time(),
				'type' => 'accepted_friend_request',
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