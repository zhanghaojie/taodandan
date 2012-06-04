<?php
define('APP_DEBUG', false);
define('APP_AUTH_TYPE', 'TOP');
define('APP_AUTH_CODE', 1);
define('APP_TOP_CODE', 2);

define('THINK_PATH', './ThinkPHP');
define('STRIP_RUNTIME_SPACE', false);
define('APP_HOST', 'http://localhost');

define('NO_CACHE_RUNTIME', true);

//淘宝相关配置
define('TB_REDIRECT_URI', APP_HOST . '/Login/login.html');
define('TB_SDK_PATH', './libs/taobao_sdk');

if (APP_AUTH_TYPE === 'TOP') {
	define('TB_IS_SIGNAL', true);
}
else {
	define('TB_IS_SIGNAL', false);
}

if (APP_DEBUG) {
	define('TB_IS_SANDBOX', true);
	define('TB_APP_KEY', '12661652');
	define('TB_APP_SECRET', 'sandbox1e909f2bc8f251b94861bdabf');
	
	define('TB_TOP_AUTH_URL', 'http://container.api.tbsandbox.com/container');
	define('TB_AUTH_REQUEST_URL', 'https://oauth.tbsandbox.com/authorize');
	define('TB_AUTH_TOKEN_URL', 'https://oauth.tbsandbox.com/token');
	
	define('TB_API_URL', 'http://gw.api.tbsandbox.com/router/rest');
}
else {
	define('TB_IS_SANDBOX', false);
	define('TB_APP_KEY', '12661652');
	define('TB_APP_SECRET', 'c09f68a1e909f2bc8f251b94861bdabf');
	
	define('TB_TOP_AUTH_URL', 'http://container.api.taobao.com/container');
	define('TB_AUTH_REQUEST_URL', 'https://oauth.taobao.com/authorize');
	define('TB_AUTH_TOKEN_URL', 'https://oauth.taobao.com/token');
	
	define('TB_API_URL', 'http://gw.api.taobao.com/router/rest');
}

