<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	$group_id = sqlEscape($_POST['group_id']);
	$group_name = sqlEscape($_POST['group_name']);
	$group_description = sqlEscape($_POST['group_description']);

	if (sqlAction("UPDATE groups SET description = '{$group_description}' WHERE id = {$group_id};") && sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$group_id}, {$_SESSION['user']['id']}, 'edited_description', 'null', now());")) {
		// require '../../group_members.php';
		// $members = getGroupMembers($group_id);
		header("Location: ../../../groups/{$group_id}/description");
	}
}

?>