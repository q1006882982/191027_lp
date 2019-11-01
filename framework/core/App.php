<?php
/**
 * User: lp
 * Time: 2019/10/27--10:15
 */
namespace framework\core;

class App{
    public static function init()
    {
        //request
        Request::init();
        //mvc
        $module = Request::getMoudle();
        $controller = Request::getController();
        $method = Request::getMethod();
        $nclass_str = "app\\{$module}\\controller\\{$controller}";
        $is_class = class_exists($nclass_str);
        if (!$is_class){
            $exception_str = "控制器类不存在: {$nclass_str}";
            self::doNo($exception_str);
        }
        $nclass = new $nclass_str();
        $is_method = method_exists($nclass, $method);
        if (!$is_method){
            $exception_str = "类的方法不存在: {$method}";
            self::doNo($exception_str);
        }
        $nclass->$method();
    }
    //private
    private static function doNo($str)
    {
        if (APP_DEBUG){
            throw new \Exception($str);
        }else{
            $config = self::getConfig();
            $exception_arr = $config::get('base','exception');
            $empty_class = $exception_arr['empty_class'];
            $empty_method = $exception_arr['empty_method'];
            $nclass = new $empty_class();
            $nclass->$empty_method();
        }
    }

    public static function getRequest()
    {
        return new Request();
    }

    public static function getConfig()
    {
        return new Config();
    }

    public static function getCache()
    {
        return new Cache();
    }
}
 