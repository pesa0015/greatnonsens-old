<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	if (isset($_SESSION['user'])) {
		if (isset($_GET['view']) && isset($_GET['admin'])) {
			if (is_numeric($_GET['view']) && is_numeric($_GET['admin'])) {
				$group_info = sqlSelect("SELECT admin FROM `group_members` WHERE group_id = {$_GET['view']} AND user_id = {$_SESSION['user']['id']};");

				if ($group_info[0]['admin'] == 1) {
					if (sqlAction("UPDATE group_members SET admin = 1 WHERE id = {$_GET['admin']};")) {
						$member = sqlSelect("SELECT users.user_id, users.username, groups.id, groups.name FROM users INNER JOIN `group_members` INNER JOIN groups ON users.user_id = group_members.user_id AND groups.id = group_members.group_id WHERE group_members.id = {$_GET['admin']};");

						if (sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$_GET['view']}, {$_SESSION['user']['id']}, 'made_admin', '{\"id\":{$member[0]['user_id']}, \"username\":\"{$member[0]['username']}\"}', now());")) {
							require '../../../lib/Firebase/url.php';
							getFirebase($require = true);

							$firebase = new Firebase\FirebaseLib($url, $token);

							$firebaseArray = array(
								'data' => array('group_id' => "{$member[0]['id']}", 'group_name' => "{$member[0]['name']}"),
								'from' => $_SESSION['user']['id'],
								'name' => "{$_SESSION['user']['name']}",
								'time' => time(),
								'type' => 'made_admin',
								'unread' => 'true'
							);

							$firebase->push("/users_news_feed/{$member[0]['user_id']}/", $firebaseArray);

							header("Location: ../../../groups?view={$_GET['view']}&show=members");
						}
					}
				}
			}
		}
	}
}

?>