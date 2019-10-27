<?php
/**
 * User: lp
 * Time: 2019/10/27--20:05
 */
namespace app\admin\model;

use framework\core\mvc\Model;

class Index extends Model
{
    public function all()
    {
        return $this->table('user')->select();
    }
}
 