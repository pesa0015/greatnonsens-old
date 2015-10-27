<?php

session_start();
// require 'functions/sql_helpers.php';
// $lang = $_SESSION['lang'];
// sqlInsert("UPDATE users_activity SET last_activity = now() WHERE user_id = {$_SESSION['user_id']} ORDER BY id DESC LIMIT 1;");
session_destroy();
// session_start();
// $_SESSION['lang'] = $lang;
header('location: /');

?>