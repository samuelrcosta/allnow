<?php
require 'environment.php';
$config = array();
if(ENVIRONMENT == 'development'){
    define("BASE_URL", 'http://localhost/php/allnow');
    define("SERVER_URL", '/php/allnow/');
    $config['dbname'] = 'name_baseData';
    $config['host'] = 'localhost';
    $config['dbuser'] = 'root';
    $config['dbpass'] = 'root';
} else{
    define("BASE_URL", 'https://allnow.com.br');
    define("SERVER_URL", '/');
    $config['dbname'] = 'name_baseData';
    $config['host'] = 'host.database.com.br';
    $config['dbuser'] = 'rootUser';
    $config['dbpass'] = 'root123';
}

$config['google_captch_secret'] = 'GOOGLE RE-CAPTCHA SECRET';

$config['fb_appId'] = 'FACEBOOK APP_ID';
$config['fb_secretKey'] = 'FACEBOOK SECRET_KEY';

global $MailHost;
global $MailPort;
global $MailSecurity;
global $MailUsername;
global $MailPassword;
global $MailName;
$MailSecurity = "tls";
$MailHost = "smtp.host.com.br";
$MailPort = "25";
$MailUsername = "email@mail.com";
$MailPassword = "password";
$MailName = "AllNow";

global $MAILCHIMP_API_KEY;
global $MAILCHIMP_LIST_ID;
$MAILCHIMP_API_KEY = 'MAIL_CHIMP_API_KEY';
$MAILCHIMP_LIST_ID = 'MAIL_CHIMP_LIST_ID';


global $db;
try {
    $db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'].";charset=utf8", $config['dbuser'], $config['dbpass']);
}catch (PDOExeption $e){
    echo "ERRO: ".$e->getMessage();
}
