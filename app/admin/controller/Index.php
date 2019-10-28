<?php
/**
 * User: lp
 * Time: 2019/10/27--15:28
 */
namespace app\admin\controller;

use framework\core\Db;
use framework\core\mvc\Controller;
use framework\core\mvc\Model;

class Index extends Controller
{
    public function index()
    {
        echo 'hi';
        $res = Db::table('user')->select();
        $this->assign('res', $res);
        $this->display();
    }
}
 