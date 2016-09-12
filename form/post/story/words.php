<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['story']) && is_numeric($_POST['story'])) {
		session_start();
		require '../../../mysql/query.php';
		$story = $_POST['story'];
		$nonsens_mode = sqlSelect("SELECT nonsens_mode FROM story WHERE story_id = {$story};");
		if ($nonsens_mode[0]['nonsens_mode'] == 1) {
			$on_turn = sqlSelect("SELECT users.user_id, username FROM users INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_id = {$story} AND on_turn = 1;");
			if ($on_turn[0]['user_id'] == $_SESSION['me']['id']) {
				$words = sqlSelect("SELECT users.user_id, username, words, date FROM users INNER JOIN `row` ON users.user_id = row.user_id WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1;");
				if ($words) echo json_encode(array('status' => 'my turn', 'words' => $words));
				else echo 0;
				die;
			}
			else echo json_encode(array('status' => 0, 'on_turn' => $on_turn));
			die;
		}
		die;
		$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1, 1;");
		if ($words) {
			echo json_encode(array('words' => $words, 'nonsens_mode' => $nonsens_mode[0]['nonsens_mode']));
			die;
		}
	}
}

?>