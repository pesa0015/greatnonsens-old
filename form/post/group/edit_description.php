<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$group_id = sqlEscape($_POST['group_id']);
	$group_description = sqlEscape($_POST['group_description']);

	if (sqlAction("UPDATE groups SET description = '{$group_description}' WHERE id = {$group_id};") && sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$group_id}, {$_SESSION['user']['id']}, 'edited_description', 'null', now());")) {
		require '../../../lib/Firebase/url.php';
		getFirebase($require = true);

		$firebase = new Firebase\FirebaseLib($url, $token);

		$firebaseArray = array(
			'data' => 'false',
			'from' => $_SESSION['user']['id'],
			'name' => "{$_SESSION['user']['name']}",
			'time' => time(),
			'type' => 'edited_description',
			'unread' => 'true'
		);

		$firebase->push("/groups/{$group_id}/groups_news_feed/", $firebaseArray);
		header("Location: ../../../groups?view={$group_id}&show=description");
	}

}

?>