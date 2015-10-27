<?php

// if (!isset($_GET['show']))
// 	header("Location: groups?view={$_GET['view']}&show=chat");

session_start();

require 'header.php';

if (isset($_GET['view'])) {
	if (is_numeric($_GET['view'])) {
		$group_id = $_GET['view'];
		require 'views/groups/nav.php';

		if (!isset($_GET['show']))
			require 'views/groups/description.php';
		else {
			switch ($_GET['show']) {
				case 'chat':
					require 'views/groups/chat.php';
					break;
				case 'news':
					require 'views/groups/news.php';
					break;
				case 'members':
					require 'views/groups/members.php';
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
					require 'views/groups/';
					break;
				default:
					require 'views/groups/chat.php';
					break;
			}
		}
	}
	else if (!is_numeric($_GET['view'])) {
		switch ($_GET['view']) {
			case 'new':
				require 'views/groups/new.php';
				break;
			case 'search':
				require 'views/groups/';
				break;
			case 'more':
				require 'views/groups/';
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