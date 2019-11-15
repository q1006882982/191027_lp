<?php
/**
 * User: lp
 * Time: 2019/10/27--14:11
 */
namespace framework\core;

class Request{
    private static $instance = null;
    
    private function __construct()
    {
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
        define('MO_NAME', $this->inputCheck($url_path_arr[0], $default_module));
        define('CO_NAME', $this->inputCheck($url_path_arr[1], $default_controller));
        define('ME_NAME', $this->inputCheck($url_path_arr[2], $default_method));
    }
    private function __clone(){}

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function inputCheck($data, $default='')
    {
        $pattern = '/^[0-9a-zA-Z]+$/i';
        if(preg_match($pattern, $data)){
            return $data;
        }else{
            return $default;
        }
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

    public static function isAjax()
    {
        if (isset($_SERVER["HTTP_X_REQUESTED_WITH"])
            && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=='xmlhttprequest'
        )
        {
            return true;
        } else {
            return false;
        }
    }

    public static function isApp()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false
            || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false
            ||strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        ){
            return true;
        }else{
            return false;
        }
    }

    public static function url($url, Array $query_uri_arr=[])
    {
        $query_uri = '';
        if (!empty($query_uri_arr)) {
            $query_uri .= '?'.http_build_query($query_uri_arr);
        }
        if (strpos($_SERVER['REQUEST_URI'], '.php') !== false){
            $url = $_SERVER['SCRIPT_NAME'].'/'.$url.$query_uri;
        }else{
            $url = '/'.$url.$query_uri;
        }
        return $url;
    }
}