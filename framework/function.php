<?php
/**
 * User: lp
 * Time: 2019/10/27--11:30
 */
function dump($val){
    echo '<pre>';
    var_dump($val);
    echo '</pre>';
}

/**
 * 主要用来 扔一个已知的错误
 * 因为关闭debug的情况下,通常的异常时不显示明确信息的,code=10显示明确信息
 *
 * @param string $msg
 * @param int $code
 * @throws Exception
 */
function e10($msg='', $code=10){
    throw new \Exception($msg, $code);
}

function finput($arr, $key='', $default=null){
    if (empty($key)) {
        return $arr;
    }
    if (isset($arr[$key])) {
        return $arr[$key];
    }else{
        return $default;
    }
}
//get安全过滤
function fget($key='', $default=null){
    $_GET = str_replace(array('<','>', '"', "'"),array('&lt;','&gt;', '&quot;', ''), $_GET);
    return finput($_GET, $key, $default);
}
//post安全过滤
function fpost($key='', $default=null){
    $_POST = str_replace(array('<','>', '"', "'"),array('&lt;','&gt;', '&quot;', ''), $_POST);
    return finput($_POST, $key, $default);
}
//file
function ffile(){
    
}

//生成url
function url($url, Array $query_uri_arr=[]){
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

//获取model
/**
 * @param $name
 * @param string $layer
 * @return object
 */
function model($name, $layer=''){
    static $model_arr;
    if ($layer == '') {
        $layer = 'admin';
    }
    $key_name = $layer.$name;
    if ($model_arr[$key_name] == null) {
        $model_name = 'app\\'.$layer.'\model\\'.ucfirst($name).'Model';
        $model = (new ReflectionClass($model_name))->newInstance($name);
        $model_arr[$key_name] = $model;
    }
    return $model_arr[$key_name];
}
















