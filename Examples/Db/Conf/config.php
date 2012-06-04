<?php
    if (!defined('THINK_PATH')) exit();
    $config = require '../config.php';
    $array = array(
        'APP_DEBUG' => 1,
        'SHOW_PAGE_TRACE'=>1,    //显示调试信息
    );
    return array_merge($config, $array);
?>