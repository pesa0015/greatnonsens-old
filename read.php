<?php

$route = explode('/',$_SERVER['REQUEST_URI']);
if (!isset($route[2]) || empty($route[2]) || !is_numeric($route[2]))
	header('Location: /');

$baseHref = '../';
if (isset($route[3]))
	$baseHref = '../../';

$story = (int)$route[2];
if (!isset($route[3]) || isset($route[3]) && empty($route[3])) {
	session_start();
	require 'layout/header.php';
}
else require 'mysql/query.php';
$title = sqlSelect("SELECT title FROM story WHERE story_id = {$story} AND status = 2;");
$words = sqlSelect("SELECT words FROM `row` WHERE story_id = {$story};");
$finished = sqlSelect("SELECT date FROM `row` WHERE story_id = {$story} ORDER BY row_id DESC LIMIT 1;");
$writers = sqlSelect("SELECT type, users.user_id, username FROM users INNER JOIN story_writers ON users.user_id = story_writers.user_id WHERE story_writers.story_id = {$story};");
if ($title && isset($route[3]) && $route[3] === 'pdf') {
	require 'views/read/with_pdf.php';
	die;
}
if ($title): require 'views/read/without_pdf.php';
else: ?>
<h1>Den här storyn finns inte.</h1>
<?php endif; require 'footer.php'; ?>