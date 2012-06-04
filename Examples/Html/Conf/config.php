<?php
if (!defined('THINK_PATH')) exit();
return array(
	'HTML_CACHE_ON'=>true,//开启静态缓存
	'HTML_CACHE_TIME'=>1, //有效期时间单位是秒
	'HTML_READ_TYPE'=>0,  //静态缓存读取方式 0 readfile 1 redirect
    /*HTML_READ_TYPE 页面静态化后读取的规则
    一种是直接读取缓存文件输出（readfile方式HTML_READ_TYPE 为0） 这是系统默认的方式，
    属于隐含静态化，用户看到的URL地址是没有变化的。
    另外一种方式是重定向到静态文件的方式（HTML_READ_TYPE为1），这种方式下面，用户可以看到URL的地址属于静态页面地址，比较直观。
    */
);
?>