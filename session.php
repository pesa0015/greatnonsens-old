<?php

require 'mysql/query.php';

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = '?';
    return $ipaddress;
}

if (!isset($_SESSION['guest'])) {
	// Check if ip_adress already is registered
	// $ip = get_client_ip();
    $ip = '80.217.220.108';
	$ip_adress = sqlSelect("SELECT ip_adress FROM users WHERE ip_adress = '{$ip}';");
	if (empty($ip_adress)) {
        if (sqlAction("INSERT INTO users (guest, ip_adress, username, password, email, registration_date, profile_img, personal_text, reset_password_key, bootstrap_css) VALUES (1, '{$ip}', 'Guest', null, null, now(), null, null, null, 'superhero');")) {
            $user_id = sqlSelect("SELECT user_id, theme FROM users WHERE ip_adress = '{$ip}';");
            if (!empty($user_id)) {
                $_SESSION['user_id'] = $user_id[0]['user_id'];
                $_SESSION['user_name'] = 'Guest';
                $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
                $_SESSION['theme'] = $user_id[0]['theme'];
            }
        }	   
	}
	
    else {
        $user_id = sqlSelect("SELECT user_id, bootstrap_css FROM users WHERE ip_adress = '{$ip}';");
        if (!empty($user_id)) {
            $_SESSION['user_id'] = $user_id[0]['user_id'];
            $_SESSION['user_name'] = 'Guest';
            $_SESSION['lang'] = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
            // $_SESSION['theme'] = $user_id[0]['bootstrap_css'];
        }
    }
}

?>