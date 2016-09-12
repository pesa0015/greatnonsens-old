<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require '../../mysql/query.php';

	$story = (int)$_POST['story'];
	if (!is_numeric($story))
		die;

	// $title = sqlSelect("SELECT title FROM story WHERE story_id = {$story} AND status = 1;");
	// $words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1;");

	$storyData = sqlSelect("SELECT title, words, users.user_id, username, row.date FROM `row` INNER JOIN story INNER JOIN users ON row.story_id = story.story_id AND row.user_id = users.user_id WHERE row.story_id = {$story} ORDER BY row_id DESC LIMIT 1;");
	$on_turn = sqlSelect("SELECT story_writers.story_id, users.user_id, users.username FROM `story_writers` INNER JOIN users ON users.user_id = story_writers.user_id WHERE story_writers.story_id = {$story} AND on_turn = 1;");

	if ($storyData && $on_turn) {
		echo json_encode(
			array(
			'id' => $on_turn[0]['story_id'],	
			'title' => $storyData[0]['title'], 
			'latest_words' => $storyData[0]['words'], 
			'on_turn' => array('id' => $on_turn[0]['user_id'], 'name' => $on_turn[0]['username'])
			)
		);
		die;
	}

}

?>