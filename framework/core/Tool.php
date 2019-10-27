<?php
/**
 * User: lp
 * Time: 2019/10/27--14:46
 */
namespace framework\core;

class Tool{
    public static function input_check($data, $default='')
    {
        $pattern = '/^[a-zA-Z]+$/i';
        if(preg_match($pattern, $data)){
            return $data;
        }else{
            return $default;
        }
    }
}
 