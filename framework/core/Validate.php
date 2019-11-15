<?php
/**
 * User: lp
 * Time: 2019/10/27--14:00
 */
namespace framework\core;

/**
 * Class Validate
 * @package framework\core
 */
class Validate{
    private $data = [];
    private $active_field = '';
    private $error_msg = '';

    protected $default_msg = [
        'require'=>'不得为空'
        ,'unique'=>'已经存在'
        ,'string'=>'不是字符串'
        ,'int'=>'不是整数'
        ,'num'=>'不是数字'
        ,'float'=>'不是小数'
        ,'bool'=>'不是布尔类型'
        ,'array'=>'不是数组'
        ,'length'=>'长度不对'
        ,'max'=>'大于长度最大值'
        ,'min'=>'小于长度最小值'
        ,'confirm'=>'与匹配项不同'
        ,'reg'=>'正则匹配不对'
        ,'email'=>'不是合法的邮箱'
        ,'phone'=>'不是合法的手机号'
        ,'url'=>'不是合法的url'
    ];

    protected $rule = [];

    protected $scene = [
//        'add'=>[
//            'name|姓名'=>'require|unique:manage'
//            ,'age|年龄'=>'require|int|confirm:name'
//        ]
//        ,'update'=>[
//            'name|姓名'=>'require|unique:manage'
//            ,'age|年龄'=>'require|int'
//        ]
    ];

    public function rule(Array $rule_arr){
        $this->rule = $rule_arr;
        return $this;
    }

    public function scene($scene_name)
    {
        $this->rule = isset($this->scene[$scene_name]) ? $this->scene[$scene_name] : [];
        return $this;
    }

    public function check($data){
        //不存在规则,直接返回true
        if (empty($this->rule)) {
            return true;
        }
        $this->data = $data;
        //message
        if (isset($this->msg)) {
            $msg_arr = array_merge($this->default_msg, $this->msg);
        }else{
            $msg_arr = $this->default_msg;
        }
        //分析规则
        foreach ($this->rule as $rule_key=>$rule_val) {
            $rule_key_arr = explode('|', $rule_key);
            //字段名
            $this->active_field = $rule_field = $rule_key_arr[0];
            $rule_name = isset($rule_key_arr[1]) ? $rule_key_arr[1] : $rule_field;
            if (!isset($data[$rule_field])) {
                $this->error_msg = '键值:'.$rule_field.'不存在';
                return false;
            }
            $val = $data[$rule_field];
            $check_rule_arr = explode('|', $rule_val);
            foreach ($check_rule_arr as $rule) {
                if (strpos($rule, ':')) {
                    $fun_arr = explode(':', $rule);
                    $rule = $fun_arr[0];
                    $fun_name = 'check'.ucfirst($rule);
                    array_shift($fun_arr);
                    array_unshift($fun_arr, $val);
                }else{
                    $fun_name = 'check'.ucfirst($rule);
                    $fun_arr = [$val];
                }

                //$rule规则名
                $fun_res = call_user_func_array([$this, $fun_name], $fun_arr);
                if (!$fun_res) {
                    $msg = isset($msg_arr[$rule_field.'.'.$rule]) ? $rule_name . $msg_arr[$rule_field.'.'.$rule] : $rule_name . $msg_arr[$rule];
                    $this->error_msg = $msg;
                    return false;
                }
            }
        }

        return true;
    }

    public function getErrorMsg()
    {
        return $this->error_msg;
    }

    //为空
    protected function checkRequire($v){
        if (empty($v)) {
            return false;
        }
        return true;
    }

    //int
    protected function checkInt($checkData){
        return is_int($checkData);
    }

    //number
    protected function checkNum($checkData){
        return is_numeric($checkData);
    }

    //string
    protected function checkString($checkData){
        return is_string($checkData);
    }

    //float
    protected function checkFloat($checkData){
        return is_float($checkData);
    }

    //boolean
    protected function checkBool($checkData){
        return is_bool($checkData);
    }

    //array
    protected function checkArray($checkData){
        return is_array($checkData);
    }

    //in:1,2,1
    protected function checkIn(...$param){
        $v = $param[0];
        array_shift($param);
        return in_array($v, $param);
    }

    //length:2,10
    protected function checkLength($v, $min, $max){
        $length = mb_strlen($v);
        if ($length>=$min && $length<=$max) {
            return true;
        }else{
            return false;
        }
    }

    //max:10
    protected function checkMax($v, $max){
        $length = mb_strlen($v);
        if ($length <= $max) {
            return true;
        }else{
            return false;
        }
    }

    //min:2
    protected function checkMin($v, $min){
        $length = mb_strlen($v);
        if ($length >= $min) {
            return true;
        }else{
            return false;
        }
    }

    //confirm
    protected function checkConfirm($v, $cfield){
        if ($v == $this->data[$cfield]) {
            return true;
        }else{
            return false;
        }
    }

    //字段唯一性
    protected function checkUnique($v, $full_table, $mode=0){
        //表中 field 是否 存在
        $db = App::getDb();
        $table_main_key = $db->getMainKey();
        if ($mode == 0) {
            $sql = 'select '.$table_main_key.' from '.$full_table.' where '.$this->active_field.'="'.$v.'"';
        }else{
            $sql = 'select '.$table_main_key.' from '.$full_table.' where '.$this->active_field.'="'.$v.'" and '.$table_main_key.'<>"'.$this->data[$table_main_key].'"';
        }
//        var_dump($sql);
        $res = $db->fetch($sql);
        if ($res === false) {
            return true;
        }else{
            return false;
        }

    }

    //date

    //ip

    //正则
    public function checkReg($checkData, $checkRule){
        return preg_match('/^'.$checkRule.'$/', $checkData);
    }

    //email
    protected function checkEmail($checkData){
        return preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $checkData);
    }

    //phone
    protected function checkPhone($checkData){
        return preg_match('/^13[0-9]{9}$|14[0-9]{9}$|15[0-9]{9}$|18[0-9]{9}$|17[0-9]{9}$/', $checkData);
    }

    //url
    protected function checkUrl($checkData){
        return preg_match('/^(\w+:\/\/)?\w+(\.\w+)+.*$/', $checkData);
    }
}
 