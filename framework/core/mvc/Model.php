<?php
/**
 * User: lp
 * Time: 2019/10/27--17:23
 */
namespace framework\core\mvc;

use framework\core\Db;

class Model
{
    /**
     * @var Db
     */
    protected $db = null;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function lst()
    {
        $res = $this->db::table($this->main_table)->select();
        return $res;
    }

}