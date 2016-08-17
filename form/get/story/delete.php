<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		$story = $_GET['story'];

		if (sqlAction("DELETE FROM story_writers WHERE story_id = {$story};") && sqlAction("DELETE FROM row WHERE story_id = {$story};")) {
			if (sqlAction("DELETE FROM story WHERE story_id = {$story};")) {
				echo 1;
				die;
			}
		}
	}
}

?>