<?php

session_start();

require 'header.php';

if (isset($_GET['view'])) {
	switch ($_GET['view']) {
		case 'new_story':
			require 'views/index/new_story.php';
			break;
		case 'choose_story':
			require 'views/index/choose_story.php';
			break;
		default:
			require 'views/index/welcome.php';
			break;
	}
}

else
	require 'views/index/welcome.php';

require 'footer.php';

?>