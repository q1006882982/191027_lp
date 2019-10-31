<?php
/**
 * User: lp
 * Time: 2019/10/27--10:01
 */
$start_time = microtime(true);
define('ROOT_PATH', __DIR__.DS.'..'.DS);
define('FRAME_PATH', ROOT_PATH.'framework'.DS);
define('APP_PATH', ROOT_PATH.'app'.DS);
define('CONFIG_PATH', ROOT_PATH.'app'.DS.'config'.DS);
define('STATIC_PATH', ROOT_PATH.'app'.DS.'public'.DS.'static'.DS);
define('APP_DEBUG', true);
define('TIME', false);

if (!APP_DEBUG){
    ini_set('display_errors', 'Off');
}

//加载函数
include FRAME_PATH.'function.php';
//自动加载
include FRAME_PATH.'core/Loder.php';
\framework\core\Loder::init();
//错误处理
\framework\core\Error::init();
//执行
\framework\core\App::init();

$end_time = microtime(true);
if (TIME){
    echo '<script>console.log('.($end_time-$start_time).')</script>';
}


