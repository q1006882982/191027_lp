<?php
/**
 * User: lp
 * Time: 2019/11/1--15:00
 */
namespace framework\core\cache;
use m\Tool;

class File implements Drive{
    private $tag = 'lp';
    private $base_path = RUN_PATH.'cache'.DS;

    //dir_path 例子 /a/b/c
    public function delDir($dir_path)
    {
        $dir_arr = glob($dir_path.DS.'*');
        if (empty($dir_arr)){
            return false;
        }
        foreach ($dir_arr as $item) {
            unlink($item);
        }
        rmdir($dir_path);
        return true;
    }

    public function tag($tag)
    {
        $this->tag = $tag;
        return $this;
    }

    public function set($key, $val, $exp_time=0, $tag='')
    {
        //不存在,创建文件夹
        //创建文件,写入数
        $is_dir = is_dir($this->base_path);
        if (!$is_dir){
            mkdir($this->base_path, 0777, true);
        }

        $tag = $tag ? $tag : $this->tag;
        $tag_dir = $this->base_path.$tag;
        $is_dir = is_dir($tag_dir);
        if (!$is_dir){
            mkdir($tag_dir, 0777);
        }
        $time = 0;
        if ($exp_time){
            $time = time() + $exp_time;
        }
        $val = <<<EOT
<?php
return [
    'time'=>{$time}
    ,'val'=>'{$val}'
];
EOT;

        file_put_contents($tag_dir.DS.$key.'.php', $val);
    }

    public function get($key, $tag='')
    {
        //检查文件是否存在
        //存在 返回 val
        $tag = $tag ? $tag : $this->tag;
        $file_path = $this->base_path.$this->tag.DS.$key.'.php';
        $is_file = file_exists($file_path);
        if (!$is_file){
            return false;
        }
        $val_arr = include $file_path;
        return $val_arr['val'];
    }

    public function del($key, $tag='')
    {
        //删除文件
        $tag = $tag ? $tag : $this->tag;
        $file_path = $this->base_path.$this->tag.DS.$key.'.php';
        $is_file = file_exists($file_path);
        if (!$is_file){
            return false;
        }
        $is_succ = unlink($file_path);
        return $is_succ;
    }

    public function clear($tag='')
    {
        //删除目录
        $tag = $tag ? $tag : $this->tag;
        $dir_path = $this->base_path.$this->tag;
        $is_dir = is_dir($dir_path);
        if (!$is_dir){
            return false;
        }

        $is_succ = $this->delDir($dir_path);
        return $is_succ;
    }

    //暂时未实现
    public function destroy()
    {
        //删除cache
        $dir_path = substr($this->base_path, 0, -1);
        dump($dir_path);
        $is_succ = $this->delDir($dir_path);
        return $is_succ;
    }


}