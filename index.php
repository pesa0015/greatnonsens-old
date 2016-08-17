<?php

session_start();
require 'layout/header.php';
require 'views/index/welcome.php';
// if (isset($saveGuest)) {
// 	$firebaseParameter = 'var me = ' . $_SESSION['me']['id'] . ';';
// 	$firebase = true;
// }
$script = 'js/index.new_story.js';
require 'footer.php';

?>