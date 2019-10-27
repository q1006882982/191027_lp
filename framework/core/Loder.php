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

        array_shift($name_arr);
        $path_str = '';
        foreach ($name_arr as $item) {
            $path_str .= $item.DS;
        }
        $path_str = substr($path_str, 0, -1);

        if ($name_pre == 'framework'){
            $file_path = FRAME_PATH.$path_str.'.php';
            if (is_file($file_path)){
                include $file_path;
            }else{
                throw new \Exception('文件不存在: '.$file_path);
            }
        }elseif($name_pre == 'app'){
            $file_path = APP_PATH.$path_str.'.php';
            if (is_file($file_path)){
                include $file_path;
            }else{
                throw new \Exception('文件不存在: '.$file_path);
            }
        }
    }
}
 