<?php
/**
 * User: lp
 * Time: 2019/10/27--20:05
 */
namespace app\admin\model;

use framework\core\mvc\Model;

class TestModel extends Model
{
    //list_where
    protected $list_where_arr  = [
        'name'
    ];

    //check_rule
    protected $validate_rule = [
        'add'=>[
            'name'=>'length:2:10'
        ]
        ,'edit'=>[
            'name'=>'length:2:10'
        ]
    ];

    public function getAll($sql='', $is_page=true, $other_arr=[])
    {
        $sql = "";
        return parent::getAll($sql, $is_page, $other_arr);
    }

    public function save($data, $id=0, $add=null, $edit=null)
    {
        $add = function ($data){
            return $data;
        };
        $edit = function ($data){
            return $data;
        };
        return parent::save($data, $id, $add, $edit);
    }





}
 