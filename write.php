<?php

if (!isset($_GET['story']) || empty($_GET['story']) || !is_numeric($_GET['story']))
	header('Location: /');

$story = (int)$_GET['story'];

session_start();

require 'header.php';

if (isset($_GET['not_ready']) && empty($_GET['not_ready'])) {
	// $guest_id = (!$_SESSION['guest_id']) ? $guest_id = 0 : $_SESSION['guest_id'];
	// $user_id = (!isset($_SESSION['user'])) ? $user_id = 0 : $_SESSION['user']['id'];
	// $writer = sqlSelect("SELECT story.max_writers, story.started_by_user, story.started_by_guest, (SELECT CASE story_writers.user_id WHEN NULL THEN story_writers.guest_id ELSE story_writers.user_id END AS id FROM story_writers WHERE story_id = {$story} and user_id = {$user_id} OR guest_id = {$guest_id}) AS me FROM story INNER JOIN story_writers ON story.story_id = story_writers.story_id WHERE story_writers.story_id = {$story};");
	// $started_by = (!empty($writer[0]['started_by_user'])) ? $writer[0]['started_by_user'] : $writer[0]['started_by_guest'];
	// $me = isset($_SESSION['guest_id']) && is_numeric($_SESSION['guest_id']) ? $_SESSION['guest_id'] : $_SESSION['user']['id'];

	// if (isset($_SESSION['user']['id'])) $me = $_SESSION['user']['id'];
	// else if (isset($_SESSION['guest_id'])) $me = $_SESSION['guest_id'];
	// if (!empty($writer[0]['started_by_user'])) $started_by = $writer[0]['started_by_user'];
	// else if (!empty($writer[0]['started_by_guest'])) $started_by = $writer[0]['started_by_guest'];
	$writer = sqlSelect("SELECT max_writers, started_by_user FROM story WHERE story_id = {$story};");
	require 'views/write/not_ready.php';
	$script = "js/write.not_ready.php?story=$story&max_writers={$writer[0]['max_writers']}&started_by={$writer[0]['started_by_user']}";
}

else {
	require 'views/write/started.php';
	$script = "js/write.started.php?story=$story";
	unset($_SESSION['story']);
}

// if (isset($_GET['wait']) && empty($_GET['wait'])) {
// 	require 'views/write/wait.php';
// }

// if (isset($_GET['my_turn']) && empty($_GET['my_turn'])) {
// 	$nonsens_mode = sqlSelect("SELECT nonsens_mode FROM `story` WHERE story_id = {$story}");

// 	if (isset($nonsens_mode) && $nonsens_mode[0]['nonsens_mode'] == 'Yes')
// 	  $sql_latest = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1;");
// 	else
// 	  $sql_last_rows = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id");
// 	$sql_rows_left = sqlSelect("SELECT max_rows - total_rows AS rows_left FROM `story` WHERE story_id = {$story}");
// 	$flexible = sqlSelect("SELECT flexible FROM story WHERE story_id = {$story};");
// 	$writers = sqlSelect("SELECT users.user_id, users.username FROM users INNER JOIN story_writers WHERE users.user_id IN (SELECT story_writers.user_id FROM story_writers WHERE story_writers.story_id = {$story} AND story_writers.user_id != {$_SESSION['user_id']}) GROUP BY user_id;");
// 	$num_of_writers = count($writers);
// 	$i = 0;

// 	require 'views/write/story.php';
// }

require 'footer.php';

?>