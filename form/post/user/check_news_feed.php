<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();

	require '../../../mysql/query.php';

	$news_type = sqlEscape($_POST['news_type']);

	$userNews = sqlSelect("SELECT users_news_feed.id, have_read, news_type.type, groups.id AS group_id, name AS group_name, story.story_id, title, users.user_id, username FROM users_news_feed LEFT JOIN groups ON groups.id = users_news_feed.group_id LEFT JOIN story ON story.story_id = users_news_feed.story_id LEFT JOIN users ON users.user_id = users_news_feed.writer_id INNER JOIN `news_type` ON news_type.id = users_news_feed.type_id WHERE users_news_feed.user_id = {$_SESSION['me']['id']} AND news_type.type = '{$news_type}' AND have_read = 0;");
	if ($userNews) {
		echo json_encode($userNews);
		die;
	} else echo 'no news';
}

?>