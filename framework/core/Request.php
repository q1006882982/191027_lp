<?php
/**
 * User: lp
 * Time: 2019/10/27--14:11
 */
namespace framework\core;

class Request{
    private static $moudle='';
    private static $controller = '';
    private static $method = '';

    public static function init()
    {
        $path_info = $_SERVER['PATH_INFO'];
        $path_info = substr($path_info, 1);
        $config = App::getConfig();
        $default_routing_arr = $config::get('routing');
        $default_module = $default_routing_arr['moudle'];
        $default_controller = $default_routing_arr['controller'];
        $default_method = $default_routing_arr['method'];
        //path_info=''
        if (empty($path_info)){
            $path_info = $default_module.'/'.$default_controller.'/'.$default_method;
        }
        $url_path_arr = explode('/', $path_info);
        //path_info非法
        self::$moudle = Tool::inputCheck($url_path_arr[0], $default_module);
        self::$controller = Tool::inputCheck($url_path_arr[1], $default_controller);
        self::$method = Tool::inputCheck($url_path_arr[2], $default_method);
    }

    public static function getMoudle()
    {
        return self::$moudle;
    }

    public static function getController()
    {
        return self::$controller;
    }

    public static function getMethod()
    {
        return self::$method;
    }

    public static function fget($key='', $default=false)
    {
        $get = [];
        $pattern = '/^[0-9a-zA-Z\.]+$/i';
        if (empty($key)){
            foreach ($_GET as $key=>$item) {
                if (preg_match($pattern, $item)){
                    $get[$key] = $item;
                }
            }
            return $get;
        }

        if (preg_match($pattern, $_GET[$key])){
            $get[$key] = $_GET[$key];
        }else{
            $get[$key] = $default;
        }
        return $get[$key];
    }

    public static function fpost($key='', $default=false)
    {
        $get = [];
        $pattern = '/^[0-9a-zA-Z\.]+$/i';
        if (empty($key)){
            foreach ($_POST as $key=>$item) {
                if (preg_match($pattern, $item)){
                    $get[$key] = $item;
                }
            }
            return $get;
        }

        if (preg_match($pattern, $_POST[$key])){
            $get[$key] = $_POST[$key];
        }else{
            $get[$key] = $default;
        }
        return $get[$key];
    }

    public static function isGet()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            return true;
        }
        return false;
    }

    public static function isPost()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            return true;
        }
        return false;
    }

    public static function url($module, $controller, $method)
    {

    }
}