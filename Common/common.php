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
	curl_setopt($ch, CURLOPT_URL,TB_AUTH_TOKEN_URL);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	if ($params) {
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}
	$json_result = curl_exec($ch);
	curl_close($ch);
	if ($json_result) {
		$decode_result = json_decode($json_result, true);
		return $decode_result;
	}
	return false;
}