<?php
require_once 'google/appengine/api/mail/Message.php';
use google\appengine\api\mail\Message;

session_cache_limiter('nocache');
header('Expires: ' . gmdate('r', 0));

header('Content-type: application/json');

// require 'php-mailer/PHPMailerAutoload.php';

// Your email address
$to = 'juergen@schlierf.eu';

$subject = $_POST['subject'];

if($to) {

	$name = $_POST['name'];
	// $email = $_POST['email'];
	$email = 'anything@homepage-258600.appspotmail.com';
	
	$fields = array(
		0 => array(
			'text' => 'Name',
			'val' => $_POST['name']
		),
		1 => array(
			'text' => 'Email address',
			'val' => $_POST['email']
		),
		2 => array(
			'text' => 'Message',
			'val' => $_POST['message']
		)
	);
	
	$message = "";
	
	foreach($fields as $field) {
		$message .= $field['text'].": " . htmlspecialchars($field['val'], ENT_QUOTES) . "<br>\n";
	}

	$message_body = 'Eine Nachricht von ' . $_POST['name'] . "\n\n";
	$message_body = $message_body . 'Name: ' . $_POST['name'] . "\n";
	$message_body = $message_body . 'E-Mail: ' . $_POST['email'] . "\n";
	$message_body = $message_body . 'Betreff: ' . $_POST['subject'] . "\n\n";
	$message_body = $message_body . "Nachricht:\n" . $_POST['message'] . "\n";

	$mail_options = [
		'sender' => 'Homepage-Nachricht@homepage-258600.appspotmail.com',
		'to' => 'juergen@schlierf.eu',
		'subject' => 'Homepage-Nachricht von ' . $_POST['name'],
		'textBody' => $message_body
	];

	try {
		$message = new Message($mail_options);
		$message->send();
	} catch (InvalidArgumentException $e) {
		echo 'error: ';
		$arrResult = array ('response'=>'error');
	}

/*
	$mail = new PHPMailer;

	$mail->IsSMTP();                                      // Set mailer to use SMTP

	// Optional Settings
	$mail->Host = 'smtp-relay.gmail.com';				  // Specify main and backup server
	$mail->SMTPAuth = false;                             // Enable SMTP authentication
	//$mail->Username = 'username';             		  // SMTP username
	//$mail->Password = 'secret';                         // SMTP password
	//$mail->Port       = 587;								// SMTP port
	//$mail->SMTPSecure = 'tls';                          // Enable encryption, 'ssl' also accepted

	$mail->From = $email;
	$mail->FromName = $_POST['name'];
	$mail->AddAddress($to);								  // Add a recipient
	$mail->AddReplyTo($email, $name);

	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->CharSet = 'UTF-8';

	$mail->Subject = $subject;
	$mail->Body    = $message;

	if(!$mail->Send()) {
	   $arrResult = array ('response'=>'error');
	}

*/
	$arrResult = array ('response'=>'success');

	echo json_encode($arrResult);
} else {

	$arrResult = array ('response'=>'error');
	echo json_encode($arrResult);

}
?>
