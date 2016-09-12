<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../mysql/query.php';

	if (isset($_POST['writers'])) {
		$writers = sqlEscape($_POST['writers']);
		// $sql_term = sqlSelect("SELECT user_id, username FROM users WHERE type = 1 AND username LIKE '%{$writers}%' LIMIT 5;");
		
		if (isset($_POST['hideGroupMembers']))
			$sql_term = sqlSelect("SELECT user_id, username FROM users WHERE type = 1 AND user_id NOT IN (SELECT user_id FROM group_members WHERE group_id = {$_POST['groupId']}) AND username LIKE '%{$writers}%' LIMIT 5;");
		else
			$sql_term = sqlSelect("SELECT user_id, username FROM users WHERE type = 1 AND username LIKE '%{$writers}%' LIMIT 5;");

		echo json_encode($sql_term); 
	}
}

?>