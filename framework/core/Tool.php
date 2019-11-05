<?php
/**
 * User: lp
 * Time: 2019/10/27--14:46
 */
namespace framework\core;

class Tool{
    /**
     * @param string $data
     * @param string $default
     * @return string
     */
    public static function inputCheck($data, $default='')
    {
        $pattern = '/^[0-9a-zA-Z]+$/i';
        if(preg_match($pattern, $data)){
            return $data;
        }else{
            return $default;
        }
    }

    public static function getIp()
    {
        $ip='';
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $ip= $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip= $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $ip= $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $ip= getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $ip= getenv("HTTP_CLIENT_IP");
            } else {
                $ip= getenv("REMOTE_ADDR");
            }
        }

        return $ip;
    }
}
 