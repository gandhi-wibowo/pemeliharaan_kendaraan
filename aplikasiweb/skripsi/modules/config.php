<?php
#set error mode
error_reporting(E_ALL & ~E_NOTICE);

#set timezone
date_default_timezone_set('Asia/Jakarta');

#define required constant
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD','');
define('DB_NAME', 'db_opr');
define('BASEURL', 'http://'.$_SERVER['HTTP_HOST'].'/marisonervan/skripsi');
define('APPURL', BASEURL .'/apps');
define('APIURL', BASEURL .'/api');
define('NOTIFY_INTERVAL', '7,3,1'); #in days
define('FCM_SERVER_KEY', 'AIzaSyB7GDpwB18TbdJLIxbQC3fIVtKYxlk6fDU');
define('FCM_SENDER_ID', '752013910645');
?>
