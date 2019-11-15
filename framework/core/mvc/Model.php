<?php
/**
 * User: lp
 * Time: 2019/10/27--17:23
 */
namespace framework\core\mvc;

use framework\core\Db;
use framework\core\Cache;


class Model
{
    /**
     * @var \framework\core\Db;
     */
    protected $db = null;
    protected $main_table = '';
    protected $main_key = 'id';

    protected $list_where_arr = [];//用于getall的筛选
    protected $validate_rule = [ //用于save的验证
        'add'=>[]
        ,'edit'=>[]
    ];

    public function __construct($table_name=''){
        $this->db = Db::getInstance();
        if ($table_name == '') {
            $tmp_str = get_class($this);
            $tmp_arr = explode('\\', $tmp_str);
            $this->main_table = substr($tmp_arr[count($tmp_arr)-1], 0, -5);
        }
        $this->main_table = $table_name;
    }

    //过滤掉非本表的键值
    public function filter($data)
    {
        $sql = 'show columns from '.$this->main_table;
        $field_info = $this->db->fetch_all($sql);
        $field_arr = array_column($field_info, 'Field');
        foreach ($data as $key=>$item) {
            if (!in_array($key, $field_arr)) {
                unset($data[$key]);
            }
        }
        return $data;
    }

}