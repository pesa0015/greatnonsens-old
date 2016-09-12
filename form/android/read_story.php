<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require '../../mysql/query.php';

	$story = $_POST['story'];
	if (!is_numeric($story))
		die;

	$title = sqlSelect("SELECT title FROM story WHERE story_id = {$story} AND status = 2;");
	$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story};");

	if ($title && $words) {
		echo json_encode(array('title' => $title[0]['title'], 'words' => $words));
		die;
	}

}

?>