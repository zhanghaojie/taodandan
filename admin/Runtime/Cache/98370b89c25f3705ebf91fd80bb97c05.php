<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>登陆</title>
	</head>
		
	<body>
		<form action="__APP__/index/login" method="POST">
		<table>
			<tr>
				<td>
					用户名:
				</td>
				<td>
					<input type="text" name="user_name"/>
				</td>
			</tr>
			<tr>
				<td>
					密码:
				</td>
				<td>
					<input type="password" name="password"/> <br>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="登陆">
				</td>
			</tr>
		</table>
		</form>
	</body>
</html>