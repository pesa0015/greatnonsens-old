<?php

require '../lib/Pusher/config.php';
session_start();
echo $pusher->socket_auth('private-' . $_SESSION['me']['id'], $_POST['socket_id']);

?>