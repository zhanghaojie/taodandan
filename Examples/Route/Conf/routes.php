<?php
    return array(
        array('Category','Blog/category','id'),
        //简单路由定义：array('路由定义','分组/模块/操作名', '路由对应变量','额外参数'),
        array('/^Blog\/(\d+)$/is','Blog/read','id'),
        //正则路由定义规则：array('正则定义','分组/模块/操作名', '路由对应变量','额外参数'),
        array('/^Blog\/(\d+)\/(\d+)/is','Blog/archive','year,month'),
    );
?>