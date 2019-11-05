<?php
/**
 * User: lp
 * Time: 2019/10/27--15:28
 */
namespace app\admin\controller;


class Index extends Base
{
    public function index()
    {
        $this->display();
    }

    public function welcome()
    {
        echo 'welcome';
    }

    public function t()
    {
        /**
         * @var $config \framework\core\Config
         */
        $config = $this->config;
        dump($config::get('routing'));
    }


}
 