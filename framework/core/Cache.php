<?php
/**
 * User: lp
 * Date: 2019/10/28--17:50
 */
namespace framework\core;
class Cache{

    public static $instance = null;

    public static function getInstance()
    {
        if (!is_null(self::$instance)){
            return self::$instance;
        }
        self::$instance = self::drive();
        return self::$instance;
    }

    private static function drive()
    {
        $config = App::getConfig()::get('cache');
        $drive = ucfirst($config['type']);
        $class_name = 'framework\core\cache\\'.$drive;
        return new $class_name();
    }
    private function __construct(){}
    private function __clone(){
        // TODO: Implement __clone() method.
    }

    public static function set($key, $val, $time=0, $tag='')
    {
        $that = self::getInstance();
        $that->set($key, $val, $time, $tag);
    }

    public static function get($key, $tag=0)
    {
        $that = self::getInstance();
        return $that->get($key, $tag);
    }

    public static function clear($tag='')
    {
        $that = self::getInstance();
        return $that->clear($tag);
    }

    public static function destroy()
    {
        $that = self::getInstance();
        return $that->destroy();
    }
}
