<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>后台管理</title>
		<script type="text/javascript" src="/top/Public/js/jquery.js"></script>
		<script type="text/javascript">
			function startMission() {
				$.post('launchSchedule');
				return false;
			}
		
		</script>
	</head>

	<body>
		<a href="__APP__/index/logout">注销</a> <br>
		<input type="button" onclick="startMission()" value="启动任务"></input> <br>
		<a href="__APP__/index/launchSchedule" target="new">启动任务</a> <br>
		<a href="__APP__/index/stopSchedule">暂停任务</a> <br>
	</body>
</html>