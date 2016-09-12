<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	if (!isset($_SESSION['user']) && !is_numeric($_POST['group_id']))
		die;

	$group_id = sqlEscape($_POST['group_id']);
	$groupMembers = sqlSelect("SELECT user_id FROM group_members WHERE group_id = {$group_id};");

	if ($groupMembers) {
		echo json_encode($groupMembers);
		die;
	}
}

?>