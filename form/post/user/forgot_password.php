<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	session_start();
	require '../../../mysql/query.php';

	if (strlen($_POST['user']) < 3)
		die;

	$user = $_POST['user'];

	$getUser = sqlSelect("SELECT email, username FROM users WHERE username = '{$user}' OR email = '{$user}';");
	if ($getUser) {
		$token = crypt(md5(time()));
		$token = str_replace('/','.',$token);
		if (sqlAction("UPDATE users SET reset_password_key = '{$token}' WHERE username = '{$getUser[0]['username']}';")) {
			require '../../class.phpmailer.php';
			$to = $getUser[0]['email'];
			$text = '<h1>Lösenord återställning</h1><br /><div>Fortsätt genom att klicka på den <a href="https://greatnonsens.com/login/' . $getUser[0]['email'] . '/' . $token . '">här länken</a>.</div>';

			$mail = new PHPMailer;
			$mail->CharSet = 'UTF-8';
			$mail->setFrom('info@greatnonsens.com', 'Great nonsens');
			$mail->addAddress($to, $getUser[0]['username']);
			$mail->Subject = 'Glömt lösenord';
			$mail->Body = $text;
			$mail->IsHTML(true);

			if (!$mail->send()) {
			    // echo "Mailer Error: " . $mail->ErrorInfo . '<br />';
			    // echo '<pre>'.print_r(error_get_last(), true).'</pre>';
			} else echo json_encode(array('success' => true, 'users_mail' => $getUser[0]['email']));
		}
	}
	else echo json_encode(array('success' => false));
}

?>