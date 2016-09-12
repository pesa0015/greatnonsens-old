<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$name = sqlEscape($_POST['name']);
	$description = sqlEscape($_POST['description']);
	$group_members = sqlEscape($_POST['group_members']);
	$secret = $_POST['secret'];
	$open = $_POST['open'];
	// $chat = $_POST['chat_is_public'];
	$chat = 1;

	$_SESSION['errors'] = array();
	$_SESSION['group'] = array();

	if (empty($name)) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Fyll i gruppnamn");
	}
	if (!empty($name) && strlen($name) <= 2) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Gruppnamnet är för kort (minst 3 tecken)");
	}
	if (strlen($name) >= 26) {
		array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Gruppnamnet är för lång (max 25 tecken)");
	}
	if (strlen($name) >= 3 && strlen($name) <= 25) {
		$group_exists = sqlSelect("SELECT name FROM groups WHERE name = '{$name}';");

		if ($group_exists) {
			array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Gruppnamnet är upptaget");
		}
	}
	if (!empty($group_members)) {
		$users_exists = sqlSelect("SELECT user_id, username FROM `users` WHERE type = 1 AND user_id IN ({$group_members}) OR username IN ('{$group_members}');");

		if (!$users_exists) {
			if (strlen($group_members) >= 3)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelarna finns inte");
			if (strlen($group_members) == 1)
				array_push($_SESSION['errors'], "<span class=\"ion-android-warning\"> Spelaren finns inte");
		}
	}
	if ($_SESSION['errors']) {
		if (!isset($_SESSION['group']['name']))
			$_SESSION['group']['name'] = $name;
		if (!isset($_SESSION['group']['description']))
			$_SESSION['group']['description'] = $description;
		header('Location: ../../../groups/new');
	}
	else {
		$group_id = sqlAction("INSERT INTO groups (name, secret, open, chat_is_public, description, created) VALUES ('{$name}', {$secret}, {$open}, {$chat}, '{$description}', now());", $getLastId = true);
		$group = sqlSelect("SELECT id, name FROM groups WHERE id = {$group_id};");

		if ($group_id) {
			$group_m = "INSERT INTO group_members (group_id, user_id, admin, joined) VALUES ({$group_id}, {$_SESSION['user']['id']}, 1, now());";
			// $group_activity_history = "INSERT INTO groups_activity_history (user_id, group_id) VALUES ({$_SESSION['user']['id']}, {$group_id});";

			sqlAction($group_m);
			// sqlAction($group_activity_history);

			$group_news_feed = "INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$group_id}, {$_SESSION['user']['id']}, 'group_created', 'null', now()), ";

			if (!empty($group_members)) {
				$group_invites = "INSERT INTO group_members (group_id, user_id, status, admin, joined) VALUES ";

				foreach ($users_exists as $user) {
					$group_invites .= "({$group_id}, {$user['user_id']}, 2, 0, 'null'), ";
					$group_news_feed .= "({$group_id}, {$_SESSION['user']['id']}, 'invited', '{\"id\":{$user['user_id']}, \"username\":\"{$user['username']}\"}', now()), ";
				}

				$group_invites = rtrim($group_invites, ', ');
				$group_invites .= ';';

				sqlAction($group_invites);

			}
			$group_news_feed = rtrim($group_news_feed, ', ');
			$group_news_feed .= ';';

			sqlAction($group_news_feed);
			
			$_SESSION['noty_message'] = array(
				'text' => $translate['noty_message']['group_created']['text'],
				'type' => $translate['noty_message']['group_created']['type'],
				'dismissQueue' => $translate['noty_message']['group_created']['dismissQueue'],
				'layout' => $translate['noty_message']['group_created']['layout'],
				'theme' => $translate['noty_message']['group_created']['theme'],
				'timeout' => $translate['noty_message']['group_created']['timeout']
			);
			// header('Location: ../../../groups?view=new');
			header('Location: ../../../groups/' . $group_id . '/news');
		}
	}
}

?>