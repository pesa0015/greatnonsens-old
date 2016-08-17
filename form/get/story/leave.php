<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		$story = $_GET['story'];

		if (sqlAction("DELETE FROM story_writers WHERE story_id = {$story} AND user_id = {$_SESSION['me']['id']};")) {
			echo 1;
			die;
		}
	}
}

?>