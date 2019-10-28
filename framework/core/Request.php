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
        $url_path_arr = explode('/', $path_info);

        $config = App::getConfig();
        $default_routing_arr = $config::get('routing');
        self::$moudle = Tool::input_check($url_path_arr[0], $default_routing_arr['moudle']);
        self::$controller = Tool::input_check($url_path_arr[1], $default_routing_arr['controller']);
        self::$method = Tool::input_check($url_path_arr[2], $default_routing_arr['method']);
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
}
 