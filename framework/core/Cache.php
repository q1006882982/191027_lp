<?php
/**
 * User: lp
 * Date: 2019/10/28--17:50
 */
namespace framework\core;
class Cache{

    private $drive = null;

    private static $instance = null;
    public static function getInstance()
    {
        if (!is_null(self::$instance)){
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }
    private function __construct(){
        $this->drive = $this->drive();
    }
    private function __clone(){}


    private function drive()
    {
        $cache = Config::get('cache');
        $drive = ucfirst($cache['type']);
        $class_name = 'framework\core\cache\\'.$drive;
        return new $class_name();
    }

    public static function tag($tag)
    {
        $that = self::getInstance();
        $that->drive->tag = $tag;
        return new self();
    }

    public static function set($key, $val, $time=0, $tag='')
    {
        $that = self::getInstance();
        $that->drive->set($key, $val, $time, $tag);
    }

    public static function get($key, $tag=0)
    {
        $that = self::getInstance();
        return $that->drive->get($key, $tag);
    }

    public static function clear($tag='')
    {
        $that = self::getInstance();
        return $that->drive->clear($tag);
    }

    public static function destroy()
    {
        $that = self::getInstance();
        return $that->drive->destroy();
    }
}
