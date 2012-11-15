<?php
// $url: string;
// $params: array;
// $method: post, get;
function sync_request($url, $params, $method='POST') {
	$o = '';
	foreach ($params as $k=>$v)
	{
		$o.= "$k=".urlencode($v)."&";
	}
	$post_data=substr($o,0,-1);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, $method==='POST');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	if ($params) {
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}
	$result = curl_exec($ch);
	curl_close($ch);
	/*
	if ($result) {
		$decode_result = json_decode($result, true);
		return $decode_result;
	}
	*/
	return $result;
}

function top_log($message) {
	if (is_array($message)) {
		$message = print_r($message, true);
	}
	Log::write($message, Log::DEBUG, Log::FILE, RUNTIME_PATH.'/top_debug.log');
}

function fire_log($message, $lable) {
	FirePHP::getInstance(true)->log($message, $lable);
}


