<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>在线商城后台登录</title>
<link rel="stylesheet" type="text/css" href="/static/admin/css/basic.css" />
<link rel="stylesheet" type="text/css" href="/static/admin/css/login.css" />
</head>
<body>

<div id="login">
	<form method="post" name="login" action="?a=admin&m=login">
		<input type="hidden" name="ajaxlogin" id="ajaxlogin" />
		<input type="hidden" name="ajaxcode" id="ajaxcode" />
		<dl>
			<dd>管理员姓名：<input type="text" name="user"" class="text" /></dd>
			<dd>管理员密码：<input type="password" name="pass"  class="text" /></dd>
			<dd>验　证　码：<input type="text" style="text-transform:uppercase;" name="code" class="text" /></dd>
			<dd class="code"><img src="?a=call&m=validateCode" title="看不清？点击刷新" onclick="javascript:this.src='?a=call&m=validateCode&tm='+Math.random()" /></dd>
			<dd><input type="submit" class="submit" name="send" onclick="return adminLogin();" value="进入管理中心" /></dd>
		</dl>
	</form>
</div>

</body>
</html>