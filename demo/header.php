<?php
	$ref =$_SERVER['SCRIPT_NAME'];
	if(empty($sessions)){
		echo 'SESSION状态：异常<a href="'.$sessionurl.$appKey.'&ref='.$ref.'">获取Session</a>';exit;
	}else{
		echo '当前登陆用户:'.$userNick.'<a href="login.php?ac=logout&ref='.$ref.'">退出登陆</a>';
	}
?>
<br />
<a href="taobao.items.onsale.get.php">出售中的宝贝</a>
<a href="taobao.items.inventory.get.php">仓库中的宝贝</a>
