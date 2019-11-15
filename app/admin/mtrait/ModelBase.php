<?php

/**
 * User: lp
 * Date: 2019/11/15--14:33
 */
namespace app\admin\mtrait;

use framework\core\Config;
use framework\core\Validate;
use framework\core\Cache;

trait ModelBase
{
    /**
     * @param string $sql 默认选择主表的所有,sql是where之前的sql语句
     * @param bool|true $is_page 默认分页
     * @param array $other_arr 可以填 order,group
     * @return array
     */
    public function getAll($sql='', $is_page=true, $other_arr=[]){
        $where = 'where';
        $param = [];
        $order = 'order by id desc';
        $limit = '';
        foreach ($this->list_where_arr as $w_k=>$w) {
            if (is_numeric($w_k)) {
                if ($get = fget($w)) {
                    $where .= $w.' ='.' ? and ';
                    $param[] = $get;
                }
            }else{
                if ($get = fget($w_k)) {
                    $where .= $w_k.' '.$w.' ? and ';
                    if ($w == 'like') {
                        $param[] = '%'.$get.'%';
                    }else{
                        $param[] = $get;
                    }
                }
            }
        }
        if ($where == 'where') {
            $where = '';
        }else{
            $where = substr($where, 0, -4);
        }

        if ($is_page) {
            $page = (int)fget('page');
            $page = $page>0 ? $page :1;
            $page_size = Config::get('page')['page_size'];
            $page_num = ($page-1)*$page_size;
            $limit = 'limit '.$page_num.' , '.$page_size;
        }
        if (isset($other_arr['order'])) {
            $order = $other_arr['order'];
        }

        if (empty($sql)) {
            $select_sql = 'SELECT * FROM '.$this->main_table.' '.$where;
            $sql = $select_sql.' '. $order. ' '. $limit;
        }else{
            $select_sql = $sql .' ' .$where;
            $sql =  $select_sql .' '. $order .' '. $limit;
        }
//        var_dump($sql);
//        var_dump($param);
        Cache::tag('sql')->set($this->main_table.'_list_sql', $select_sql);
        return $this->db->fetch_all($sql, $param);
    }

    /**
     * 获取getall的总条数
     * @return mixed
     */
    public function getTotal()
    {
        $sql = Cache::tag('sql')->get($this->main_table.'_list_sql');
        $count_sql = preg_replace('/select\s.+\sfrom/i', 'SELECT COUNT('.$this->main_key.') total FROM', $sql);
//        var_dump($count_sql);
        return $this->db->fetch($count_sql)['total'];
    }

    /**
     * 获取一条数据
     * @param int $id
     * @param string $sql 默认选择主表所有, sql是where之前的sql
     * @return mixed
     */
    public function getOne($id=0, $sql='')
    {
        if (empty($sql)) {
            $sql = 'SELECT * FROM '.$this->main_table.' where '.$this->main_key.'='. $id;
        }else{
            $sql = $sql. ' where id='.$id;
        }
        return $this->db->fetch($sql);
    }

    //save保存数据
    public function save($data, $id=0,$addFun=null, $editFun=null)
    {
        if (empty($data)) {
            return false;
        }
        $data = $this->filter($data);//过滤非数据表字段
        if (empty($data)) {
            return false;
        }
        if (empty($id)) {
            $scene = 'add';
        }else{
            $scene = 'edit';
        }
        $validate = new Validate();
        $is_validate = $validate->rule($this->validate_rule[$scene])->check($data);//验证数据
        $callfun = $scene.'Fun';
        if (!is_null($$callfun)) {
            $data = $$callfun($data);
        }
        if ($is_validate) {
            if (empty($id)) {
                $res = Db::table($this->main_table)->add($data);
            }else{
                $res = Db::table($this->main_table)->where($this->main_key, $id)->update($data);
            }
        }else{
            return ['code'=>0, 'msg'=>$validate->getErrorMsg(), 'data'=>[]];
        }

        return $res;
    }

    //del删除数据
    public function delete($id)
    {
        $sql = "delete from {$this->main_table} where {$this->main_key} = {$id}";
        return $this->db->exec($sql);
    }

}