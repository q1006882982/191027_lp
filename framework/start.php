<?php
/**
 * User: lp
 * Time: 2019/10/27--10:01
 */
$start_time = microtime(true);
define('ROOT_PATH', __DIR__.DS.'..'.DS);
define('FRAME_PATH', ROOT_PATH.'framework'.DS);
define('RUN_PATH', ROOT_PATH.'runtime'.DS);
define('APP_PATH', ROOT_PATH.'app'.DS);
define('CONFIG_PATH', ROOT_PATH.'app'.DS.'config'.DS);
define('APP_LIB_PATH', ROOT_PATH.'app'.DS.'lib'.DS);

if (!APP_DEBUG){
    ini_set('display_errors', 'Off');
}

//加载函数
include FRAME_PATH.'function.php';
//加载必须类
include FRAME_PATH.'core/Loder.php';
//加载非必须类
include FRAME_PATH.'core/Error.php';
include FRAME_PATH.'core/App.php';
include FRAME_PATH.'core/Config.php';
include FRAME_PATH.'core/Request.php';

//自动加载
\framework\core\Loder::init();
//错误处理
\framework\core\Error::init();
//执行
\framework\core\App::init();

$end_time = microtime(true);
if (TIME){
    echo '<script>console.log('.($end_time-$start_time).')</script>';
}


