<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYP html>

<html xmlns=http://www.w3.org/1999/xhtml>

<head>

<meta charset=utf-8">

<title>mainpage</title>

<link rel="stylesheet" type="text/css" href="mainpage.css" />



<link rel="stylesheet" type="text/css" href="share.css" />

<script type="text/javascript">

 function showshare(){

  document.getElementById('share_sina').style.display="block";

}

 function hideshare(){

  document.getElementById('share_sina').style.display="none";

}

</script>

</head>

<body>

  <div id="main_box">



  <div id="main_top">

  </div> 

  <div id="main_head"> 

  </div> 

  <div id="main_content">
  <a href="__APP__/index/createTask">创建任务</a>
  <a href="__APP__/index/getTaskResult">获取任务结果</a>
  <div id="main_content_left">

    <h3 id="main_content_left_top">掌柜说-主页</h3>

    <h3 id="main_content_left_top">掌柜说-自动上架</h3>

    <div id="main_content_left_menu">

     <label id="main_content_left_menu_l">自动上架开关设置</label>

     <label id="main_content_left_menu_l">自动上货参数设置</label>

     <label id="main_content_left_menu_l">自动上货智能管理</label>

     <label id="main_content_left_menu_l">自动上货精准管理</label>

     <label id="main_content_left_menu_l">自动上货任务列表</label>

    </div>

    <h3 id="main_content_left_top">掌柜说自动橱窗</h3> 

    <div id="main_content_left_help"></div>

    <div id="main_content_left_contect"></div> 

  </div>

  <div id="main_content_right">

  </div>

  </div>

  <div id="main_foot"></div>

  </div>

   <div>

   <a href="javascript:showshare()">分享到新浪微博</a>

   </div>

    <div id="share_sina">

   <div id="share_sina_login">

   新浪微博

   加入微博一起分享新鲜事

   <a href="">登录</a>

   <a href="">注册</a>

   <a href="javascript:hideshare()">关闭</a>

   </div>

   <div id="share_sina_content">

   <a href="">分享到微博</a>

   <a href="">分享到微群</a>

   <textarea>

   </textarea>

   <a href="">分享</a>

   </div>

  </div>

  </div> 



</body>

</html>