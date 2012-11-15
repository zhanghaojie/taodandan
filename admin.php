<?php
header("Content-type: text/html; charset=utf-8");
if (!ini_get('display_errors')) {
    ini_set('display_errors', 1);
}
error_reporting(-1);

define('APP_DEBUG', true);
define('THINK_PATH', './ThinkPHP/');
define('APP_NAME', 'admin');
define('APP_PATH', './admin/');

require THINK_PATH.'ThinkPHP.php';

?>