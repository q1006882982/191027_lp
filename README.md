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
