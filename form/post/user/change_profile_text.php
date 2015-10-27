<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	if (isset($_POST['update'])) {
		$text = sqlEscape($_POST['update']);
		if (sqlAction("UPDATE users SET personal_text = '{$text}' WHERE user_id = {$_SESSION['user']['id']};"))
			header("Location: ../../../profile?view={$_SESSION['user']['id']}");
	}
}

?>