<?php
/**
 * User: lp
 * Time: 2019/10/30--15:28
 */
namespace app\admin\controller;

class Api{
    public function apiReturn($is, $data=[], $msg='succ|err', $code=1)
    {
        $msg_arr = explode('|', $msg);
        $msg = $msg_arr[0];
        if (empty($is)){
            $code = 0;
            $msg = $msg_arr[1];
        }
        $res = [];
        $res['data'] = $data;
        $res['msg'] = $msg;
        $res['code'] = $code;
        echo json_encode($res);
    }

    public function info()
    {
        $is = 1;
        $data = [
            'name'=>'lp'
            ,'age'=>11
        ];
        $this->apiReturn($is, $data);
    }
}
 