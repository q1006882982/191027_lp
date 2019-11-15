<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线商城后台管理</title>
<link rel="stylesheet" type="text/css" href="/static/admin/css/basic.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/css/admin.css" />
    <script src="/static/common/lib/jquery.1.12/jquery.js"></script>
</head>
<body>

<div id="header">
	<p>您好，{$admin.user} [{$admin.level}] [<a href="<?php echo url('index/index/index');?>">去首页</a>] [<a href="?a=admin&m=logout">退出</a>]</p>
	<ul class="menu">
		<li class="first"><a href="<?php echo $this->url('admin/index/welcome');?>" target="in">起始页</a></li>
		<li><a href="javascript:void(0)">商品</a></li>
		<li><a href="javascript:void(0)">订单</a></li>
		<li><a href="javascript:void(0)">会员</a></li>
		<li><a href="javascript:void(0)">系统</a></li>
	</ul>
</div>


<div id="sidebar">
	<dl style="display:block">
		<dt>商品</dt>
		<dd><a href="?a=nav" target="in">导航条列表</a></dd>
		<dd><a href="?a=goods" target="in">商品列表</a></dd>
		<dd><a href="?a=attr" target="in">自定义属性</a></dd>
		<dd><a href="?a=price" target="in">价格区间</a></dd>
		<dd><a href="?a=brand" target="in">品牌列表</a></dd>
		<dd><a href="?a=service" target="in">售后服务</a></dd>
		<dd><a href="?a=commend" target="in">评价管理</a></dd>
	</dl>
	<dl style="display:none">
		<dt>订单</dt>
		<dd><a href="?a=order" target="in">订单列表</a></dd>
		<dd><a href="?a=delivery" target="in">物流配送</a></dd>
		<dd><a href="###">订单3</a></dd>
	</dl>
	<dl style="display:none">
		<dt>会员</dt>
		<dd><a href="###">会员1</a></dd>
		<dd><a href="###">会员2</a></dd>
		<dd><a href="###">会员3</a></dd>
	</dl>
	<dl style="display:none">
		<dt>系统</dt>
		<dd><a href="<?php echo $this->url('admin/manage/show');?>" target="in">管理员列表</a></dd>
		<dd><a href="###">等级列表(自行完成)</a></dd>
		<dd><a href="###">权限管理(自行完成)</a></dd>
		<dd><a href="?a=edit" target="in">模版编辑器</a></dd>
		<dd><a href="?a=pic" target="in">图片管理器</a></dd>
	</dl>
</div>

<div id="main">
	<iframe src="<?php echo $this->url('admin/index/welcome');?>" frameborder="0" name="in"></iframe>
</div>


<script>
    var width = document.documentElement.clientWidth - 180;
    var height = document.documentElement.clientHeight - 80;

    if (width >= 0) document.getElementById('main').style.width = width + 'px';
    if (height >= 0) {
        document.getElementById('sidebar').style.height = height + 'px';
        document.getElementById('main').style.height = height + 'px';
    }

    var $menu_li = $('.menu li');
    var $sidebar_dl = $('#sidebar dl');

    $menu_li.on('click', function (){
        var index = $(this).index()
        if (index > 0){
            $sidebar_dl.hide();
            $sidebar_dl.eq(index-1).show();
        }
    });
</script>
</body>
</html>