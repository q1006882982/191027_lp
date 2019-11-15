<?php
/**
 * User: lp
 * Time: 2019/11/5--10:31
 */
namespace app\admin\controller;

use framework\core\Cache;
use framework\core\Db;
use framework\core\mvc\Controller;
use framework\core\Config;

class Base extends Controller
{
    public $main_table = '';

    public function __construct()
    {
        //验证登录

        //验证权限
        $level_id = 1;
        $menu_ids = Cache::tag('perm')->get('menu_ids_'.$level_id);
        if (is_null($menu_ids)) {
            $level_info = Db::table('level')->field('menu_ids')->where('id', $level_id)->find();
            $menu_ids = $level_info['menu_ids'];
            //cache menu_ids
            Cache::tag('perm')->set('menu_ids_'.$level_id, $menu_ids);
            if ($menu_ids != 'all') {
                if (empty($menu_ids)) {
                    e10('没有权限');
                }
                $menu_info = Db::table('menu')->field('url')
                    ->where('id in ('.$menu_ids.')')
                    ->select();
                $allow_url = array_column($menu_info, 'url');
                //cache allow_url
                Cache::tag('perm')->set('allow_url_'.$level_id, $allow_url);
            }
        }
        if ($menu_ids != 'all') {
            if (empty($menu_ids)) {
                e10('没有权限');
            }
            $allow_url = Cache::tag('perm')->get('allow_url_'.$level_id);
            $now_url = MO_NAME.'/'.CO_NAME.'/'.ME_NAME;
            if (!in_array($now_url, $allow_url)) {
                e10('没有权限');
            }
        }
    }

    public function show()
    {
        $all_data = model($this->main_table)->getAll();
        $this->assign('all_data', $all_data);
        $this->display();
    }

    public function form()
    {
        $id = (int)fget('id');
        if ($id>0){
            $one_data = model($this->main_table)->getOne($id);
            $this->assign('one_data', $one_data);
        }
        $this->display();
    }

    public function save()
    {
        $data = fpost();
        $id = isset($data['id']) ? $data['id'] : 0;
        $res = model($this->main_table)->save($data, $id);
        $this->apiReturn($res);
    }

    public function delete()
    {
        $id = (int)fpost('id');
        $res = model($this->main_table)->delete($id);
        $this->apiReturn($res);
    }

    public function apiShowCount()
    {
        $page_size = Config::get('page')['page_size'];
        $total = model($this->main_table)->getTotal();
        $this->apiReturn(1, ['total'=>$total, 'page_size'=>$page_size]);
    }
}