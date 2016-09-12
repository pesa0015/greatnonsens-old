<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../../mysql/query.php';
	$me = (isset($_SESSION['me'])) ? $_SESSION['me'] : (array)json_decode($_POST['me']);
	// $stories = sqlSelect("SELECT story.story_id, title, status, story_writers.on_turn FROM story INNER JOIN `story_writers` ON story.story_id = story_writers.story_id WHERE user_id = {$_SESSION['me']['id']};");
	$stories = sqlSelect("SELECT story.story_id, title, status, story_writers.on_turn, groups.name FROM story INNER JOIN `story_writers` INNER JOIN groups ON story.story_id = story_writers.story_id AND story.with_group = groups.id WHERE user_id = {$me['id']};");
	if ($stories) {
		echo json_encode($stories);
		die;
	}
}
	
?>