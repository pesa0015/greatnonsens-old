<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$group_id = sqlEscape($_POST['group_id']);
	$group_name = sqlEscape($_POST['group_name']);
	$group_description = sqlEscape($_POST['group_description']);

	if (sqlAction("UPDATE groups SET description = '{$group_description}' WHERE id = {$group_id};") && sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$group_id}, {$_SESSION['user']['id']}, 'edited_description', 'null', now());")) {
		require '../../group_members.php';
		$members = getGroupMembers($group_id);
		require '../../../lib/Firebase/url.php';
		getFirebase($require = true);

		$firebase = new Firebase\FirebaseLib($url, $token);

		$firebaseArray = array(
			'from' => array('user_id' => $_SESSION['user']['id'], 'user_name' => "{$_SESSION['user']['name']}"),
			'group' => array('group_id' => $group_id, 'group_name' => "{$group_name}"),
			'story' => 'false',
			'time' => time(),
			'type' => 'edited_description',
			'unread' => 'true'
		);

		if ($members) {
			foreach ($members as $member) {
				$firebase->push(usersNewsFeed($member['user_id']), $firebaseArray);
				header("Location: ../../../groups?view={$group_id}&show=description");
			}
		}
	}

}

?>