<?php
/**
 * User: lp
 * Time: 2019/10/27--14:00
 */
namespace framework\core;
/*
 *
 * */
class Config{
    public static $map = [];

    public static function get($file='config', $key='')
    {
        if (isset(self::$map[$file]) && !is_null(self::$map[$file])){
            return self::$map[$file][$key];
        }

        $file_path = CONFIG_PATH.$file.'.php';
        if (is_file($file_path)){
            $config_arr = include $file_path;
            self::$map[$file] = $config_arr;
            if (empty($key)){
                $res = $config_arr;
            }else{
                $res = $config_arr[$key];
            }
        }else{
            return null;
        }

        return $res;
    }
}
 