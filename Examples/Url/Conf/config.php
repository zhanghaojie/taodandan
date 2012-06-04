<?php
//系统支持伪静态URL设置，可以通过设置URL_HTML_SUFFIX参数随意在URL的最后增加你想要的静态后缀，
//而不会影响当前操作的正常执行。
return array(
	'HTML_URL_SUFFIX'=>'.shtml',
);
//伪静态设置后，如果需要动态生成一致的URL，可以使用U方法在模板文件里面生成URL。
?>