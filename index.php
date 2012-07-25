<?php
header("Content-type: text/html; charset=utf-8");
if (!ini_get('display_errors')) {
    ini_set('display_errors', 1);
}
error_reporting(-1);

require 'config.inc.php';
define('APP_NAME', 'top');
define('APP_PATH', './top/');

require THINK_PATH.'ThinkPHP.php';

?>