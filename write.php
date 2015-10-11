<?php

if (!isset($_GET['story']) || empty($_GET['story']) || !is_numeric($_GET['story']))
	header('Location: /');

$story = (int)$_GET['story'];

session_start();

require 'header.php';

$nonsens_mode = sqlSelect("SELECT nonsens_mode FROM `story` WHERE story_id = {$story}");

if (isset($nonsens_mode) && $nonsens_mode[0]['nonsens_mode'] == 'Yes')
  $sql_latest = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1;");
else
  $sql_last_rows = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story} ORDER BY row_id");
$sql_rows_left = sqlSelect("SELECT max_rows - total_rows AS rows_left FROM `story` WHERE story_id = {$story}");
$flexible = sqlSelect("SELECT flexible FROM story WHERE story_id = {$story};");
$writers = sqlSelect("SELECT users.user_id, users.username FROM users INNER JOIN story_writers WHERE users.user_id IN (SELECT story_writers.user_id FROM story_writers WHERE story_writers.story_id = {$story} AND story_writers.user_id != {$_SESSION['user_id']}) GROUP BY user_id;");
$num_of_writers = count($writers);
$i = 0;

require 'views/write/story.php';

require 'footer.php';

?>