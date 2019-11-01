<?php
/**
 * User: lp
 * Time: 2019/10/27--15:28
 */
namespace app\admin\controller;

use framework\core\Cache;
use framework\core\mvc\Controller;

class Index extends Controller
{
    public function index()
    {
        echo 'index';
    }

    public function b()
    {
        $a = $this->request::fget('a');
        dump($a);
//        phpinfo();
    }
}
 