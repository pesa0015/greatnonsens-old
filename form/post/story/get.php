<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require '../../../mysql/query.php';
	$stories = sqlSelect("SELECT DISTINCT(story.story_id) AS id, title, row.words AS opening_words, nonsens_mode, max_writers, (SELECT COUNT(story_writers.user_id) FROM story_writers WHERE story_id = story.story_id) AS num_of_writers FROM story INNER JOIN `row` INNER JOIN story_writers ON story.story_id = row.story_id AND story.story_id = story_writers.story_id WHERE status = 0 AND `join` = 0 LIMIT 5;");
	if ($stories) {
		echo json_encode($stories);
		die;
	}
}
	
?>