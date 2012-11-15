<?php 

import("ORG.Util.FirePHP");
import("ORG.Util.Session");

class TopAccessor
{
	private $accessToken = null;
	private $topClient = null;
	
	public function __construct($accessToken = null) {
		$this->topClient = new TopClient();
		$this->topClient->appkey = TOP_APP_KEY;
    	$this->topClient->secretKey = TOP_APP_SECRET;
    	$this->topClient->gatewayUrl = TOP_API_URL;
    	$this->topClient->format = "json";
    	$this->setAccessToken($accessToken);
	}
	
	public function setAccessToken($accessToken = null) {
		$this->accessToken = $accessToken;
	}
	
	public function getAccessToken() {
		return $this->accessToken;
	}
	
	public function getUserInfo($fields) {
		$requestParams['method'] = 'taobao.user.get';
		$requestParams['session'] = $this->accessToken;
		if ($fields) {
			$requestParams['fields'] = $fields;
		}
		else {
			$requestParams['fields'] = "user_id,uid,nick,sex,buyer_credit,seller_credit,location,created,last_visit,birthday,type,status,consumer_protection";
		}
		$ret = $this->topClient->exec($requestParams);
		$user = $ret['user'];
		
		if ($user) {
			return $user;	
		}
		else {
			return $ret;
		}
	}
	
	//获取仓库中的宝贝
	public function getInventoryItems($fields, $params) {
		$requestParams['method'] = 'taobao.items.inventory.get';
		$requestParams['session'] = $this->accessToken;
		if ($fields) {
			$requestParams['fields'] = $fields;
		}
		else {
			$requestParams['fields'] = 'approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase, modified,delist_time,postage_id,seller_cids,outer_id,is_virtual,is_taobao,is_ex';
		}
		if (is_array($params)) {
			$requestParams = array_merge($requestParams, $params);
		}
		$ret = $this->topClient->exec($requestParams);
		return $ret;
	}
	
	//获取销售中的宝贝
	public function getOnsaleItems($fields, $params) {
		$requestParams['method'] = 'taobao.items.onsale.get';
		$requestParams['session'] = $this->accessToken;
		if ($fields) {
			$requestParams['fields'] = $fields;
		}
		else {
			$requestParams['fields'] = 'approve_status,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase, modified,delist_time,postage_id,seller_cids,outer_id';
		}
		if (is_array($params)) {
			$requestParams = array_merge($requestParams, $params);
		}
		$ret = $this->topClient->exec($requestParams);
		return $ret;
	}
	
	//获取橱窗中的宝贝
	public function getOnShowcaseItems($params) {
		$requestParams['has_showcase'] = 'true';
		if (is_array($params)) {
			$requestParams = array_merge($requestParams, $params);
		}
		$ret = $this->getOnsaleItems(null, $requestParams);
		return $ret;
	}
	//获取店铺中的分类
	public function getSellerCatsList($nick, $params) {
		$requestParams['method'] = 'taobao.sellercats.list.get';
		$requestParams['session'] = $this->accessToken;
		if ($nick) {
			$requestParams['nick'] = $nick;
		}
		else {
			$requestParams['nick'] = $this->userNick;
		}
		if (is_array($params)) {
			$requestParams = array_merge($requestParams, $params);
		}
		$ret = $this->topClient->exec($requestParams);
		return $ret;
	}
	
	protected function _addItemToShowcase($item_id) {
		$requestParams['method'] = 'taobao.item.recommend.add';
		$requestParams['session'] = $this->accessToken;
		$requestParams['num_iid'] = $item_id;
		$ret = $this->topClient->exec($requestParams);
		return $ret;
	}
	
	protected function _deleteItemFromShowcase($item_id) {
		$requestParams['method'] = 'taobao.item.recommend.delete';
		$requestParams['session'] = $this->accessToken;
		$requestParams['num_iid'] = $item_id;
		$ret = $this->topClient->exec($requestParams);
	}
	//添加宝贝到橱窗
	//如果是数组批量添加
	//如果全部成功返回true， 如果失败返回失败的宝贝id
	public function addItemsToShowcase($item_ids) {
		$ret = $this->getShopRemainShowcase();
		$remainShowCase = $ret['remain_count'];
		$allCount = $ret['all_count'];
		$fail = array();
		if (!is_array($item_ids)) {
			$item_ids = array($item_ids);	
		}
		if ($allCount < 0 || $remainShowCase > 0) {
			foreach ($item_ids as $item_id) {
				$ret = $this->_addItemToShowcase($item_id);
				$code = $ret['code'];
				$ret_iid = $ret['item']['num_iid'];
				if ($code != null) {
					$fail[$item_id] = $ret;
				}
			}
		}
		if (count($fail) > 0) {
			return $fail;
		}
		else {
			return true;
		}
	}
	//从橱窗删除宝贝
	//如果是数组批量删除
	//如果全部成功返回true， 如果失败返回失败的宝贝id
	public function deleteItemsFromShowcase($item_ids) {
		if (!is_array($item_ids)) {
			$item_ids = array($item_ids);	
		}
		$fail = array();
		foreach ($item_ids as $item_id) {
			$ret = $this->_deleteItemFromShowcase($item_id);
			$code = $ret['code'];
			if ($code != null) {
				$fail[$item_id] = $ret;
			}
		}
		if (count($fail) > 0) {
			return $fail;
		}
		else {
			return true;
		}
	}
	
	protected function _addItemToStorageRacks($item) {
		$requestParams['method'] = 'taobao.item.update.listing';
		$requestParams['session'] = $this->accessToken;
		$requestParams['num_iid'] = $item['item_id'];
		$requestParams['num'] = $item['num'];
		$ret = $this->topClient->exec($requestParams);
		return $ret;
	}
	
	protected function _deleteItemFromStorageRacks($item_id) {
		$requestParams['method'] = 'taobao.item.update.delisting';
		$requestParams['session'] = $this->accessToken;
		$requestParams['num_iid'] = $item_id;
		$ret = $this->topClient->exec($requestParams);
		return $ret;
	}
	
	//添加指定的商品到货架上
	//参数[{'item_id':123,'num'=12} ...]
	public function addItemsToStorageRacks($items) {
		if (!$items[0]) {
			$items = array($items);	
		}
		$fail = array();
		foreach ($items as $item) {
			$ret = $this->_addItemToStorageRacks($item);
			$code = $ret['code'];
			if ($code != null) {
				$fail['item_id'] = $ret;
			}
		}
		if (count($fail) > 0) {
			return $fail;
		}
		else {
			return true;
		}
	}
	
	//从货架上删除指定的商品
	public function deleteItemsFromStorageRacks($item_ids) {
		if (!is_array($item_ids)) {
			$item_ids = array($item_ids);	
		}
		$fail = array();
		foreach ($item_ids as $item_id) {
			$ret = $this->_deleteItemFromStorageRacks($item_id);
			$code = $ret['code'];
			if ($code != null) {
				$fail[$item_id] = $ret;
			}
		}
		if (count($fail) > 0) {
			return $fail;
		}
		else {
			return true;
		}
	}
	
	public function createTaskForTradesInfoByTid($fields, $tids) {
		$requestParams['method'] = 'taobao.topats.trades.fullinfo.get';
		$requestParams['session'] = $this->accessToken;
		if ($fields) {
			$requestParams['fields'] = $fields;
		}
		else {
			$requestParams['fields'] = "seller_nick, buyer_nick, title, type, created, tid, seller_rate,buyer_flag, buyer_rate, status, payment, adjust_fee, post_fee, total_fee, pay_time, end_time, modified, consign_time, buyer_obtain_point_fee, point_fee, real_point_fee, received_payment, commission_fee, buyer_memo, seller_memo, alipay_no,alipay_id,buyer_message, pic_path, num_iid, num, price, receiver_state, receiver_city, receiver_district, receiver_zip,seller_flag, seller_alipay_no, seller_mobile, seller_phone, seller_name, seller_email, available_confirm_fee, has_post_fee, timeout_action_time, snapshot_url, cod_fee, cod_status, shipping_type, trade_memo, is_3D,buyer_area,trade_from,is_lgtype,is_force_wlb,is_brand_sale,buyer_cod_fee,discount_fee,seller_cod_fee,express_agency_fee,invoice_name,service_orders,credit_cardfee,orders,promotion_details,invoice_name";
		}
		
		if (is_array($tids)) {
			$tids = implode(';', $tids);
		}
		
		$requestParams['tids'] = $tids;
		$ret = $this->topClient->exec($requestParams);
		$task = $ret['task'];
		if ($task) {
			$task['type'] = 'part';
			$task['status'] = 'uncompleted';
		}
		
		$topTaskModel = D('TopTask');
		$task['user_id'] = $this->userId;
		$topTaskModel->add($task);
		return $task;
	}
	
	//start_time , end_time = yyyyMMdd 如：20120501相当于取订单创建时间从2012-05-01 00:00:00开始的订单。 
	public function createTaskForTradesInfoByTime($startTime, $endTime, $fields) {
		$requestParams['method'] = 'taobao.topats.trades.sold.get';
		$requestParams['session'] = $this->accessToken;
		if ($fields) {
			$requestParams['fields'] = $fields;
		}
		else {
			$requestParams['fields'] = "seller_nick, buyer_nick, title, type, created, tid, seller_rate,buyer_flag, buyer_rate, status, payment, adjust_fee, post_fee, total_fee, pay_time, end_time, modified, consign_time, buyer_obtain_point_fee, point_fee, real_point_fee, received_payment, commission_fee, buyer_memo, seller_memo, alipay_no,alipay_id,buyer_message, pic_path, num_iid, num, price, receiver_state, receiver_city, receiver_district, receiver_zip,seller_flag, seller_alipay_no, seller_mobile, seller_phone, seller_name, seller_email, available_confirm_fee, has_post_fee, timeout_action_time, snapshot_url, cod_fee, cod_status, shipping_type, trade_memo, is_3D,buyer_area,trade_from,is_lgtype,is_force_wlb,is_brand_sale,buyer_cod_fee,discount_fee,seller_cod_fee,express_agency_fee,invoice_name,service_orders,credit_cardfee,orders,promotion_details,invoice_name";
		}
		$requestParams['start_time'] = $startTime;
		$requestParams['end_time'] = $endTime;
		$ret = $this->topClient->exec($requestParams);
		$task = $ret['task'];
		if ($task) {
			$task['type'] = 'all';
			$task['status'] = 'uncompleted';
			$topTaskModel = D('TopTask');
			$task['user_id'] = $this->userId;
			$topTaskModel->add($task);
			return $task;
		}
		return $ret;
	}
	
	public function getTopTime() {
		$requestParams['method'] = 'taobao.time.get';
		$ret = $this->topClient->exec($requestParams);
		return $ret['time'];
	}
	
	//获取所有订单， 时间范围为当天前一天至一个月前
	public function createTaskFroAllTrades() {
		$topTime = $this->getTopTime();
		$now = new DateTime($topTime);
		$interval = new DateInterval('P1M');
		$interval->invert = 1;
		$startTime = $now->add($interval);
		$now = new DateTime($topTime);
		$interval = new DateInterval('P1D');
		$interval->invert = 1;
		$endTime = $now->add($interval);
		$startTime = $startTime->format('Ymd');
		$endTime = $endTime->format('Ymd');
		//fire_log($startTime, "start time");
		//fire_log($endTime, "end time");
		$ret = $this->createTaskForTradesInfoByTime($startTime, $endTime);
		return $ret;
	}
	
	public function getTaskResult() {
		$taskModel = D('TopTask');
		$tasks = $taskModel->field('task_id')->where("user_id={$this->userId} and status='uncompleted'")->select();
		
		foreach($tasks as $value) {
			$taskId = $value['task_id'];
			$requestParams['method'] = 'taobao.topats.result.get';
			$requestParams['task_id'] = $taskId;
			$rsp = $this->topClient->exec($requestParams);
			fire_log($rsp, 'TOP任务结果');
		}
	}
	
	public function getTrades($fields, $page_no=1, $page_size=40, $params) {
		$requestParams['method'] = 'taobao.trades.sold.get';
		$requestParams['session'] = LoginAction::getAccessToken();
		if ($fields) {
			$requestParams['fields'] = $fields;
		}
		else {
			$requestParams['fields'] = "seller_nick, buyer_nick, title, type, created, tid, seller_rate,buyer_flag, buyer_rate, status, payment, adjust_fee, post_fee, total_fee, pay_time, end_time, modified, consign_time, buyer_obtain_point_fee, point_fee, real_point_fee, received_payment, commission_fee, buyer_memo, seller_memo, alipay_no,alipay_id,buyer_message, pic_path, num_iid, num, price, receiver_state, receiver_city, receiver_district, receiver_zip,seller_flag, seller_alipay_no, seller_mobile, seller_phone, seller_name, seller_email, available_confirm_fee, has_post_fee, timeout_action_time, snapshot_url, cod_fee, cod_status, shipping_type, trade_memo, is_3D,buyer_area,trade_from,is_lgtype,is_force_wlb,is_brand_sale,buyer_cod_fee,discount_fee,seller_cod_fee,express_agency_fee,invoice_name,service_orders,credit_cardfee,orders,promotion_details,invoice_name";
		}
		if (is_array($params)) {
			$requestParams = array_merge($requestParams, $params);
		}
		
		$requestParams['page_no'] = $page_no;
		$requestParams['page_size'] = $page_size;
		$ret = $this->topClient->exec($requestParams);
		return $ret;	
	}
}