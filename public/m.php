<?php
/**
 * User: lp
 * Time: 2019/10/27--9:50
 */
header("Content-type: text/html; charset=utf-8");
define('DS', DIRECTORY_SEPARATOR);
//debug
define('APP_DEBUG', true);
define('TIME', false);
//静态目录
//define('STATIC_PATH', '/static/');


require __DIR__.DS.'..'.DS.'framework/start.php';