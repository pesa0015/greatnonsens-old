<?php

if (!isset($_GET['story']) || empty($_GET['story']) || !is_numeric($_GET['story']))
	header('Location: /');

$story = (int)$_GET['story'];

session_start();

// $baseHref = '../';

require 'layout/header.php';

$status = sqlSelect("SELECT status FROM story WHERE story_id = {$story};");
$on_turn = sqlSelect("SELECT users.user_id, username, type FROM `users` INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_id = {$story} AND on_turn = 1;");

// Not ready
if ($status[0]['status'] == 0) {
	$writer = sqlSelect("SELECT max_writers, (SELECT COUNT(story_writers.user_id) FROM story_writers WHERE story_id = {$story}) AS num_of_writers, started_by_user FROM story WHERE story_id = {$story};");
	require 'views/write/not_ready.php';
	$script = 'js/write.not_ready.js';
}

// Started
else if ($status[0]['status'] == 1) {
	require 'views/write/started.php';
	$script = "js/write.started.php?story=$story";
	unset($_SESSION['story']);
}

require 'footer.php';

?>