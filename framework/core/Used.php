<?php
/**
 * User: lp
 * Time: 2019/11/4--14:07
 */


namespace framework\core;


class Used
{
    public function testagent(){
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone')||strpos($_SERVER['HTTP_USER_AGENT'], 'iPad')){
            echo 'systerm is IOS';
        }else if(strpos($_SERVER['HTTP_USER_AGENT'], 'Android')){
            echo 'systerm is Android';
        }else{
            echo 'systerm is other';
        }
    }
}