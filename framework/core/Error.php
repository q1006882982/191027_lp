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
        set_exception_handler([__CLASS__, 'appException']);
        set_error_handler([__CLASS__, 'appError']);
        register_shutdown_function([__CLASS__, 'appShutdown']);
    }

    public static function appException($e)
    {
        $code = $e->getCode();
        $msg = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        $time = date('Y-m-d H:i:s');
        $str = " time {$time} exception_handler: code {$code} 
         <br>错误信息:' {$msg}
         <br>错误位置: file {$file} on {$line} line";

        if (APP_DEBUG){
            echo $str;
        }else{

        }

//        $exception_type = '';
//        if (Request::isApp() === true){
//            $exception_type = 'app';
//        }elseif (Request::isAjax() === true){
//            $exception_type = 'ajax';
//        }elseif (APP_DEBUG === true){
//            $exception_type = 'pc_debug';
//        }else{
//            $exception_type = 'pc';
//        }
//
//        switch ($exception_type){
//            case 'app':
//                echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>[]]);
//                break;
//            case 'ajax':
//                echo json_encode(['code'=>$code, 'msg'=>$msg, 'data'=>[]]);
//                break;
//            case 'pc_debug':
//                echo $str;
//                break;
//            default:
//                break;
//        }
    }
    public static function appError($type, $message, $file, $line)
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
    public static function appShutdown()
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
 