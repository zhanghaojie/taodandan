<?php

vendor('taobaosdk.TopSdk');
import("ORG.Util.FirePHP");
import('ORG.Util.Page');

class IndexAction extends Action
{
	private $client;
	private $userModel;
	
	public function __construct() {
		parent::__construct();
		$this->client = new TopClient();
		$this->client->appkey = TOP_APP_KEY;
  	$this->client->secretKey = TOP_APP_SECRET;
  	$this->client->gatewayUrl = TOP_API_URL;
  	$this->client->format = "json";
		$this->client->checkRequest = false;
  	//$this->userModel = new UserModel();
	}
	
	protected function _debug() {
		//$this->userModel->updateUserInfo();
		//$this->userModel->deleteAllItems();
		//$this->userModel->updateItems();
//  		$ret = $this->userModel->createItemGroup("group1", "my group");
//  		$ret = $this->userModel->createItemGroup("group2", "my group");
		
// 		$ret = $this->userModel->deleteItemGroupById(37);
// 		if ($ret) {
// 			fire_log("delete 28","delete");
// 		}
// 		else {
// 			fire_log("delete fail","delete");
// 		}
		$ret = $this->userModel->getItemGroupByName("group1");
		if ($ret) {
			fire_log($ret);
		}
		else {
			fire_log("fail", "getItemGroupById");
		}
		/*
		$ret = $this->userModel->getItemGroupByName("group3");
		if ($ret) {
			fire_log($ret);
		}
		else {
			fire_log("fail", "getItemGroupByName");
		}
		*/
		/*
		fire_log(LoginAction::getLoginInfo(), '登陆信息');
		FirePHP::getInstance(true)->log($this->userModel->_getTopUserInfo(), '用户信息');
		
		$ret = $this->userModel->getInventoryItems();
		FirePHP::getInstance(true)->log($ret, '仓库宝贝');
    	$ret = $this->userModel->getShopRemainShowcase();
		FirePHP::getInstance(true)->log($ret, '剩余橱窗');
    	$ret = $this->userModel->getOnsaleItems();
		FirePHP::getInstance(true)->log($ret, '销售中的宝贝');
    	$ret = $this->userModel->getOnShowcaseItems();
		FirePHP::getInstance(true)->log($ret, '橱窗中的宝贝');
    	$ret = $this->userModel->getSellerCatsList();
		FirePHP::getInstance(true)->log($ret, '店铺中的宝贝分类');
		
		$ret = $this->userModel->getTrades();
		fire_log($ret, "获取前40个订单");
		
		$this->userModel->updateTrades($ret['trades']['trade']);
		*/
	}
	
	public function createTask() {
		//$ret = $this->userModel->createTaskForTradesInfoByTime("20120628", "20120713");
		//FirePHP::getInstance(true)->log($ret, '创建的任务');
	}
	
	public function getTaskResult() {
		$ret = $this->userModel->getTaskResult();
		FirePHP::getInstance(true)->log($ret, '创建的任务结果');
	}
	
	public function mainPage() {
		$this->display('main');
	}
	
    public function index() {
    	if (LoginAction::isLogin() === true) {
    		//$this->_debug();
    		$this->mainPage();
    	}
    	else {
    		//显示我们的首页
        	$this->display('index');
    	}
    }
    
    public function loginResponse() {
    	
    }
	
    public function login() {
    	if (LoginAction::isLogin() === true) {
    		$this->userModel->updateUserInfo();
    		$this->redirect('Index/index');
    	}
    	else {
    		$this->redirect('Login/login');
    	}
    }
    
    public function logout() {
    	$this->redirect('Login/logout');
    }
    
    
	
	

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function taobaoUserGet() {
    	$request = new UserGetRequest();
    	//$request->setNick("alipublic20");
    	$request->setFields("user_id,uid,nick,sex,buyer_credit,
    	seller_credit,location,created,last_visit,birthday,type,has_more_pic,
    	item_img_num,item_img_size,prop_img_num,prop_img_size,auto_repost,promoted_type,
    	status,alipay_bind,consumer_protection,avatar,liangpin,sign_food_seller_promise,
    	has_shop,is_lightning_consignment,has_sub_stock,is_golden_seller,vip_info,
    	email,magazine_subscribe,vertical_market,online_gaming
    	");
    	$ret = $this->client->execute($request, LoginAction::getAccessToken());
    	$userInfo = $ret['user'];
    	$this->userModel->relation(true)->add($userInfo);
    	dump($ret);
    }
    
    public function taobaoUsersGet() {
    	$request = new UsersGetRequest();
    	$request->setNicks("alipublic20,alipublic21");
    	$request->setFields("user_id,uid,nick,sex,buyer_credit,seller_credit,location,created,last_visit,birthday,type,status,alipay_no,alipay_account,alipay_account,email,consumer_protection,alipay_bind");
    	$ret = $this->client->execute($request);
    	dump($ret);
    }
    
    public function taobaoItemcatsAuthorizeGet() {
    	$request = new ItemcatsAuthorizeGetRequest();
    	$request->setFields("brand.vid,brand.name,item_cat.cid,item_cat.name,item_cat.status,item_cat.sort_order,item_cat.parent_cid,item_cat.is_parent");
    	$ret = $this->client->execute($request, LoginAction::getAccessToken());
    	dump($ret);
    }
    
   public function taobaoItemcatsGet() {
   		$request = new ItemcatsGetRequest();
   		$request->setFields("cid,parent_cid,name,is_parent,features,status,sort_order");
   		$request->setParentCid(50018222);
   		$ret = $this->client->execute($request);
   		dump($ret);
   }
   
   public function taobaoItempropsGet() {
   		$request = new ItempropsGetRequest();
   		$request->setFields("pid,name,must,multi,prop_values");
   		$request->setCid(50008351);
   		$ret = $this->client->execute($request);
   		dump($ret);
   }
   
   public function taobaoItempropvaluesGet() {
   		$request = new ItempropvaluesGetRequest();
   		$request->setFields("cid,pid,prop_name,vid,name,name_alias,status,sort_order");
   		$request->setCid(50018323);
   		$ret = $this->client->execute($request);
   		dump($ret);
   }

   public function taobaoShopcatsListGet() {
   		$request = new ShopcatsListGetRequest();
   		$request->setFields("cid,parent_cid,name,is_parent");
   		$ret = $this->client->execute($request);
   		dump($ret);
   }
   //获取当前用户作为卖家的仓库中的商品列表，
   //并能根据传入的搜索条件对仓库中的商品列表
   //进行过滤 只能获得商品的部分信息，商品的详细
   //信息请通过taobao.item.get获取
	public function taobaoItemsInventoryGet() {
   		$request = new ItemsInventoryGetRequest();
   		$request->setFields("approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
   		$ret = $this->client->execute($request, LoginAction::getAccessToken());
   		dump($ret);
   	}
   
	public function taobaoRemainShowcaseGet() {
   		$request = new ShopRemainshowcaseGetRequest();
   		$ret = $this->client->execute($request, LoginAction::getAccessToken());
   		dump($ret);
	}
   	
	public function getShowcaseItems() {
   		$request = new ItemsOnsaleGetRequest();
   		$request->setFields("approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id");
   		$request->setHasShowcase("true");
   		$ret = $this->client->execute($request, LoginAction::getAccessToken());
   		dump($ret);
	}
	
	public function taobaoItemRecommendDelete() {
		$request = new ItemRecommendDeleteRequest();
		$request->setNumIid(14996938664);
		$ret = $this->client->execute($request, LoginAction::getAccessToken());
		dump($ret);
	}
	
	public function taobaoItemRecommendAdd() {
		$request = new ItemRecommendAddRequest();
		$request->setNumIid(14996938664);
		$ret = $this->client->execute($request, LoginAction::getAccessToken());
		dump($ret);
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

