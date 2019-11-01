<?php
/**
 * User: lp
 * Time: 2019/10/27--17:23
 */
namespace framework\core\mvc;
use framework\core\mtrait\Container_common;


class Controller{
    /**
     * trait container
     */
    use Container_common;

    protected $module = '';
    protected $controller = '';
    protected $method = '';
    /**
     * @var Model
     */
    protected $model = null;
    protected $view_param = [];

    public function __construct()
    {
        $request = $this->getRequest();
        $module = $request::getMoudle();
        $fc = $request::getController();
        $method = $request::getMethod();
        $this->module = $module;
        $this->controller = $fc;
        $this->method = $method;

        //this->model
        $model_path = APP_PATH.$module.DS.'model'.DS.$fc.'.php';
        if (is_file($model_path)){
            $model_name = 'app\\'.$module.'\\model\\'.$fc;
            $this->model = new $model_name();
        }
    }

    /**
     * 模版变量注入
     * @param $key
     * @param $val
     */
    protected function assign($key, $val){
        $this->view_param[$key] = $val;
    }
    /**
     * 只需要传入文件名, 例如 index_index
     * 其余路径在config中配置
     * @param $path
     */
    protected function display($path=''){
        $config = $this->getConfig();
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
 