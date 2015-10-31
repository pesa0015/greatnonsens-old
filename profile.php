<?php

session_start();

if (!isset($_GET['view']) || empty($_GET['view']))
	header("Location: {$_SESSION['user']['name']}");

require 'header.php';

if (isset($_GET['view'])) {
	switch ($_GET['view']) {
		case 'friends':
			$friends = sqlSelect("SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN (SELECT friends.friend_request_id, CASE WHEN friends.user_id = {$_SESSION['user']['id']} THEN friends.friend_user_id ELSE friends.user_id END person_id FROM friends WHERE (friends.user_id = {$_SESSION['user']['id']} OR friends.friend_user_id = {$_SESSION['user']['id']}) AND status = 1) friends ON users.user_id = friends.person_id;");
			$received_friend_requests = sqlSelect("SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN friends ON users.user_id = friends.user_id WHERE friend_user_id = {$_SESSION['user']['id']} AND status = 0;");
			$sent_friend_requests = sqlSelect("SELECT friends.friend_request_id, users.user_id, users.username FROM users INNER JOIN friends ON users.user_id = friends.friend_user_id WHERE friends.user_id = {$_SESSION['user']['id']} AND status = 0;");
			require 'views/profile/friends.php';
			$script = 'js/profile.friends.js';
			break;
		case 'change_password':
			require 'views/profile/change_password.php';
			break;
		default:
			$sql_user = sqlSelect("SELECT username, personal_text, profile_img FROM `users` WHERE user_id = {$_GET['view']};");
			require 'views/profile/who.php';
			$script = 'js/profile.who.js';
			break;
	}
}

require 'footer.php';

?>