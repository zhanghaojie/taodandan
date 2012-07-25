<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Insert title here</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="Public/js/jquery-ui/themes/base/jquery.ui.all.css">
	<link rel="stylesheet" href="demos.css">
	<!--  sina weibo js -->
	<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=1166443256" type="text/javascript" charset="utf-8"></script>
	<!--  jquery-ui js -->
	<script src="Public/js/jquery-ui/jquery-1.7.2.js"></script>
	<script src="Public/js/jquery-ui/external/jquery.bgiframe-2.1.2.js"></script>
	<script src="Public/js/jquery-ui/external/globalize.js"></script>
	<script src="Public/js/jquery-ui/external/globalize.culture.de-DE.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.core.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.widget.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.mouse.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.accordion.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.autocomplete.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.button.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.datepicker.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.dialog.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.draggable.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.droppable.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.menu.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.position.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.progressbar.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.resizable.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.selectable.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.slider.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.sortable.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.spinner.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.tabs.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.ui.tooltip.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.core.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.blind.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.bounce.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.clip.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.drop.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.explode.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.fold.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.highlight.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.pulsate.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.scale.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.shake.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.slide.js"></script>
	<script src="Public/js/jquery-ui/ui/jquery.effects.transfer.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-af.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ar.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ar-DZ.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-az.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-bs.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-bg.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ca.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-cs.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-cy-GB.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-da.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-de.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-el.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-en-AU.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-en-GB.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-en-NZ.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-eo.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-es.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-et.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-eu.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-fa.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-fi.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-fo.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-fr.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-fr-CH.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-gl.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-he.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-hi.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-hr.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-hu.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-hy.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-id.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-is.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-it.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ja.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ka.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-kk.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-km.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ko.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-lb.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-lt.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-lv.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-mk.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ml.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ms.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-nl.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-nl-BE.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-no.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-pl.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-pt.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-pt-BR.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-rm.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ro.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ru.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-sk.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-sl.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-sq.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-sr.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-sr-SR.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-sv.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-ta.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-th.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-tj.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-tr.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-uk.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-vi.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-zh-HK.js"></script>
	<script src="Public/js/jquery-ui/ui/i18n/jquery.ui.datepicker-zh-TW.js"></script>
</head>
<body>
	<a href="__APP__/index/login">登陆</a> &nbsp;&nbsp;&nbsp;&nbsp;
	<a href="__APP__/index/shareInSinaWeibo" target="weibo">新浪分享</a> &nbsp;&nbsp;&nbsp;&nbsp;
	
	<div>
		这是我们的首页！！！
	</div>
	<div id="wb_follow_btn" style="width:50em;height:80px;border:1px solid #bbb;background:#eee; padding:5px 2px;">关注按钮容器</div>
	<script>
		WB2.anyWhere(function(W){
			W.widget.followButton({
				'nick_name': '在阳光中裸奔',	//用户昵称
				'id': "wb_follow_btn"
			});
		});
	</script>
	<br>
	<a>分享获取积分</a>
	<br><br><br><br><br><br>
<span id="card" href=" http://weibo.com " wb_screen_name="微博名称" >微博名称</span>
<a id="wb_uid" wb_user_id="1052981072" href="http://www.woiweb.net" >woiweb</a>

批量定义：
<div id="search">
    <a wb_screen_name="flashsoft" href="http://weibo.com">flashsoft</a>
    @woiweb
</div>
<div id="weibo_uid_area">
    <a href="http://www.woiweb.net" wb_user_id="1052981072">woiweb</a>
    <span wb_user_id="1639733600">金山</span>
</div>
<script>
WB2.anyWhere(function(W){
    W.widget.hoverCard({
        id: "card"
    });
    W.widget.hoverCard({
        id: "search",
        search: true
	}); 
    W.widget.hoverCard({
        id: "wb_uid"
    });	
    W.widget.hoverCard({
        id: "weibo_uid_area",
        tag: "span",
        search: true
    });
});

</script>


</body>
</html>