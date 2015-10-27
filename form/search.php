<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../mysql/query.php';
	require '../lang/config.php';

	if (isset($_POST['writers'])) {
		$writers = sqlEscape($_POST['writers']);
		$sql_term = sqlSelect("SELECT user_id, username FROM users WHERE username LIKE '%{$writers}%' LIMIT 5;");

		echo json_encode($sql_term); 
	}

}

?>