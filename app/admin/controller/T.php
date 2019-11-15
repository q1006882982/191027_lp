<?php
/**
 * User: lp
 * Time: 2019/11/5--17:29
 */


namespace app\admin\controller;


use framework\core\App;
use framework\core\Cache;
use framework\core\Db;
use framework\core\mvc\Controller;
use framework\core\Request;
use framework\core\Validate;
use m\DataBase;

class T extends Base
{

    /**
     * add,edit     int 0, int 1
     * fetch_all    [], array(二维)
     * fetch        false, array
     */

    /*
     * 写一个权限处理
     * 1 后台
     *      manage, level, menu
     * manage有level_id, level有menu_id
     * 2 前台
     *
     * */

    public function t1()
    {
        echo 't1';
    }

    public function t2()
    {
        echo 't2';
    }

    public function t3()
    {
        echo 't3';
        Cache::tag('t')->set('a', 'a');
        $a = Cache::tag('t')->get('a');
        var_dump($a);
    }

    public function t4()
    {
        //获取文件夹下所有类及类的方法
        //核心 数据表添加 url=admin/类名/方法名

        //获取controller下的所有文件,取到类名
        $ctrl_path = APP_PATH.'admin'.DS.'controller'.DS;
        $file_arr = glob($ctrl_path.'*.php');
        $class_arr = [];
        foreach ($file_arr as $file_str) {
            $po_left = strrpos($file_str, DS);
            $class_arr[] = substr($file_str, $po_left+1, -4);
        }
        var_dump($class_arr);
        //通过反射获取类的方法
        $url_arr = [];
        foreach ($class_arr as $class) {
            $class_name = 'app\admin\controller\\'.$class;
            $nclass = new \ReflectionClass($class_name);
            $methodo_arr = $nclass->getMethods(\ReflectionMethod::IS_PUBLIC);
            foreach ($methodo_arr as $methodo) {
                //开头找不到_
                if (strpos($methodo->name, '_') !== 0) {
                    $url_arr[] = 'admin/'.$class.'/'.$methodo->name;
                }
            }
        }
        dump($url_arr);
        //循环数组插入数据库
        foreach ($url_arr as $url) {
            Db::table('menu')->add(['url'=>$url]);
        }


    }

    public function t5()
    {
        $db = Db::getInstance();

        $sql = "select * from test where id=100";
        $res = $db->fetch_all($sql);
        var_dump($res);
        exit;

        $sql = "SHOW TABLES FROM lp";
        $res = $db->fetch_all($sql);
        var_dump($res);

        $sql = "show create table manage";
        $res = $db->fetch($sql);
        echo ($res['Create Table']);
//        $data_base = new DataBase();
//        $data_base->backupMySqlData('localhost', 'root', 'root', 'lp');
    }

    public function t6()
    {
                $data_base = new DataBase();
        $data_base->backupMySqlData('localhost', 'root', 'root', 'lp');
    }



}