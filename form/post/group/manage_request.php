<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';
	if (!isset($_SESSION['user']) && !is_numeric($_POST['group']) && !is_numeric($_POST['memberId']) && !is_numeric($_POST['rowId']))
		die;
	if ($_POST['action'] !== 'accept' && $_POST['action'] !== 'decline' && $_POST['action'] !== 'remove_invite')
		die;
	$action = $_POST['action'];
	$group_id = $_POST['group'];
	$memberId = $_POST['memberId'];
	$rowId = $_POST['rowId'];
	$group_info = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$group_id} AND user_id = {$_SESSION['user']['id']};");
	if ($group_info[0]['admin'] != 1)
		die;

	$member = sqlSelect("SELECT id, status FROM `group_members` WHERE group_id = {$group_id} AND user_id = {$memberId} AND id = {$rowId};");
	if (!$member)
		die;
	switch ($action) {
		case 'accept':
			if (sqlAction("UPDATE group_members SET status = 1 WHERE id = {$member[0]['id']};")) {
				echo json_encode(array('success' => true));
				die;
			}
			break;
		case 'decline':
			if (sqlAction("DELETE FROM group_members WHERE id = {$member[0]['id']};")) {
				echo json_encode(array('success' => true));
				die;
			}
			break;
		case 'remove_invite':
			if (sqlAction("DELETE FROM group_members WHERE id = {$member[0]['id']};")) {
				echo json_encode(array('success' => true));
				die;
			}
			break;
		default:
			break;
	}
	$member = sqlSelect("SELECT admin FROM group_members WHERE group_id = {$group_id} AND user_id = {$memberId};");
	if ($member[0]['admin'] == 1) {
		$admin = 0;
		$check = false;
	}
	if ($member[0]['admin'] == 0) {
		$admin = 1;
		$check = true;
	}
	if (sqlAction("UPDATE group_members SET admin = {$admin} WHERE group_id = {$group_id} AND user_id = {$memberId};")) {
		echo json_encode(array('success' => true, 'check' => $check));
	}
}

?>