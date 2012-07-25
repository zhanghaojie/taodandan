<?php

import("ORG.Util.Session");

class LoginAction extends Action
{
	static public function isLogin() {
		return Session::get('is_login');
	}
	
	static public function getAccessToken() {
		$auth_type = LoginAction::getAuthType();
		if ($auth_type === 'TOP') {
			return Session::get('top_session');
		}
		else if ($auth_type === 'AUTH'){
			$user_info = Session::get('login_info');
			$access_token = $user_info['access_token'];
			return $access_token;
		}
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
			Session::set('is_login', true);
			Session::set('auth_type', 'TOP');
			Session::set('top_session', $top_session);
			Session::set('top_parameters', $top_parameters);
			Session::set('top_sign', $top_sign);
			$this->redirect('Index/login');
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