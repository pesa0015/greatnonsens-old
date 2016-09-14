<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	session_start();
	if (!is_numeric($_SESSION['me']['id']) && !is_numeric($_POST['story']))
		die;

	require '../../../mysql/query.php';
		
	$story = $_POST['story'];

	$startedByMe = sqlSelect("SELECT user_id FROM story_writers WHERE story_id = {$story} ORDER BY id LIMIT 1;");
	if ($startedByMe[0]['user_id'] == $_SESSION['me']['id'])
		die;
	if (sqlAction("DELETE FROM story_writers WHERE story_id = {$story} AND user_id = {$_SESSION['me']['id']};")) {
		echo json_encode(array('success' => true, 'story_id' => $story));
		die;
	}
}

?>