<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	session_start();

	require '../../../mysql/query.php';
	require '../../../lang/config.php';

	if (isset($_SESSION['user'])) {
		if (isset($_GET['view']) && isset($_GET['id'])) {
			if (is_numeric($_GET['view']) && is_numeric($_GET['id'])) {
					$member = sqlSelect("SELECT groups.id, groups.name FROM users INNER JOIN `group_members` INNER JOIN groups ON users.user_id = group_members.user_id AND groups.id = group_members.group_id WHERE group_members.id = {$_GET['id']};");
					if (sqlAction("UPDATE group_members SET status = 1, joined = now() WHERE id = {$_GET['id']};")) {

						if (sqlAction("INSERT INTO group_news_feed (group_id, user_id, type, what, date) VALUES ({$_GET['view']}, {$_SESSION['user']['id']}, 'accepted_invite', '', now());")) {
							require '../../../lib/Firebase/url.php';
							getFirebase($require = true);

							$firebase = new Firebase\FirebaseLib($url, $token);

							$firebaseArray = array(
								'data' => 'false',
								'from' => $_SESSION['user']['id'],
								'name' => "{$_SESSION['user']['name']}",
								'time' => time(),
								'type' => 'accepted_invite',
								'unread' => 'true'
							);

							$firebase->push("/groups/{$member[0]['id']}/groups_news_feed/", $firebaseArray);

							header("Location: ../../../groups?view={$_GET['view']}&show=members");
						}
					}
				}
			}
		}
	}
}

?>