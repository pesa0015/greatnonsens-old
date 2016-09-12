<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	if (isset($_SESSION['user'])) {
		if (isset($_GET['view']) && isset($_GET['decline'])) {
			if (is_numeric($_GET['view']) && is_numeric($_GET['decline'])) {
				$group_info = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']};");

				if ($group_info[0]['admin'] == 1) {
					$member = sqlSelect("SELECT users.user_id, users.username, groups.id, groups.name FROM users INNER JOIN `group_members` INNER JOIN groups ON users.user_id = group_members.user_id AND groups.id = group_members.group_id WHERE group_members.id = {$_GET['decline']};");
					if (sqlAction("DELETE FROM group_members WHERE id = {$_GET['decline']};")) {

						if (sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$_GET['view']}, {$_SESSION['user']['id']}, 'rejected_invite_request', '{\"id\":{$member[0]['user_id']}, \"username\":\"{$member[0]['username']}\"}', now());")) {
							header("Location: ../../../groups/{$_GET['view']}/members/invited");
						}
					}
				}
			}
		}
	}
}

?>