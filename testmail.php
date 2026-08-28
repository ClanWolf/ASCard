<?php
    ini_set('display_errors', 1);
    error_reporting( E_ALL );
	set_error_handler("var_dump");

    $from = "admin@ascard.net";
    $to = "warwolfen@gmail.com";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from . "\r\n";
	$headers .= "Reply-To:" . $from . "\r\n";
	$additional_params = "-f " . $from;

	mail($to, $subject, $message, $headers, $additional_params);

    echo "Test email sent.";
?>
