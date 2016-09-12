<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['story']) && is_numeric($_POST['story'])) {
		session_start();
		require '../../../mysql/query.php';
		$story = $_POST['story'];
		$writers = sqlSelect("SELECT user_id FROM `story_writers` WHERE story_id = {$story} AND user_id != {$_SESSION['me']['id']};");
		if ($writers) {
			echo json_encode($writers);
			die;
		}
	}
}
	
?>