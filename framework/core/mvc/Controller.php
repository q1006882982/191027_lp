<?php
/**
 * User: lp
 * Time: 2019/10/27--17:23
 */
namespace framework\core\mvc;
use framework\core\App;

class Controller{
    protected $model = null;

    public function __construct()
    {
        $request = App::get_request();
        $module = $request::getMoudle();
        $fc = $request::getController();
        //this->model
        $model_path = APP_PATH.$module.DS.'model'.DS.$fc.'.php';
        if (is_file($model_path)){
            $model_name = 'app\\'.$module.'\\model\\'.$fc;
//            $this->model = new $model_name();
            $this->model = $model_name::getInstance();
        }
    }
}
 