<?php
/**
 * User: lp
 * Time: 2019/10/27--15:28
 */
namespace app\admin\controller;

use framework\core\mvc\Controller;
use framework\core\mvc\Model;

class Index extends Controller
{
    public function index()
    {
        $res = $this->model->all();
        dump($res);
        exit;


        $model = Model::getInstance();
//        $res = $model->table('user')
//            ->add(['name'=>'lp4']);
//        $res = $model->table('user')
//            ->where('id=', 2)
//            ->update(['name'=>'lp21']);
//        $res = $model->table('user')
//            ->where('id=', 2)
//            ->where('name=', 'lp')
//            ->delete();
//        dump($res);
//        $res = $model->table('user')
//            ->where('id=', 1)
//            ->delete();
//        dump($res);
        $res = $model->table('user')
            ->where('id=', 3)
            ->find();
        dump($res);
        dump($model->get_sql());

//        $sql = "insert into user (name) values ('lp3')";
//        $sql_param = [];
//        $res = $model->exec($sql, $sql_param);
//        dump($res);
    }
}
 