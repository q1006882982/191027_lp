<?php
/**
 * User: lp
 * Date: 2019/10/28--13:40
 */
namespace framework\core;

class Db{
    private $pdo = null;
    private $table = '';
    private $field = '*';
    private $left_join = '';
    private $where = '';
    private $where_count = 0;
    private $where_param = [];
    private $group = '';
    private $order = '';
    private $limit = '';
    private $sql = [];
    private static $instance = [];
    /**
     * @return static
     */
    public static function getInstance($connect=[])
    {
        $key = isset($connect['key']) ? $connect['key'] : 'default';
        if (!isset(self::$instance[$key]) || !self::$instance[$key] instanceof self) {
            self::$instance[$key] = new self($connect);
        }
        return self::$instance[$key];
    }
    private function __construct($connect)
    {
        $config = App::getConfig();
        $database_arr = $config::get('database');
        try {
            if (empty($connect)) {
                $connect['db_dns'] = $database_arr['db_dns'];
                $connect['db_user'] = $database_arr['db_user'];
                $connect['db_pass'] = $database_arr['db_pass'];
                $connect['db_charset'] = $database_arr['db_charset'];
            }
            $this->pdo = new \PDO($connect['db_dns'], $connect['db_user'], $connect['db_pass'], array(\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.$connect['db_charset']));
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException  $e) {
            exit($e->getMessage());
        }
    }
    private function __clone(){}
    private function execute($sql, $param=[]) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($param);
        } catch (\PDOException  $e) {
            if(APP_DEBUG){
                throw new \Exception('SQL语句：'.$sql.'<br />错误信息：'.$e->getMessage());
            }
        }
        //初始化
        $this->table = '';
        $this->field = '*';
        $this->left_join = '';
        $this->where = '';
        $this->where_count = 0;
        $this->where_param = [];
        $this->group = '';
        $this->order = '';
        $this->limit = '';

        return $stmt;
    }
    public function fetch($sql, $param=[])
    {
        //原生 一次查询
        $stmt = $this->execute($sql, $param);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function fetch_all($sql, $param=[])
    {
        //原生 所有数据查询
        $stmt = $this->execute($sql, $param);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function exec($sql, $param=[])
    {
        //原生的 add,update,delte
        $stmt = $this->execute($sql, $param);
        return $stmt->rowCount();
    }
    /////////////////////////////////////////////////////////////////////
    public static function table($table, Array $connect=[])
    {
        $that = self::getInstance($connect);
        $that->table = $table;
        return $that;
    }
    public function field($field)
    {
        $this->field = $field;
        return $this;
    }
    public function left($left)
    {
        $this->left_join .= "LEFT JOIN {$left} ";
        return $this;
    }
    public function order($order)
    {
        $this->order = "ORDER BY {$order}";
        return $this;
    }
    public function limit($limit)
    {
        $this->limit = "LIMIT {$limit}";
        return $this;
    }

    /*
     * 1 直接写where, 只写第一个参数
     * 2 直接写where, 写两个参数(预处理). 第一个写where(绑定参数), 第二个写数组参数
     * 3 拆开写where, 第一个参数字段, 第二个值, 第三个符号 = > like,不可以写 in
     * */
    public function where($where, $where_val=[], $where_tag='=')
    {
        //一次写法,
        if (is_array($where_val)) {
            $this->where = "WHERE $where";
            $this->where_param = $where_val;
            return $this;
        }
        //分步写法
        if ($this->where_count == 0){
            $this->where .= "WHERE {$where} {$where_tag} ? ";
            $this->where_count++;
        }else{
            $this->where .= "AND {$where} {$where_tag} ? ";
        }

        $this->where_param[] = $where_val;
        return $this;
    }
    public function add(Array $add_data)
    {
        $add_fields = '';
        $add_temp = '';
        $add_values = [];
        foreach ($add_data as $key=>$item) {
            $add_fields .= $key. ',';
            $add_temp .= '?,';
            $add_values[] = $item;
        }
        $add_fields = substr($add_fields, 0, -1);
        $add_temp = substr($add_temp, 0, -1);
        $sql = "INSERT INTO {$this->table} ({$add_fields}) VALUES ({$add_temp})";
        $this->sql[]['key'] = $sql;
        $this->sql[]['val'] = $add_values;
        return $this->execute($sql, $add_values)->rowCount();
    }
    public function update(Array $update)
    {
        $add_fields = '';
        $add_values = [];
        foreach ($update as $key=>$item) {
            $add_fields .= $key.'=?,';
            $add_values[] = $item;
        }
        $add_fields = substr($add_fields, 0, -1);
        $con = array_merge($add_values, $this->where_param);
        $sql = "UPDATE {$this->table} SET {$add_fields} {$this->where}";
        $this->sql[]['key'] = $sql;
        $this->sql[]['val'] = $con;
        return $this->execute($sql, $con)->rowCount();
    }
    public function delete() {
        $sql = "DELETE FROM {$this->table} {$this->where}";
        $this->sql[] = ['sql'=>$sql, 'val'=>$this->where_param];
        return $this->execute($sql, $this->where_param)->rowCount();
    }
    public function select()
    {
        $sql = "SELECT {$this->field} FROM {$this->table} {$this->left_join} {$this->where} {$this->order} {$this->limit}";
        $this->sql[] = ['sql'=>$sql, 'val'=>$this->where_param];
        return $this->fetch_all($sql, $this->where_param);
    }
    public function find()
    {
        $sql = "SELECT {$this->field} FROM {$this->table} {$this->left_join} {$this->where} {$this->order} LIMIT 1";
        $this->sql[] = ['sql'=>$sql, 'val'=>$this->where_param];
        return $this->fetch($sql, $this->where_param);
    }

    /**
     *获取db的所有sql
     * @param array $contect
     * @return array
     */
    public static function get_sql($contect=[])
    {
        $that = self::getInstance($contect);
        $sql = $that->sql;
        return array_reverse($sql);
    }
}
