<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['story']) && is_numeric($_POST['story'])) {
		session_start();
		require '../../../mysql/query.php';
		$story = $_POST['story'];
		$on_turn = sqlSelect("SELECT users.user_id, username, type FROM users INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_id = {$story} AND on_turn = 1;");
		$my_turn = ($on_turn[0]['user_id'] == $_SESSION['me']['id']) ? 1 : 0;
		if ($on_turn) {
			echo json_encode(array('on_turn' => $on_turn, 'my_turn' => $my_turn));
			die;
		}
	}
}

?>