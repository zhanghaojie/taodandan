<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" src="./Public/public.js" type="text/javascript"></script>
<title>Insert title here</title>
</head>
<body>
<a href="__APP__/index/tbLogin">登陆</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="__APP__/index/topLogin">TOP登陆</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="__APP__/index/tbLogout">注销</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="__APP__/index/getUser">获取用户信息</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="__APP__/index/getAuthorizeItems">获取用户注册的商品</a> &nbsp;&nbsp;&nbsp;&nbsp;
<a href="__APP__/index/getAuthorizeItemsWithTopSession">TOP获取用户注册的商品</a> &nbsp;&nbsp;&nbsp;&nbsp;
<br>

<div style="text-align:center"> 
<div id="processing"></div> 
<form action="__APP__/index/uploadFile" method="post" enctype="multipart/form-data" target="form-target" onsubmit="startUpload();"> 
<input type="hidden" name="MAX_FILE_SIZE" value="1000000" /> 
<input type="file" name="myfile1" /> <br/>
<input type="file" name="myfile2" /> <br/>
<input type="file" name="myfile3" /> <br/>
<input type="file" name="myfile4" /> <br/>
<input type="file" name="myfile5" /> <br/>
<input type="file" name="myfile6" /> <br/>
<input type="file" name="myfile7" /> <br/>
<input type="file" name="myfile8" /> <br/>
<input type="file" name="myfile9" /> <br/><br/>
<input type="submit" name="sub" value="upload" /> 
</form>
<iframe style="width:0; height:0; border:0;" name="form-target"></iframe> 
</div> 


</body>
</html>