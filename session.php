<?php

require 'mysql/query.php';

if (!isset($_COOKIE['guest_id'])) {
    if (sqlAction("INSERT INTO guests (theme, expired, date) VALUES (null, 0, now());")) {
        $id = sqlSelect("SELECT MAX(guest_id) AS id FROM guests");
        $_SESSION['guest_id'] = $id[0]['id'];
        $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
        $_SESSION['theme'] = 'superhero';
        setcookie('guest_id', $id[0]['id'], strtotime('today 23:59'));
    }
}

else if (isset($_COOKIE['guest_id']) && !isset($_SESSION['guest'])) {
    $_SESSION['guest_id'] = $_COOKIE['guest_id'];
    $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
    $_SESSION['theme'] = 'superhero';
}

?>