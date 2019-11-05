<?php
/**
 * User: lp
 * Time: 2019/10/27--17:23
 */
namespace framework\core\mvc;
use framework\core\mtrait\Container_common;


class Controller{
    /**
     * 注册 config, request, cache等
     * trait container
     */
    use Container_common;

    protected $module = '';
    protected $controller = '';
    protected $method = '';

    protected $model = null;
    protected $view_param = [];

    public function __construct()
    {
        /**
         * @var $request \framework\core\Request
         */
        $request = $this->request;
        $module = $request::getMoudle();
        $fc = $request::getController();
        $method = $request::getMethod();
        $this->module = $module;
        $this->controller = $fc;
        $this->method = $method;

        //注册 model
        $model_path = APP_PATH.$module.DS.'model'.DS.$fc.'.php';
        if (is_file($model_path)){
            $model_name = 'app\\'.$module.'\\model\\'.$fc;
            $this->model = new $model_name();
        }
    }

    /**
     * 生成url
     * @param string $url 例如/index/index/index
     * @return string
     */
    protected function url($url)
    {
        /**
         * @var $request \framework\core\Request
         */
        $request = $this->request;
        return $request::url($url);
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
        /**
         * @var $config \framework\core\Config
         */
        $config = $this->config;
        $path = empty($path) ? $this->controller . '_' . $this->method : $path;
        $template_config = $config::get('template');
        $view_suffix = $template_config['suffix'];
        $view_pre_path = $template_config[$this->module];
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
}
 