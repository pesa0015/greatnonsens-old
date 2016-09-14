<?php

$route = explode('/',$_SERVER['REQUEST_URI']);
if (!isset($route[2]) || empty($route[2]) || !is_numeric($route[2]))
	header('Location: /');

$story = (int)$route[2];

$baseHref = '../';
if (isset($route[3]))
	$baseHref = '../../';

session_start();

require 'layout/header.php';

// Check if story exists
$title = sqlSelect("SELECT title FROM story WHERE story_id = {$story};");
if (!$title): ?>
	<h1>Den här storyn finns inte.</h1>
<?php else:
$status = sqlSelect("SELECT status, join_public FROM story WHERE story_id = {$story};");
$on_turn = sqlSelect("SELECT users.user_id, username, type FROM `users` INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_id = {$story} AND on_turn = 1;");
$me = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} AND user_id = {$_SESSION['me']['id']};");
$opening_words = sqlSelect("SELECT words FROM row WHERE story_id = {$story} ORDER BY row_id LIMIT 1;");

$words = '';
$nonsens_mode = sqlSelect("SELECT nonsens_mode FROM story WHERE story_id = {$story};");
if ($nonsens_mode[0]['nonsens_mode'] == 1) {
	$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1;");
}
else {
	$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} AND row_id != (SELECT MAX(row_id) FROM row WHERE story_id = {$story});");
}
require 'views/write/header.php';

?>
<script>var nonsens_mode = <?=($nonsens_mode[0]['nonsens_mode'] == 1) ? 'true' : 'false'; ?>;</script>
<?php

// Not ready
if ($status[0]['status'] == 0) {
	$writer = sqlSelect("SELECT max_writers, (SELECT COUNT(story_writers.user_id) AS num_of_writers FROM story_writers WHERE story_id = {$story}) AS num_of_writers, started_by_user FROM story WHERE story_id = {$story};");
	require 'views/write/not_ready.php';
	$script = 'js/write.not_ready.js';
}

// Started
else if ($status[0]['status'] == 1) {
	require 'views/write/started.php';
	// $script = "js/write.started.php?story=$story";
	if ($on_turn[0]['user_id'] == $_SESSION['me']['id']) {
		$script = "js/write.my_turn.js";
	}
	else {
		$script = "js/write.waiting.js";
	}
	unset($_SESSION['story']);
}
// Finished
else if ($status[0]['status'] == 2) {
	require 'views/write/finished.php';
}

endif;

require 'views/write/footer.php';

require 'footer.php';

?>