<?php
/**
 * User: lp
 * Time: 2019/11/1--9:43
 */
namespace framework\core\mtrait;
use framework\core\Cache;
use framework\core\Config;
use framework\core\Request;

trait Container_common{

    protected static $map = [];
    /**
     * @var Config
     */
    private $config = null;
    /**
     * @var Request
     */
    private $request = null;
    /**
     * @var Cache
     */
    private $cache = null;


    public function __set($key, $val)
    {
        self::$map[$key] = $val;
    }

    public function __get($key)
    {
        if (isset(self::$map[$key]) && !is_null(self::$map[$key])){
            return self::$map[$key];
        }

        $fun = 'get'.ucfirst($key);
        $is_method = method_exists($this, $fun);
        if ($is_method){
            self::$map[$key] = $this->$fun();
            return self::$map[$key];
        }else{
            return null;
        }
    }

    protected function getConfig()
    {
        return new Config();
    }

    protected function getRequest()
    {
        return new Request();
    }

    protected function getCache()
    {
        return new Cache();
    }

}


 