<?php
	header("Content-Type:text/html;charset=UTF-8");
	require_once 'config.php';
?>	
<html>
<head>
<title>一口价商品上架</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src=js/colors.js></script>
</head>
<body>

<p>一口价商品上架</p>

<?php
if(isset($_POST['su'])){
/* 一口价商品上架 Start*/

	//参数数组
	$paramArr = array(

		/* API系统级输入参数 Start */

	    	'method' => 'taobao.item.update.listing',  //API名称
		   'session' => $sessions, //session
	     'timestamp' => date('Y-m-d H:i:s'),			
		    'format' => 'xml',  //返回格式,本demo仅支持xml
    	   'app_key' => $appKey,  //Appkey			
	    		 'v' => '2.0',   //API版本号		   
		'sign_method'=> 'md5', //签名方式			

		/* API系统级参数 End */				 

		/* API应用级输入参数 Start*/

			   'iid' => $iid, //商品字符串ID
		   'num_iid' => $num_iid, //商品数字ID			   
			   'num' => $num, //上架数量

				
		/* API应用级输入参数 End*/
	);

	//生成签名
	$sign = createSign($paramArr,$appSecret);
	
	//组织参数
	$strParam = createStrParam($paramArr);
	$strParam .= 'sign='.$sign;
	
	//构造Url
	$urls = $url.$strParam;
	
	//连接超时自动重试
	$cnt=0;	
	while($cnt < 3 && ($result=@vita_get_url_content($urls))===FALSE) $cnt++;
	
	//解析Xml数据
	$result = getXmlData($result);

	//获取错误信息
	$msg = $result['sub_msg'];
	

	
/* 一口价商品上架 End*/	


	if(empty($msg)){
		echo '<table><tr><th>成功上架</th></tr>';

		echo '<tr><td>商品修改时间：'.$result['item']['modified'].'</td></tr>';
		echo '<tr><td>商品数字ＩＤ：'.$result['item']['num_iid'].'</td>';
		echo '</tr></table>';
	}else{
		echo '<br>'.$msg;

	}
}else{

	/* Build By fhalipay */
	
/* 得到单个商品信息 Start*/
	
	//参数数组
	$paramArr = array(

		/* API系统级输入参数 Start */

	    	'method' => 'taobao.item.get',  //API名称
		   'session' => $sessions, //session
	     'timestamp' => date('Y-m-d H:i:s'),			
		    'format' => 'xml',  //返回格式,本demo仅支持xml
    	   'app_key' => $appKey,  //Appkey			
	    		 'v' => '2.0',   //API版本号		   
		'sign_method'=> 'md5', //签名方式			

		/* API系统级参数 End */				 

		/* API应用级输入参数 Start*/

	    	'fields' => 'sku',  //返回字段
//              'nick' => $userNick,  //卖家昵称
			   'iid' => $iid, //商品id  
		   'num_iid' => $num_iid,//商品数字id  
			  
		/* API应用级输入参数 End*/
	);


	//生成签名
	$sign = createSign($paramArr,$appSecret);
	
	//组织参数
	$strParam = createStrParam($paramArr);
	$strParam .= 'sign='.$sign;
	
	//构造Url
	$urls = $url.$strParam;

	$result = vita_get_url_content($urls);

	//解析Xml数据
	$result = getXmlData($result);
	
	//获取返回信息

	$quantity = $result['item']['skus']['sku']['quantity'];
	
/* 得到单个商品信息 End*/
?>
<form action="" method="post">
	<?php if($quantity==''){
		echo '<br>请输入上架数量：<input type="text" name="num" value="">';
	}else{
		echo '<br>请输入上架数量：<input type="text" readonly name="num" value="'. $quantity.'">';
	}?>
    <input type="submit" name="su" value="上架">
</form>
<?php }?>


</body>
</html>
