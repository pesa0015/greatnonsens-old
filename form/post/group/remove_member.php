<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	if (!isset($_SESSION['user']) && !is_numeric($_POST['group']) && !is_numeric($_POST['memberId']))
		die;
	$group_id = $_POST['group'];
	$memberId = $_POST['memberId'];
	$group_info = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$group_id} AND user_id = {$_SESSION['user']['id']};");
	if ($group_info[0]['admin'] != 1)
		die;
	$member = sqlSelect("SELECT group_members.id, users.user_id, users.username, groups.id AS group_id, groups.name FROM users INNER JOIN `group_members` INNER JOIN groups ON users.user_id = group_members.user_id AND groups.id = group_members.group_id WHERE group_members.group_id = {$group_id} AND group_members.user_id = {$memberId};");
	if ($member[0]['user_id'] == $_SESSION['me']['id'])
		die;
	if (sqlAction("DELETE FROM group_members WHERE id = {$member[0]['id']};")) {
		if (sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$member[0]['group_id']}, {$_SESSION['user']['id']}, 'member_kicked', '{\"id\":{$member[0]['user_id']}, \"username\":\"{$member[0]['username']}\"}', now());")) {
			echo json_encode(array('success' => true));
		}
	}
}

?>