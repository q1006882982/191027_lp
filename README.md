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

app中
    app::getConfig()
继承controller
    $this->config
    
自动加载
app
app->lib
framework


