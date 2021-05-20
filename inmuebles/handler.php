<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
Tested working with PHP5.4 and above (including PHP 7 )

 */
require_once './vendor/autoload.php';

use FormGuide\Handlx\FormHandler;


$pp = new FormHandler(); 

$validator = $pp->getValidator();
$validator->fields(['name','email'])->areRequired()->maxLength(50);
$validator->field('email')->isEmail();
$validator->field('message')->maxLength(6000);

$mailer = $pp->getMailer();

//Using SMTP

$mailer->isSMTP();
$mailer->SMTPAuth = true;
$mailer->SMTPSecure = 'tls';
$mailer->Host       = "smtp.mail.yahoo.com";
$mailer->Port	= "587";	
$mailer->Username   = "aagilli20@yahoo.com.ar";
$mailer->Password   = "opou icgl peho upyl";
$mailer->setFrom('aagilli20@yahoo.com.ar', 'Form');

$pp->sendEmailTo('aagilli20@yahoo.com.ar'); // ← Your email here

echo $pp->process($_POST);