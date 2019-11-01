<?php
/**
 * User: lp
 * Time: 2019/11/1--15:01
 */


namespace framework\core\cache;

interface Drive
{
/*
 * 可以单独设置tag
 * 或者 单独设置tag
 * */

    public function tag($tag);
    public function set($key, $val, $exp_time, $tag);
    public function get($key, $tag);
    public function del($key, $tag);
    public function clear($tag);
    public function destroy();

}