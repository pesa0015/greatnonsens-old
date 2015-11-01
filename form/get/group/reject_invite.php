<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	if (isset($_SESSION['user'])) {
		if (isset($_GET['view']) && isset($_GET['id'])) {
			if (is_numeric($_GET['view']) && is_numeric($_GET['id'])) {
					$member = sqlSelect("SELECT groups.id, groups.name FROM users INNER JOIN `group_members` INNER JOIN groups ON users.user_id = group_members.user_id AND groups.id = group_members.group_id WHERE group_members.id = {$_GET['id']};");
					if (sqlAction("DELETE FROM group_members WHERE id = {$_GET['id']};")) {

						if (sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$_GET['view']}, {$_SESSION['user']['id']}, 'rejected_invite', '', now());")) {
							require '../../../lib/Firebase/url.php';
							getFirebase($require = true);

							$firebase = new Firebase\FirebaseLib($url, $token);

							$firebaseArray = array(
								'from' => array('user_id' => $_SESSION['user']['id'], 'user_name' => "{$_SESSION['user']['name']}"),
								'group' => array('group_id' => $_GET['group_id'], 'group_name' => "{$_GET['group_name']}"),
								'story' => 'false',
								'time' => time(),
								'type' => 'rejected_invite',
								'unread' => 'true'
							);

							$firebase->push(usersNewsFeed($member[0]['user_id']), $firebaseArray);

							header("Location: ../../../groups?view={$_GET['view']}&show=members");
						}
					}
				}
			}
		}
	}
}

?>