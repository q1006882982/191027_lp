<?php
/**
 * User: lp
 * Time: 2019/10/27--11:34
 */
namespace framework\core;

class Error{
    public static function init()
    {
        error_reporting(E_ALL);
        set_exception_handler([__CLASS__, 'app_exception']);
        set_error_handler([__CLASS__, 'app_error']);
        register_shutdown_function([__CLASS__, 'app_shutdown']);
    }

    public static function app_exception($e)
    {
        $time = date('Y-m-d H:i:s');
        $str = " time {$time} exception_handler: code {$e->getCode()} 
         <br>错误信息:' {$e->getMessage()}
         <br>错误位置: file {$e->getFile()} on {$e->getLine()} line";
        if (APP_DEBUG){
            echo $str;
        }
    }
    public static function app_error($type, $message, $file, $line)
    {
        $time = date('Y-m-d H:i:s');
        $str = "{$time} set_error_handler
        <br>错误信息: {$message}
        <br>错误位置: in {$file} on {$line} line <br>";
        if (APP_DEBUG) {
            echo $str;
        } else {
            //log
        }
    }
    public static function app_shutdown()
    {
        if ($error = error_get_last()) {
            $time = date('Y-m-d H:i:s');
            $str = "\n " . $time . ' register_shutdown_function: Type:' . $error['type'] . ' Msg: ' . $error['message'] . ' in ' . $error['file'] . ' on line ' . $error['line'];
            if (APP_DEBUG) {
                echo $str;
            } else {
               //log
            }
        }
    }

}
 