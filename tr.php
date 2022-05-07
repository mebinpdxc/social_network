<?php
// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg,70);

// send email
ini_set('SMTP', 'myserver');
ini_set('smtp_port', '25');
mail("vijaykeerthi709@gmail.com","My subject",$msg);
?>