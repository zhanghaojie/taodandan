<?php

vendor('taobaosdk.MyTopSdk');
TopClient::setClientState(TB_IS_SIGNAL, TB_IS_SANDBOX);

class IndexAction extends Action
{
    public function index() {
    	if (LoginAction::isLogin() === true) {
    		$this->display();
    		echo 'login <br>';
    	}
    	else {
        	$this->display();
        	echo 'logout <br>';
    	}
    }
    
    public function tbLogin() {
    	$this->redirect('Login/login');
    }
    
    public function topLogin() {
    	$this->redirect('Login/topLogin');
    }
    
    public function tbLogout() {
    	$this->redirect('Login/logout');
    }
    
    public function getUser() {
    	$client = new TopClient();
    	$client->appkey = TB_APP_KEY;
    	$client->secretKey = TB_APP_SECRET;
    	$user_info = Session::get('user_info');
    	$requests = array();
    	$req = new UserGetRequest;
    	$req->setFields('nick,sex,uid,created');
    	$user_info = Session::get('user_info');
    	$req->setNick('edword2012');
    	//$req->setNick('sandbox_c_1');
    	//$resp = $client->execute($req);
    	$requests[0] = $req;
    	
    	$req = new ItemcatsAuthorizeGetRequest;
    	$req->setFields('brand.vid, brand.name, item_cat.cid, item_cat.name, item_cat.status,item_cat.sort_order,item_cat.parent_cid,item_cat.is_parent, xinpin_item_cat.cid, xinpin_item_cat.name, xinpin_item_cat.status, xinpin_item_cat.sort_order, xinpin_item_cat.parent_cid, xinpin_item_cat.is_parent');
    	$requests[1] = $req;
    	$req = new UserGetRequest;
    	$req->setFields('nick,sex,uid,created');
    	$user_info = Session::get('user_info');
    	$req->setNick('edword2012');
    	//$req->setNick('sandbox_c_19');
    	//$resp = $client->execute($req);
    	$requests[2] = $req;
    	
    	$req = new UserGetRequest;
    	$req->setFields('nick,sex,uid,created');
    	$user_info = Session::get('user_info');
    	$req->setNick('edword2012');
    	//$req->setNick('sandbox_c_20');
    	//$resp = $client->execute($req);
    	$requests[3] = $req;
    	
    	$session = LoginAction::getSession();
    	//dump($client->execute($requests, $session));
    	dump($client->execute($requests[0], $session));
    	dump($client->execute($requests[1], $session));
    	dump($client->execute($requests[2], $session));
    	dump($client->execute($requests[3], $session));
    }
    
    public function getAuthorizeItems() {
    	$client = new TopClient();
    	$client->appkey = TB_APP_KEY;
    	$client->secretKey = TB_APP_SECRET;
    	
    	$req = new ItemcatsAuthorizeGetRequest;
    	$req->setFields('brand.vid, brand.name, item_cat.cid, item_cat.name, item_cat.status,item_cat.sort_order,item_cat.parent_cid,item_cat.is_parent, xinpin_item_cat.cid, xinpin_item_cat.name, xinpin_item_cat.status, xinpin_item_cat.sort_order, xinpin_item_cat.parent_cid, xinpin_item_cat.is_parent');
    	$user_info = Session::get('user_info');
    	$resp = $client->execute1($req, $user_info['access_token']);
    }
    
    public function getAuthorizeItemsWithTopSession() {
    	$session = LoginAction::getSession();
    	
    	$client = new TopClient();
    	$client->appkey = '12661652';
    	$client->secretKey = TB_APP_SECRET;
    	
    	$req = new ItemcatsAuthorizeGetRequest;
    	$req->setFields('brand.vid, brand.name, item_cat.cid, item_cat.name, item_cat.status,item_cat.sort_order,item_cat.parent_cid,item_cat.is_parent, xinpin_item_cat.cid, xinpin_item_cat.name, xinpin_item_cat.status, xinpin_item_cat.sort_order, xinpin_item_cat.parent_cid, xinpin_item_cat.is_parent');
    	
    	$req = new UserGetRequest;
    	$req->setFields('nick,sex,uid,created');
    	$req->setNick('sandbox_c_1');
    	
    	$resp = $client->execute1($req, '');
    	dump($resp);
    }
    
    public function uploadFile() {
    	if ($_FILES['file']['error'] > 0) {
			echo "Error: " . $_FILES['myfile']['error']."<br/>";
		}
		else {
			Log::write($_FILES['myfile1']['tmp_name']);
			Log::write(time());
			Log::write($_FILES['myfile2']['tmp_name']);
			Log::write(time());
			Log::write($_FILES['myfile3']['tmp_name']);
			Log::write(time());
			Log::write($_FILES['myfile4']['tmp_name']);
			Log::write(time());
			Log::write($_FILES['myfile5']['tmp_name']);
			Log::write(time());
			//echo "Upload:" . $_FILES['myfile']['name'] . '<br/>';
			//dump($_FILES);
			//move_uploaded_file($_FILES['myfile']['tmp_name'], './tmp/1.png');
			
			//echo '<script type="text/javascript"> window.top.window.stopUpload("<img src=./tmp/1.png>"); </script> ';
		}
    }

    /**
    +----------------------------------------------------------
    * 探针模式
    +----------------------------------------------------------
    */
    public function checkEnv() {
        load('pointer',THINK_PATH.'/Tpl/Autoindex');//载入探针函数
        $env_table = check_env();//根据当前函数获取当前环境
        echo $env_table;
    }

}

