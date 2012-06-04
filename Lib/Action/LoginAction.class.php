<?php

class LoginAction extends Action
{
	static public function isLogin() {
		return Session::get('is_login');
	}
	
	static public function getSession() {
		$auth_type = LoginAction::getAuthType();
		if ($auth_type === 'TOP') {
			return Session::get('top_session');
		}
		else if ($auth_type === 'AUTH'){
			$user_info = Session::get('user_info');
			$access_token = $user_info['access_token'];
			return $access_token;
		}
	}
	
	static public function getAuthType() {
		return Session::get('auth_type');
	}
	
	public function topLogin() {
		$top_parameters = $_GET['top_parameters'];
		$top_session = $_GET['top_session'];
		$top_sign = $_GET['top_sign'];
		if ($top_parameters != null && $top_session != null && $top_sign != null) {
			Session::set('is_login', true);
			Session::set('auth_type', 'TOP');
			Session::set('top_session', $top_session);
			Session::set('top_parameters', $top_parameters);
			Session::set('top_sign', $top_sign);
			$this->redirect('Index/index');
		}
		else {
			$url = TB_TOP_AUTH_URL . '?appkey=' . TB_APP_KEY . '&encode=utf-8';
			header("Location:$url");
		}
	}
	
	public function authLogin() {
		$auth_code = $_GET['code'];
		$auth_state = $_GET['state'];
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
    		$post_data['client_id'] = urlencode(TB_APP_KEY);
    		$post_data['client_secret'] = urlencode(TB_APP_SECRET);
    		$post_data['redirect_uri'] = TB_REDIRECT_URI;
    		$post_data['scope'] = urlencode('item');
    		$post_data['view'] = urlencode("web");
    		$post_data['state'] = urlencode($auth_state);
			$decode_result = sync_request(TB_AUTH_TOKEN_URL, $post_data);
			if ($decode_result['access_token']) {
				Session::set('is_login', true);
				Session::set('auth_type', 'AUTH');
				Session::set('user_info', $decode_result);
			}
			else {
				Session::set('is_login', false);
			}
			$this->redirect('Index/index');
    	}
    	else {
			$auth_request_url = TB_AUTH_REQUEST_URL."?response_type=code&client_id=".TB_APP_KEY."&redirect_uri=" . TB_REDIRECT_URI."&state=1&scope=item&view=web";
			header("Location:$auth_request_url");
    	}
	}
	
	public function login() {
		if (APP_AUTH_TYPE === 'TOP') {
			$this->redirect('topLogin', $_GET);
		}
		else if (APP_AUTH_TYPE === 'AUTH') {
			$this->redirect('authLogin', $_GET);
		}
	}
	
	public function logout() {
		Session::destroy();
		$this->redirect('Index/index');
	}
	
	public function index() {
		$this->login();
	}
	
	public function resultHandler() {
		//dump($_GET);
	}
}