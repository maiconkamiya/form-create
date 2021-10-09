<?php
define('RAIZ_PATH', 'aplicacao/form-create/');
define('APP_ROOT', 'http'.(isset($_SERVER['HTTPS']) ? (($_SERVER['HTTPS']=="on") ? "s" : "") : "") .'://' . $_SERVER['HTTP_HOST'] . '/'. RAIZ_PATH);

define('TITLE', 'INDEX TITLE');
define('DESCRIPTION', 'INDEX DESCRIPTION');
define('KEYWORDS', 'INDEX KEYWORDS');

define('SOAPCEPUSER', 'maiconkamiya');
define('SOAPCEPPWD', 'mstakeshi88');

session_start();

date_default_timezone_set('America/Porto_Velho');

require 'vendor/autoload.php';

use criativa\lib\System;

$System = new System();
$System->run();