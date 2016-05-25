<?php

define('DATABASE_NAME', "socialsite");
define('DATABASE_USER', "root");
define('DATABASE_PASS', "");
define('DATABASE_HOST', "localhost");
define('RANDOM_S', 'Yh5YJGeZfbQWXL2pbtd5');
define('TITLE', 'Social Site');

try
{
    $handle = new PDO('mysql:host = '.DATABASE_HOST.';dbname='.DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
    $handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e)
{
    echo $e->getMessage();
    exit;
}


include('user.php');
$u = new User($handle); // common object


function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}


if(is_session_started() == FALSE) session_start();

