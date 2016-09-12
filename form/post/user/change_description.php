<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	if (isset($_POST['description'])) {
		$text = sqlEscape($_POST['description']);
		if (sqlAction("UPDATE users SET personal_text = '{$text}' WHERE user_id = {$_SESSION['user']['id']};")) {
			echo json_encode(array('success' => true));
			die;
		}
	}
}

?>