<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	require '../../../mysql/query.php';
	$stories = sqlSelect("SELECT story.story_id, title, status, story_writers.on_turn FROM story INNER JOIN `story_writers` ON story.story_id = story_writers.story_id WHERE user_id = {$_SESSION['me']['id']};");
	if ($stories) {
		echo json_encode($stories);
		die;
	}
}
	
?>