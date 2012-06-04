﻿<?php
	header("Content-Type:text/html;charset=UTF-8");
	require_once 'config.php';
?>	
<html>
<head>
<title>得到当前会话用户库存中的商品列表</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src=js/colors.js></script>
</head>
<body>

<p>得到当前会话用户库存中的商品列表</p>


<p id="msgs" style="height:24px;">
<?php include 'header.php';?>
</p>
<?php
	/* Build By fhalipay */
	
/* 得到当前会话用户库存中的商品列表 Start*/

	//参数数组
	$paramArr = array(

		/* API系统级输入参数 Start */

	    	'method' => 'taobao.items.inventory.get',  //API名称
		   'session' => $sessions, //session
	     'timestamp' => date('Y-m-d H:i:s'),			
		    'format' => 'xml',  //返回格式,本demo仅支持xml
    	   'app_key' => $appKey,  //Appkey			
	    		 'v' => '2.0',   //API版本号		   
		'sign_method'=> 'md5', //签名方式			

		/* API系统级参数 End */				 

		/* API应用级输入参数 Start*/

			'fields' => 'approve_status,iid,num_iid,title,nick,type,cid,pic_url,num,props,valid_thru,list_time,price,has_discount,has_invoice,has_warranty,has_showcase,modified,delist_time,postage_id,seller_cids,outer_id',
				 'q' => $q, //搜索字段。搜索商品的title。 
			'banner' => $banner, //分类字段
			   'cid' => $cid, //商品类目ID。ItemCat中的cid字段。可以通过taobao.itemcats.get取到 
	   'seller_cids' => $seller_cids, //卖家店铺内自定义类目ID。多个之间用“,”分隔。可以根据taobao.sellercats.list.get获得 
	       'page_no' => $page_no, //页码。取值范围:大于零的整数;默认值为1，即返回第一页数据。 
		 'page_size' => $page_size, //每页条数。取值范围:大于零的整数;最大值：200；默认值：40。 
      'has_discount' => $has_discount, //是否参与会员折扣。可选值：true，false。默认不过滤该条件
	      'order_by' => $order_by, //排序方式。格式为column:asc/desc ，column可选值:list_time(上架时间),delist_time(下架时间),num(商品数量);默认上架时间降序(即最新上架排在前面)。如按照上架时间降序排序方式为list_time:desc 
		 'is_taobao' => $is_taobao, //商品是否在淘宝显示 
		     'is_ex' => $is_ex, //商品是否在外部网店显示 
				
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
	$msg = $result['msg'];

	//返回结果
	$item = $result['items']['item'];
	$total_results = $result['total_results'];
	
/* 得到当前会话用户库存中的商品列表 End*/	

	
?>

<form action="" method="get" name="form1" id="form1">
<table border="0" width="100%" class="table">
  <tr>
    <td>自定义类目</td>
    <td><?php
/* 获取前台展示的店铺内卖家自定义商品类目 Start*/
	
	//参数数组
	$paramArr = array(

		/* API系统级输入参数 Start */

	    	'method' => 'taobao.sellercats.list.get',  //API名称
//		   'session' => $sessions, //session
	     'timestamp' => date('Y-m-d H:i:s'),			
		    'format' => 'xml',  //返回格式,本demo仅支持xml
    	   'app_key' => $appKey,  //Appkey			
	    		 'v' => '2.0',   //API版本号		   
		'sign_method'=> 'md5', //签名方式			

		/* API系统级参数 End */				 

		/* API应用级输入参数 Start*/

	    	'fields' => 'iid,detail_url,num_iid,title,nick,type,cid,seller_cids,props,input_pids,input_str,desc,pic_url,num,valid_thru,list_time,delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,has_invoice,has_warranty,has_showcase,modified,increment,auto_repost,approve_status,postage_id,product_id,auction_point,property_alias,item_imgs,prop_imgs,skus,outer_id,is_virtual,is_taobao,is_ex,videos,is_3D,score,volume,one_station',  //返回字段
//              'nick' => $userNick,  //卖家昵称
		   'nick' => $userNick,//商品数字id  
			  
		/* API应用级输入参数 End*/
	);


	//生成签名
	$sign = createSign($paramArr,$appSecret);
	
	//组织参数
	$strParam = createStrParam($paramArr);
	$strParam .= 'sign='.$sign;
	
	//构造Url
	$urls = $url.$strParam;

	$shop = vita_get_url_content($urls);

	//解析Xml数据
	$shop = getXmlData($shop);
	$shop = $shop['seller_cats']['seller_cat'];
	
/* 获取前台展示的店铺内卖家自定义商品类目 End*/	
?>
      <select name="seller_cids">
        <option value="">选择</option>
        <?php
		foreach ($shop as $key=>$val){
    ?>
        <option value="<?php echo $val['cid']?>"><?php echo $val['name']?></option>
        <?php }?>
      </select></td>  
    <td>是否参参与折扣</td>
    <td>
    <select name="has_discount">
    <option value="">选择</option>       
    <option value="true">是</option>
    <option value="false">否</option>    
    </select>    </td>
    <td>是否在淘宝显示 </td>
    <td>
    <select name="is_tabao">
    <option value="">选择</option>       
    <option value="true">是</option>
    <option value="false">否</option>    
    </select>    </td>
    
    <td>是否在外部网店显示 </td>
    <td>
    <select name="is_ex">
    <option value="">选择</option>       
    <option value="true">是</option>
    <option value="false">否</option>    
    </select>    </td>    
  </tr>  
  <tr bgcolor="#dddddd">
    <td>所有类目</td>
    <td><?php require_once 'allItemcats.php';?></td>
    <td>状态</td>
    <td><select name="banner">
      <option value="">选择</option>
      <option value="unsold">(没卖出的) </option>
      <option value="partly_sold">(部分卖出的) </option>
      <option value="regular_shelved">(定时上架) </option>
      <option value="never_on_shelf">(从未上架) </option>
      <option value="sold_out">(全部卖完) </option>
      <option value="off_shelf">(我下架的) </option>
      <option value="for_shelved">(等待所有上架) </option>
    </select></td>

    <td>商品标题</td>    
    <td><input type="text" name="q" id="q"></td>
    <td>排序</td>
    <td>
    <select name="order_by">
    <option value="">选择</option>       
    <option value="list_time:desc">上架时间降序</option>
    <option value="list_time：asc">上架时间升序</option>    
    <option value="delist_time:desc">下架时间降序</option>
    <option value="delist_time：asc">下架时间升序</option>    
    <option value="num:desc">商品数量降序</option>
    <option value="num：asc">商品数量升序</option>          
    </select>    </td>
  </tr>
  <tr>
    <td colspan="8" bgcolor="#FFFFFF">
    <input type="submit" value="搜索" >    </td>
  <tr>
</table>
</form>

<table border="0" width="100%" class="table">
  <tr>
 
    <td>宝贝名称</td> 
    <td>数量</td> 

    <td>价格</td> 
    <td>修改设置</td>
  </tr>
  <?php 
  if(!empty($msg)){
  //错误信息
  	echo '<tr><td colspan=4>错误信息:'.$msg.'</td></tr>';
  }else{
  //处理正确返回信息
	if ($total_results==''){
	echo '<tr><td colspan=4>没有合乎条件的数据</td></tr>';	
	}else if($total_results=='1'){	
  ?>  
  <tr>
    <td><?php echo $item['title'];?></td>
    <td><?php echo $item['num'];?></td>

    <td><?php echo $item['price'];?></td>
    <td><a href="taobao.item.update.listing.php?num_iid=<?php echo $item['num_iid'];?>" target="_blank">宝贝上架</a></td>
  </tr>  
  <?php
	}else{
  foreach ($item as $key => $val){
  ?>
  <tr>
    <td><?php echo $val['title'];?></td>
    <td><?php echo $val['num'];?></td>
    <td><?php echo $val['price'];?></td>

    <td><a href="taobao.item.update.listing.php?num_iid=<?php echo $val['num_iid'];?>" target="_blank">宝贝上架</a></td>
  </tr>
  <?php
  }
  }
  ?>
         
 
  <tr>
    <td colspan="15"> 
	 <?php
	// 分页 new PageClass(数据总数,每页数量,页码,URL组成);
	$pages = new PageClass($total_results,$page_size,$_GET['page'],'?'.$_SERVER['QUERY_STRING'].'&page={page}');
	echo $pages -> myde_write();
	?>    </td>
  </tr>    
</table>
<?php }?>

</body>
</html>
