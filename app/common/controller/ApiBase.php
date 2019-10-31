<?php
/**
 * User: lp
 * Time: 2019/10/30--17:17
 */
namespace app\common\controller;

use framework\core\mvc\Controller;

class ApiBase extends Controller {
    public function __construct()
    {
        parent::__construct();

        //获取ip
        //ip在白名单
        header('Access-Control-Allow-Origin:*');
    }
}
 