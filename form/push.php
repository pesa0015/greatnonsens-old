<?php

require '../lib/Pusher/config.php';

  $pusher->trigger('private-148', 'news', json_encode(array('type' => 'news', 'value' => 2)));
  // $response = $pusher->get( '/channels/test_channel/subscription_count' );
  // $info = $pusher->get_channel_info('test_channel', array('info' => 'subscription_count'));
  // print_r($info);die;

?>