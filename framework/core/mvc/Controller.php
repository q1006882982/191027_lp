<?php
/**
 * User: lp
 * Time: 2019/10/27--17:23
 */
namespace framework\core\mvc;
//use framework\core\mtrait\Container_common;


use framework\core\Config;
use framework\core\Request;

class Controller{
    /**
     * 注册 config, request, cache等
     * trait container
     */
//    use Container_common;

    protected $view_param = [];

    public function __construct()
    {

    }

    /**
     * 生成url
     * @param string $url 例如/index/index/index
     * @return string
     */
    protected function url($url, $param=[])
    {
        return Request::url($url, $param);
    }

    /**
     * 跳转
     * @param string $url 例如/index/index/index
     */
    protected function redirect($url)
    {
        header('Location:' . $this->url($url));
    }

    /**
     * 模版变量注入
     * @param string $key
     * @param mixed $val
     */
    protected function assign($key, $val){
        $this->view_param[$key] = $val;
    }

    /**
     * @param string $path 例如 index_index, 如果空查找 控制器_方法名
     */
    protected function display($path=''){
        $path = empty($path) ? CO_NAME . '_' . ME_NAME : $path;
        $template_config = Config::get('template');
        $view_suffix = $template_config['suffix'];
        $view_pre_path = $template_config[MO_NAME];
        $view_path = $view_pre_path.DS.$path.'.'.$view_suffix;
        if (is_file($view_path)) {
            foreach ($this->view_param as $key=>$item) {
                $$key = $item;
            }
            include $view_path;
        }else{
            throw new \Exception('模板文件不存在: ' . $view_path);
        }
    }

    protected function apiReturn($is, $data=[], $msg='succ|err', $code=1)
    {
        if (is_array($is)) {
            echo json_encode($is);
            return;
        }
        $msg_arr = explode('|', $msg);
        $msg = $msg_arr[0];
        if (empty($is)){
            $code = 0;
            $msg = $msg_arr[1];
        }
        $res = [];
        $res['data'] = $data;
        $res['msg'] = $msg;
        $res['code'] = $code;
        echo json_encode($res);
    }
}
 