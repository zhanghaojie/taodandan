<?php
define('APP_DEBUG', true);
define('TOP_DEBUG', true);
define('APP_AUTH_TYPE', 'TOP');

define('THINK_PATH', './ThinkPHP/');
define('APP_HOST', 'http://localhost');

//淘宝相关配置
define('TOP_REDIRECT_URI', APP_HOST . '/taodandan/login/login.html');

if (APP_AUTH_TYPE === 'TOP') {
	define('TOP_IS_SIGNAL', true);
}
else {
	define('TOP_IS_SIGNAL', false);
}

if (TOP_DEBUG) {
	define('TOP_IS_SANDBOX', true);
	define('TOP_APP_KEY', '1012681999');
	define('TOP_APP_SECRET', 'sandbox41a796536c687440d5a35ef2e');
	
	define('TOP_AUTH_URL', 'http://container.api.tbsandbox.com/container');
	define('TOP_AUTH_REQUEST_URL', 'https://oauth.tbsandbox.com/authorize');
	define('TOP_AUTH_TOKEN_URL', 'https://oauth.tbsandbox.com/token');
	
	define('TOP_API_URL', 'http://gw.api.tbsandbox.com/router/rest');
	
	define('TOP_LOGOUT_URL', 'https://oauth.taobao.com/logoff');
}
else {
	define('TOP_IS_SANDBOX', false);
	define('TOP_APP_KEY', '12681999');
	define('TOP_APP_SECRET', 'a15e04641a796536c687440d5a35ef2e');
	
	define('TOP_AUTH_URL', 'http://container.api.taobao.com/container');
	define('TOP_AUTH_REQUEST_URL', 'https://oauth.taobao.com/authorize');
	define('TOP_AUTH_TOKEN_URL', 'https://oauth.taobao.com/token');
	
	define('TOP_API_URL', 'http://gw.api.taobao.com/router/rest');
	define('TOP_LOGOUT_URL', 'https://oauth.taobao.com/logoff');
}

