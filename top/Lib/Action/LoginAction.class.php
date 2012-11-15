<?php

import("ORG.Util.Session");

class LoginAction extends Action
{
	static public function isLogin() {
		return Session::get('is_login');
	}
	
	static public function getLoginInfo() {
		return Session::get('login_info');
	}
	
	static public function getAuthType() {
		return Session::get('auth_type');
	}
	
	public function topLogin() {
		$top_parameters = $this->_get('top_parameters');
		$top_session = $this->_get('top_session');
		$top_sign = $this->_get('top_sign');
		if ($top_parameters != null && $top_session != null && $top_sign != null) {
			$param_decode = base64_decode($top_parameters);
			$values = explode("&", $param_decode);
			$map = array();
			foreach($values as $key => $value) {
				$keyValues = explode('=', $value);
				$map[urldecode($keyValues[0])] = urldecode($keyValues[1]);
			}
			
			$loginInfo = array();
			//$loginInfo['auth_type'] = 'TOP';
			$loginInfo['access_token'] = $top_session;
			$loginInfo['refresh_token'] = $map['refresh_token'];
			$loginInfo['user_id'] = $map['visitor_id'];
			$loginInfo['nick'] = $map['visitor_nick'];
			
			$loginInfo['sub_user_id'] = $map['sub_visitor_id'];
			$loginInfo['sub_user_nick'] = $map['sub_taobao_user_nick'];
			$loginInfo['expires_in'] = $map['expires_in'];
			$loginInfo['re_expires_in'] = $map['re_expires_in'];
			$loginInfo['r1_expires_in'] = $map['r1_expires_in'];
			$loginInfo['r2_expires_in'] = $map['r2_expires_in'];
			$loginInfo['w1_expires_in'] = $map['w1_expires_in'];
			$loginInfo['w2_expires_in'] = $map['w2_expires_in'];
			Session::set("login_response", $loginInfo);
			Session::set('is_login', true);
			
			$post = array();
			$post['method'] = 'user.login';
			$post['v'] = '1.0';
			$post['appKey'] = 'sk_app_key';
			$post['format'] = 'json';
			$post = array_merge($post, $loginInfo);
			//dump($post);
			$result = sync_request("http://localhost:8090/router", $post);
			dump ($result);
			//exit;
			//$this->redirect('Index/loginResponse');
		}
		else {
			$auth_request_url = TOP_AUTH_URL."?appkey=".TOP_APP_KEY."&encode=utf-8&scope=promotion,item,usergrade";
			header("Location:{$auth_request_url}");
		}
	}
	
	public function authLogin() {
		$auth_code = $this->_get('code');
		$auth_state = $this->_get('state');
		$error = $_GET['error'];
		$error_description = $_GET['error_description'];
		if ($error === 'access_denied') {
			Session::set('is_login', false);
			return;
		}
		
		if ($auth_code != null && $auth_state != null) {
    		$post_data = array();
    		$post_data['code'] = urlencode($auth_code) ;
    		$post_data['grant_type'] = urlencode('authorization_code');
    		$post_data['client_id'] = urlencode(TOP_APP_KEY);
    		$post_data['client_secret'] = urlencode(TOP_APP_SECRET);
    		$post_data['redirect_uri'] = TOP_REDIRECT_URI;
    		$post_data['scope'] = urlencode('item');
    		$post_data['view'] = urlencode("web");
    		$post_data['state'] = urlencode($auth_state);
    		
			$result = sync_request(TOP_AUTH_TOKEN_URL, $post_data);
			if ($result['access_token']) {
				Session::set('is_login', true);
				Session::set('auth_type', 'AUTH');
				Session::set('login_info', $result);
			}
			else {
				Session::set('is_login', false);
			}
			$this->redirect('Index/login');
    	}
    	else {
			$auth_request_url = TOP_AUTH_REQUEST_URL."?response_type=code&client_id=".TOP_APP_KEY."&redirect_uri=" . TOP_REDIRECT_URI."&state=1&scope=item&view=web";
			header("Location:$auth_request_url");
    	}
	}
	
	public function login() {
		if (APP_AUTH_TYPE === 'TOP') {
			$this->topLogin();
		}
		else if (APP_AUTH_TYPE ==='AUTH') {
			$this->authLogin();
		}
	}
	
	public function logout() {
		Session::destroy();
		if (!APP_DEBUG) {
			$auth_request_url = TOP_LOGOUT_URL."?client_id=".TOP_APP_KEY."&redirect_uri=" . APP_HOST. '/top/index/index' ."&view=web";
			header("Location:{$auth_request_url}");
		}
		else {
			$this->redirect('Index/index');
		}
	}
	
	public function index() {
		$this->login();
	}
}