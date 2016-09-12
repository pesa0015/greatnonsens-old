<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$group_id = sqlEscape($_POST['group_id']);
	$group_name = sqlEscape($_POST['group_name']);
	$group_members = sqlEscape($_POST['group_members']);

	$_SESSION['errors'] = array();

	if (!is_numeric($group_id))
		$_SESSION['errors'] = true;

	if (empty($group_members)) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Fyll i fältet");
		header("Location: ../../../groups/{$group_id}/invite");
	}

	if (!empty($group_members)) {
		$users_exists = sqlSelect("SELECT user_id, username FROM `users` WHERE type = 1 AND user_id IN ({$group_members}) OR username IN ('{$group_members}');");

		if (!$users_exists) {
			if (strlen($group_members) >= 3)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelarna finns inte");
			if (strlen($group_members) == 1)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelaren finns inte");
		}

		else {
			$members_exists = sqlSelect("SELECT users.user_id, users.username, group_members.status FROM users INNER JOIN `group_members` ON users.user_id = group_members.user_id WHERE group_members.group_id = {$group_id} AND group_members.user_id IN ({$group_members});");

			if ($members_exists) {
				foreach ($members_exists as $member) {
					if ($member['status'] == 1)
						array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> {$member['username']} är redan med i gruppen");
					if ($member['status'] == 2)
						array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> {$member['username']} är redan inbjuden");
					if ($member['status'] == 3)
						array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> {$member['username']} önskar redan om att få gå med i gruppen");
				}
				header("Location: ../../../groups/{$group_id}/invite");
			}
		}
	}

	if (!$_SESSION['errors']) {
		// $group_invites = "INSERT INTO group_invites (group_id, user_id, sent_by, status, sent) VALUES ";
		$group_news_feed = "INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ";
		$invite = "INSERT INTO group_members (group_id, user_id, status, admin, joined) VALUES ";

		foreach ($users_exists as $user) {
		// 	$group_invites .= "({$group_id}, {$user['user_id']}, '{\"id\":{$_SESSION['user']['id']}, \"username\":\"{$_SESSION['user']['name']}\"}', 0, now()), ";
			$group_news_feed .= "({$group_id}, {$_SESSION['user']['id']}, 'invited', '{\"id\":{$user['user_id']}, \"username\":\"{$user['username']}\"}', now()), ";
			$invite .= "({$group_id}, {$user['user_id']}, 2, 0, null), ";
		}

		// $group_invites = rtrim($group_invites, ', ');
		$group_news_feed = rtrim($group_news_feed, ', ');
		$invite = rtrim($invite, ', ');

		// $group_invites .= ';';
		$group_news_feed .= ';';
		$invite .= ';';

		if (sqlAction($group_news_feed) && sqlAction($invite)) {
			$_SESSION['noty_message'] = array(
				'text' => $translate['noty_message']['invite_sent']['text'],
				'type' => $translate['noty_message']['invite_sent']['type'],
				'dismissQueue' => $translate['noty_message']['invite_sent']['dismissQueue'],
				'layout' => $translate['noty_message']['invite_sent']['layout'],
				'theme' => $translate['noty_message']['invite_sent']['theme'],
				'timeout' => $translate['noty_message']['invite_sent']['timeout']
			);
			header("Location: ../../../groups/{$group_id}/invite");
		}
	}
}

?>