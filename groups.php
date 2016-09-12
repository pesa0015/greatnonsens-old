<?php

// if (!isset($_GET['show']))
// 	header("Location: groups?view={$_GET['view']}&show=chat");
$route = explode('/',$_SERVER['REQUEST_URI']);
$baseHref = '../';
if (isset($route[2]))
	$groupId = $route[2];
if (isset($route[3])) {
	$page = $route[3];
	$baseHref = '../../';
}
if (isset($route[4])) {
	$subPage = $route[4];
	$baseHref = '../../../';
}
if (!isset($route[4]))
	$subPage = false;
session_start();
require 'layout/header.php';

if (isset($groupId)) {
	if (is_numeric($groupId)) {
		// $group_info = sqlSelect("SELECT groups.name, groups.description, groups.secret, groups.chat_is_public, IF (EXISTS(SELECT user_id FROM group_members WHERE group_id = {$groupId} AND user_id = {$_SESSION['user']['id']}), user_id, 0) AS user_id, group_members.status, group_members.admin FROM groups INNER JOIN group_members ON groups.id = group_members.group_id WHERE group_id = {$groupId};");
		$group_info = sqlSelect("SELECT groups.id, groups.name, groups.description, groups.secret, groups.open, groups.chat_is_public FROM groups WHERE id = {$groupId};");
		$member = sqlSelect("SELECT admin, group_members.status FROM groups INNER JOIN group_members ON groups.id = group_members.group_id WHERE group_id = {$groupId} AND group_members.user_id = {$_SESSION['user']['id']};");
		// if ($group_info[0]['user_id'] == $_SESSION['user']['id'] && $group_info[0]['status'] == 1)
			// sqlAction("INSERT INTO groups_activity_history (user_id, group_id) VALUES ({$_SESSION['user']['id']}, {$groupId});");
		if ($group_info)
			require 'views/groups/nav.php';
		if ($group_info[0]['secret'] == 0 && !isset($page))
			require 'views/groups/description.php';
		else if ($group_info[0]['secret'] == 0 && isset($page)) {
			switch ($page) {
				case 'stories':
					require 'views/groups/stories.php';
					$script = '';
					break;
				case 'chat':
					require 'views/groups/chat.php';
					$script = "js/groups.chat.php?view={$groupId}";
					break;
				case 'news':
					require 'views/groups/news.php';
					break;
				case 'members':
					require 'views/groups/members.php';
					$script = 'js/groups.members.js';
					break;
				case 'invite':
					require 'views/groups/invite.php';
					$script = 'js/groups.invite.js';
					break;
				case 'join':
					require 'views/groups/join.php';
					break;
				case 'description':
					require 'views/groups/description.php';
					break;	
				case 'new_story':
					require 'views/groups/new_story.php';
					break;
				default:
					require 'views/groups/chat.php';
					break;
			}
		}
		else if (!$group_info)
			require 'views/groups/not_exist.php';
	}
	else if (!is_numeric($groupId)) {
		switch ($groupId) {
			case 'new':
				require 'views/groups/new.php';
				$script = 'js/groups.new.js';
				break;
			case 'invites':
				require 'views/groups/invites.php';
				break;
			default:
				require 'views/groups/new.php';
				break;
		}
	}
}

else
	require 'views/groups/new.php';

require 'footer.php';

?>