<?php

class TopClient
{
	public $appkey;

	public $secretKey;

	static public $gatewayUrl = "http://gw.api.taobao.com/router/rest";
	
	static private $isSignal = false;
	
	static private $isSandbox = false;

	public $format = "json";

	/** 是否打开入参check**/
	public $checkRequest = true;

	protected $signMethod = "md5";

	protected $apiVersion = "2.0";

	protected $sdkVersion = "top-sdk-php-20120527";
	
	static public function setClientState($is_signal, $is_sandbox) {
		self::$isSignal = $is_signal;
		self::$isSandbox = $is_sandbox;
		if ($is_signal) {
			if ($is_sandbox) {
				self::$gatewayUrl = 'http://gw.api.tbsandbox.com/router/rest';
			}
			else {
				self::$gatewayUrl = 'http://gw.api.taobao.com/router/rest';
			}
		}
		else {
			//self::$gatewayUrl = 'http://gw.api.tbsandbox.com/router/rest';
			self::$gatewayUrl = "https://eco.taobao.com/router/rest";
		}
		
	}
	
	public function __construct() {
		self::setClientState($this::$isSignal, $this::$isSandbox);
	}

	protected function generateSign($params)
	{
		ksort($params);

		$stringToBeSigned = $this->secretKey;
		foreach ($params as $k => $v)
		{
			if("@" != substr($v, 0, 1))
			{
				$stringToBeSigned .= "$k$v";
			}
		}
		unset($k, $v);
		$stringToBeSigned .= $this->secretKey;

		return strtoupper(md5($stringToBeSigned));
	}
	/*
	 * curl_opts
	 * array('url', 'http://url', 'postFields', 'Fields');
	 * 
	 */
	public function mutil_curl($curl_opts) 
	{
		// 发送multi_curl请求
		$mh = curl_multi_init();
		$nch = 0;
		$ches = array();
		
		foreach ($curl_opts as $curl_opt) {
			if($request->code === null) {
				$still_running = false;
				
				$curl_opt_array = array();

				$requestUrl = $curl_opt['url'];
				$curl_opt_array[CURLOPT_URL] = $requestUrl;
				$curl_opt_array[CURLOPT_FAILONERROR] = false;
				$curl_opt_array[CURLOPT_RETURNTRANSFER] = true;
				$curl_opt_array[CURLOPT_POST] = true;
				
				$ch = curl_init();
				$ches[$nch] = $ch;
				
				if(strlen($requestUrl) > 5 && strtolower(substr($requestUrl,0,5)) == "https" ){
					$curl_opt_array[CURLOPT_SSL_VERIFYPEER] = false;
					$curl_opt_array[CURLOPT_SSL_VERIFYHOST] = false;
				}
				else {
					$curl_opt_array[CURLOPT_SSL_VERIFYPEER] = true;
					$curl_opt_array[CURLOPT_SSL_VERIFYHOST] = true;
				}
				
				$apiParams = $curl_opt['postFields'];
				if (is_array($apiParams) && 0 < count($apiParams)) {
					$postBodyString = "";
					$postMultipart = false;
					foreach ($apiParams as $k => $v) {
						if ("@" != substr($v, 0, 1)) {
							$postBodyString .= "$k=" . urlencode($v) . "&";
						}
						else {
							$postMultipart = true;
						}
					}
					unset($k, $v);
					
					if ($postMultipart) {
						$curl_opt_array[CURLOPT_POSTFIELDS] = $apiParams;
					}
					else {
						$curl_opt_array[CURLOPT_POSTFIELDS] = substr($postBodyString,0,-1);
					}
				}
				curl_setopt_array($ch, $curl_opt_array);
				curl_multi_add_handle($mh, $ch);
				++$nch;
			}
		}
		
		do {
			$mrc = curl_multi_exec($mh, $still_running);
		} while (CURLM_CALL_MULTI_PERFORM == $mrc);
			
		while ($still_running && mrc == CURLM_OK) {
			$ret = curl_multi_select($mh);
			if ($ret != -1) {
				do {
					$mrc = curl_multi_exec($mh, $still_running);
				} while (CURLM_CALL_MULTI_PERFORM == $mrc);
			}
		}
		
		$nch = 0;
		
		$ret = array();
		foreach ($curl_opts as $key => $node) {
			if (($info = curl_multi_info_read($mh)) != null)  {
				$resp = curl_multi_getcontent($ches[$nch]);
				$node['response'] = $resp;
			}
			else {
				$node['response'] = 'error_response';
			}
			$ret[$key] = $node;
			curl_multi_remove_handle($mh, $ches[$nch]);
			curl_close($ches[$nch]);
			++$nch;
		}
		curl_multi_close($mh);
		return $ret;
	}

	public function curl($url, $postFields = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//https 请求
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v)
			{
				if("@" != substr($v, 0, 1))//判断是不是文件上传
				{
					$postBodyString .= "$k=" . urlencode($v) . "&"; 
				}
				else//文件上传用multipart/form-data，否则用www-form-urlencoded
				{
					$postMultipart = true;
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart)
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}
			else
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
		}
		$reponse = curl_exec($ch);
		
		if (curl_errno($ch))
		{
			throw new Exception(curl_error($ch),0);
		}
		else
		{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode)
			{
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}

	protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt)
	{
		$localIp = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : "CLI";
		$logger = new LtLogger;
		$logger->conf["log_file"] = rtrim(TOP_SDK_WORK_DIR, '\\/') . '/' . "logs/top_comm_err_" . $this->appkey . "_" . date("Y-m-d") . ".log";
		$logger->conf["separator"] = "^_^";
		$logData = array(
		date("Y-m-d H:i:s"),
		$apiName,
		$this->appkey,
		$localIp,
		PHP_OS,
		$this->sdkVersion,
		$requestUrl,
		$errorCode,
		str_replace("\n","",$responseTxt)
		);
		$logger->log($logData);
	}
	
	public function execute_with_nosignal($requests, $access_token = null) 
	{
		if($this->checkRequest) {
			foreach ($requests as $request) {
				try {
					$request->check();
				} catch (Exception $e) {
					$result->code = $e->getCode();
					$result->msg = $e->getMessage();
				}
			}
		}
		
		$sysParams['format'] = $this->format;
		$sysParams["v"] = $this->apiVersion;
		if (null != $access_token) {
			$sysParams['access_token'] = $access_token;
		}
		
		$curl_requests_opts = array();
		foreach ($requests as $key => $request) {
			if($request->code === null) {
				$curl_opts = array();
				$requestUrl = $this::$gatewayUrl . '?';
				$sysParams['method'] = $request->getApiMethodName();
				
				foreach ($sysParams as $sysParamKey => $sysParamValue) {
					$requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
				}
				
				$requestUrl = substr($requestUrl, 0, -1);
				
				$apiParams = $request->getApiParas();
				
				$curl_opts['url'] = $requestUrl;
				$curl_opts['postFields'] = $apiParams;
				
				$curl_requests_opts[$key] = $curl_opts;
			}
			else {
				$curl_requests_opts[$key] = null;
			}
		}
		
		$responses = $this->mutil_curl($curl_requests_opts);
		foreach ($requests as $moudle => $node) {
			$resp = $responses[$moudle];
			$resp = $resp['response'];
			if ($resp != null) {
				$respWellFormed = false;
				if ('json' == $this->format) {
					$respObject = json_decode($resp);
					if (null !== $respObject)
					{
						$respWellFormed = true;
						foreach ($respObject as $propKey => $propValue)
						{
							$respObject = $propValue;
						}
					}
				}
				else if("xml" == $this->format) {
					$respObject = @simplexml_load_string($resp);
					if (false !== $respObject)
					{
						$respWellFormed = true;
					}
				}
				
				//返回的HTTP文本不是标准JSON或者XML，记下错误日志
				if (false === $respWellFormed)
				{
					$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_RESPONSE_NOT_WELL_FORMED",$resp);
					$node->code = 0;
					$node->msg = "HTTP_RESPONSE_NOT_WELL_FORMED";
					continue;
				}
				
				//如果TOP返回了错误码，记录到业务错误日志中
				if (isset($node->code))
				{
					$logger = new LtLogger;
					$logger->conf["log_file"] = rtrim(TOP_SDK_WORK_DIR, '\\/') . '/' . "logs/top_biz_err_" . $this->appkey . "_" . date("Y-m-d") . ".log";
					$logger->log(array(
						date("Y-m-d H:i:s"),
						$resp
					));
				}
				$node->response = $respObject;
			}
		}
		return $requests;
	}
	
	public function execute_with_signal($requests, $access_token = null) 
	{
		if ($this->checkRequest) {
			foreach ($requests as $request) {
				try {
					$request->check();
				} catch (Exception $e) {
					$result->code = $e->getCode();
					$result->msg = $e->getMessage();
				}
			}
		}
		
		$curl_requests_opts = array();
		foreach ($requests as $key => $request) {
			if ($request->code === null) {
				$curl_opts = array();
				//组装系统参数
				$sysParams["app_key"] = $this->appkey;
				$sysParams["v"] = $this->apiVersion;
				$sysParams["format"] = $this->format;
				$sysParams["sign_method"] = $this->signMethod;
				$sysParams['method'] = $request->getApiMethodName();
				$sysParams["timestamp"] = date("Y-m-d H:i:s");
				$sysParams["partner_id"] = $this->sdkVersion;
				if (null != $access_token) {
					$sysParams["session"] = $access_token;
				}
				//获取业务参数
				$apiParams = $request->getApiParas();
				//签名
				$sysParams["sign"] = $this->generateSign(array_merge($apiParams, $sysParams));
				$requestUrl = $this::$gatewayUrl . "?";
				
				foreach ($sysParams as $sysParamKey => $sysParamValue)
				{
					$requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
				}
				$requestUrl = substr($requestUrl, 0, -1);
				
				$curl_opts['url'] = $requestUrl;
				$curl_opts['postFields'] = $apiParams;
				$curl_requests_opts[$key] = $curl_opts;
			}
			else {
				$curl_requests_opts[$key] = null;
			}
		}
		
		$responses = $this->mutil_curl($curl_requests_opts);
		foreach ($requests as $key => $request) {
			$resp = $responses[$key]['response'];
			$respWellFormed = false;
			if ("json" == $this->format)
			{
				$respObject = json_decode($resp);
				if (null !== $respObject)
				{
					$respWellFormed = true;
					foreach ($respObject as $propKey => $propValue)
					{
						$respObject = $propValue;
					}
				}
			}
			else if("xml" == $this->format)
			{
				$respObject = @simplexml_load_string($resp);
				if (false !== $respObject)
				{
					$respWellFormed = true;
				}
			}
	
			//返回的HTTP文本不是标准JSON或者XML，记下错误日志
			if (false === $respWellFormed)
			{
				$this->logCommunicationError($sysParams["method"],$requestUrl,"HTTP_RESPONSE_NOT_WELL_FORMED",$resp);
				$request->code = 0;
				$request->msg = "HTTP_RESPONSE_NOT_WELL_FORMED";
				continue;
			}
	
			//如果TOP返回了错误码，记录到业务错误日志中
			if (isset($respObject->code))
			{
				$logger = new LtLogger;
				$logger->conf["log_file"] = rtrim(TOP_SDK_WORK_DIR, '\\/') . '/' . "logs/top_biz_err_" . $this->appkey . "_" . date("Y-m-d") . ".log";
				$logger->log(array(
					date("Y-m-d H:i:s"),
					$resp
				));
			}
			$request->response = $resp;
		}
		return $requests;
	}
	
	public function execute($request, $access_token = null)
	{
		$requests = array();
		if (!is_array($request)) {
			$requests[0] = $request;
		}
		else {
			$requests = $request;
		}
		if (self::$isSignal) {
			return $this->execute_with_signal($requests, $access_token);
		}
		else {
			return $this->execute_with_nosignal($requests, $access_token);
		}
	}

	public function exec($paramsArray)
	{
		if (!isset($paramsArray["method"]))
		{
			trigger_error("No api name passed");
		}
		$inflector = new LtInflector;
		$inflector->conf["separator"] = ".";
		$requestClassName = ucfirst($inflector->camelize(substr($paramsArray["method"], 7))) . "Request";
		if (!class_exists($requestClassName))
		{
			trigger_error("No such api: " . $paramsArray["method"]);
		}

		$session = isset($paramsArray["session"]) ? $paramsArray["session"] : null;

		$req = new $requestClassName;
		foreach($paramsArray as $paraKey => $paraValue)
		{
			$inflector->conf["separator"] = "_";
			$setterMethodName = $inflector->camelize($paraKey);
			$inflector->conf["separator"] = ".";
			$setterMethodName = "set" . $inflector->camelize($setterMethodName);
			if (method_exists($req, $setterMethodName))
			{
				$req->$setterMethodName($paraValue);
			}
		}
		return $this->execute($req, $session);
	}
}