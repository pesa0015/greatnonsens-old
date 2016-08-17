<?php

require 'mysql/query.php';

if (!isset($_COOKIE['cookie_information'])) {
    setcookie('cookie_information', true, time()+31556926);
}

if (!isset($_COOKIE['guest_id'])) {
    $guest_id = sqlAction("INSERT INTO users (type, facebook_id, username, password, email, registration_date, profile_img, personal_text, reset_password_key) VALUES (0, null, 'Guest', null, null, now(), null, null, null);", $getLastId = true);
    if (is_numeric($guest_id)) {
        $_SESSION['guest_id'] = $guest_id;
        $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
        $_SESSION['me']['id'] = $guest_id;
        $_SESSION['me']['name'] = 'Guest';
        setcookie('guest_id', $guest_id, strtotime('today 23:59'));
        $saveGuest = true;
    }
}

else if (isset($_COOKIE['guest_id']) && !isset($_SESSION['guest'])) {
    $_SESSION['guest_id'] = $_COOKIE['guest_id'];
    $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);

    if (isset($_SESSION['user']['id'])) {
        $_SESSION['guest_id'] = false;
        $_SESSION['me']['id'] = $_SESSION['user']['id'];
        $_SESSION['me']['name'] = $_SESSION['user']['name'];
    }
    else {
        $_SESSION['me']['id'] = $_SESSION['guest_id'];
        $_SESSION['me']['name'] = 'Guest';
    }
}

?>