<?php

require_once("../vendor/autoload.php");

$mailer = new Swift_Mailer(new Swift_SmtpTransport("localhost", 25));
$message = new Swift_Message();
//
$message->setFrom("test@dev2.m-fr.net");
$message->setTo("");
$message->setSubject("subject");
$message->setBody("content");

//
$r = $mailer->send($message);
var_dump($r);
