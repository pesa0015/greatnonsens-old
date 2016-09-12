<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	if (isset($_SESSION['user']) && is_numeric($_POST['groupId'])) {
		$groupId = $_POST['groupId'];
		$open = sqlSelect("SELECT open FROM groups WHERE id = {$groupId};");
		$member = sqlSelect("SELECT id, status FROM group_members WHERE group_id = {$groupId} AND user_id = {$_SESSION['user']['id']};");
		if ($member) {
			if ($member[0]['status'] == 2) {
				$type = 'accepted_group_invite';
				if (sqlAction("UPDATE group_members SET status = 1 WHERE id = {$member[0]['id']};") && sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$groupId}, {$_SESSION['user']['id']}, '{$type}', null, now());")) {
					echo json_encode(array('success' => true));
					die;
				}
			}
		}
		if (!$member && $open[0]['open'] == 1 || $open[0]['open'] == 2) {
			if ($open[0]['open'] == 1) {
				$status = 1;
				$type = 'joined_group';
			}
			else {
				$status = 3;
				$type = 'join_group_request';
			}
			if (sqlAction("INSERT INTO group_members (group_id, user_id, status, admin, joined) VALUES ({$groupId}, {$_SESSION['user']['id']}, {$status}, 0, now());") && sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$groupId}, {$_SESSION['user']['id']}, '{$type}', null, now());")) {
				echo json_encode(array('success' => true));
				die;
			}
		}
	}
}

?>