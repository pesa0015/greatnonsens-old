<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['story']) && is_numeric($_POST['story'])) {
		session_start();
		require '../../../mysql/query.php';
		$story = $_POST['story'];
		$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} AND row_id != (SELECT MAX(row_id) FROM row WHERE story_id = {$story});");
		$title = sqlSelect("SELECT title FROM story WHERE story_id = {$story};");
		if ($stories) {
			echo json_encode(array('words' => $words, 'title' => $title));
			die;
		}
	}
}

?>