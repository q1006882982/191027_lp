<?php
/**
 * User: lp
 * Time: 2019/10/27--10:01
 */
namespace framework\core;

//echo __NAMESPACE__;exit;
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
//autoload
spl_autoload_register(__NAMESPACE__.'\app_auto');
function app_auto($class_name)
{
    $name_arr = explode('\\', $class_name);
    $name_pre = $name_arr[0];

    $path_str = '';
    $name_count = count($name_arr);
    foreach ($name_arr as $key=>$item) {
        if ($key == ($name_count-1)){
            $path_str .= ucfirst($item).DS;
        }else{
            $path_str .= $item.DS;
        }
    }
    $path_str = substr($path_str, 0, -1);

    if ($name_pre == 'framework' || $name_pre == 'app'){
        $file_path = ROOT_PATH.$path_str.'.php';
        if (is_file($file_path)){
            include $file_path;
        }
    }else{
        $file_path = APP_LIB_PATH.$path_str.'.php';
        if (is_file($file_path)){
            include $file_path;
        }
    }
}
//错误处理
//error
error_reporting(E_ALL);
set_exception_handler(__NAMESPACE__.'\app_exception');
set_error_handler(__NAMESPACE__.'\app_error');
register_shutdown_function(__NAMESPACE__.'\app_shutdown');
function app_exception($e)
{
    $code = $e->getCode();
    $msg = $e->getMessage();
    $file = $e->getFile();
    $line = $e->getLine();
    $time = date('Y-m-d H:i:s');
    $str = " time {$time} exception_handler: code {$code} 
         <br>错误信息:' {$msg}
         <br>错误位置: file {$file} on {$line} line";

    if (APP_DEBUG){
        echo $str;
    }else{

    }
}
function app_error($type, $message, $file, $line)
{
    $time = date('Y-m-d H:i:s');
    $str = "{$time} set_error_handler
        <br>错误信息: {$message}
        <br>错误位置: in {$file} on {$line} line <br>";
    if (APP_DEBUG) {
        echo $str;
    } else {
        //log
    }
}
function app_shutdown()
{
    if ($error = error_get_last()) {
        $time = date('Y-m-d H:i:s');
        $str = "\n " . $time . ' register_shutdown_function: Type:' . $error['type'] . ' Msg: ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'];
        if (APP_DEBUG) {
            echo $str;
        } else {
            //log
        }
    }
}
//配置类
class Config{
    public static $map = [];

    public static function get($key='', $file='base')
    {
        if (isset(self::$map[$file]) && !is_null(self::$map[$file])){
            return self::$map[$file][$key];
        }

        $file_path = CONFIG_PATH . $file .'.php';
        if (is_file($file_path)){
            $config_arr = include $file_path;
            self::$map[$file] = $config_arr;
            if (empty($key)){
                $res = $config_arr;
            }else{
                $res = $config_arr[$key];
            }
        }else{
            return false;
        }
        return $res;
    }
}
//处理请求
$path_info = $_SERVER['PATH_INFO'];
$path_info = substr($path_info, 1);
$default_routing_arr = Config::get('routing');
$default_module = $default_routing_arr['moudle'];
$default_controller = $default_routing_arr['controller'];
$default_method = $default_routing_arr['method'];
//path_info=''
if (empty($path_info)){
    $path_info = $default_module.'/'.$default_controller.'/'.$default_method;
}
$url_path_arr = explode('/', $path_info);
//path_info非法
define('MODULE_NAME', _input_check($url_path_arr[0], $default_module));
define('CONTROLLER_NAME', _input_check($url_path_arr[1], $default_controller));
define('METHOD_NAME', _input_check($url_path_arr[2], $default_method));
//私有,验证输入的url是否合法
function _input_check($data, $default=''){
    $pattern = '/^[0-9a-zA-Z]+$/i';
    if(preg_match($pattern, $data)){
        return $data;
    }else{
        return $default;
    }
}
//执行方法
$module = MODULE_NAME;
$controller = CONTROLLER_NAME;
$method = METHOD_NAME;
$nclass_str = "app\\{$module}\\controller\\{$controller}";
$is_class = class_exists($nclass_str);
if (!$is_class){
    $exception_str = "控制器类不存在: {$nclass_str}";
    _doe($exception_str);
}
$nclass = new $nclass_str();
$is_method = method_exists($nclass, $method);
if (!$is_method){
    $exception_str = "类的方法不存在: {$method}";
    _doe($exception_str);
}
$nclass->$method();
//私有处理空类,空方法
function _doe($str){
    if (APP_DEBUG){
        throw new \Exception($str);
    }else{
        $exception_arr = Config::get('exception');
        $empty_class = $exception_arr['empty_class'];
        $empty_method = $exception_arr['empty_method'];
        $nclass = new $empty_class();
        $nclass->$empty_method();
    }
}

$end_time = microtime(true);
if (TIME){
    echo '<script>console.log('.($end_time-$start_time).')</script>';
}


