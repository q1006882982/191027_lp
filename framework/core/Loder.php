<?php
/**
 * User: lp
 * Time: 2019/10/27--10:24
 */
namespace framework\core;
class Loder{
    public static function init()
    {
        spl_autoload_register([__CLASS__, 'auto']);
    }

    public static function auto($class_name)
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
            $file_path = LIB_PATH.$path_str.'.php';
            if (is_file($file_path)){
                include $file_path;
            }
        }
    }

    public static function import($path){
//        include $path;
    }
}
 