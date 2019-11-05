# 191027_lp
framework

http://www.m.com/index.php/index/index/index

默认文件
index m.php;
nginx 配置
location / {
     if (!-e $request_filename){
          rewrite ^/(.*)$ /m.php/$1 last;
     }
}

自动加载
app下
app->lib下
framework下

app中
    app::getConfig()
    app::getRequtst()
    

controller
//方法名
方法 只可以 数字,大小写字母
//跳转
$this->redirect('admin','index','index');
//生成url
$url = Request::url('admin','a','index');



