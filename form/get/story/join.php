<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (isset($_GET['story']) && is_numeric($_GET['story'])) {

		session_start();

		require '../../../mysql/query.php';
		$story = $_GET['story'];

		$writer = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} and user_id = {$_SESSION['me']['id']};");

		if (empty($writer)) {
			if (sqlAction("INSERT INTO story_writers (story_id, user_id, on_turn, round, date) VALUES ({$story}, {$_SESSION['me']['id']}, {$on_turn}, 1, now());")) {
				echo 1;
				die;
			}
		}
	}
}

?>