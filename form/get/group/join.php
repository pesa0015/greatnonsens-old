<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';

	if (isset($_SESSION['user'])) {
		if (isset($_GET['page']) && isset($_GET['id'])) {
			$groupId = $_GET['id'];
			$status = $_GET['request'];
			if ($status != 1 && $status != 3)
				die;
			if ($status == 1)
				$type = 'joined_group';
			else if ($status == 3)
				$type = 'group_invite_request';
			if (is_numeric($_GET['id'])) {
				if (sqlAction("INSERT INTO group_members (group_id, user_id, status, admin, joined) VALUES ({$groupId}, {$_SESSION['user']['id']}, {$status}, 0, now());") && sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$groupId}, {$_SESSION['user']['id']}, '{$type}', null, now());"))
					header("Location: ../../../groups/{$groupId}/members");
			}
		}
	}
}

?>