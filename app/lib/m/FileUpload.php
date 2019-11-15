<?php
namespace m;
//上传文件类
use framework\core\Config;

class FileUpload {
    private $error;			    //file错误代码
    private $name;			    //file文件名
    private $tmp;				//file临时文件
    private $type;				//file类型

    private $error_msg = '';		//错误信息
    private $maxsize = 0;		    //表单最大值
    private $allow_type = [];	//类型合集
    private $allow_suffix = [];	//后缀合集
    private $suffix = '';		//后缀合集
    private $path = '';			//目录路径
    private $today_path = '';		//今天目录

    //构造方法，初始化
    /**
     * FileUpload constructor.
     * $info string type    img/file
     * $info string name    必填;;$_FILE的name名称
     * $info int max_size   允许的最大上传尺寸
     * $info array allow_suffix  允许的后缀
     * $info array allow_type   允许的文件类型
     * @param array $info
     */
    public function __construct(Array $info=[]) {
        $file_type = isset($info['type']) ? $info['type'] : 'img';
        $config = Config::get('upload')[$file_type];
        $_file = $info['name'];

        $this->maxsize = isset($info['max_size']) ? $info['max_size']/1024 : $config['max_size']/1024;
        $this->allow_type = isset($info['allow_type']) ? $info['allow_type'] : $config['allow_type'];
        $this->allow_suffix = isset($info['allow_suffix']) ? $info['allow_suffix'] : $config['allow_suffix'];

        $this->error = $_FILES[$_file]['error'];
        $this->type = $_FILES[$_file]['type'];
        $this->name = $_FILES[$_file]['name'];
        $this->tmp = $_FILES[$_file]['tmp_name'];

        $this->path = PUBLIC_PATH.str_replace('/', DS, $config['path']);
        $this->today_path = $this->path.date('Ymd').'/';
        $this->today_link_path = '/'.$config['path'].date('Ymd').'/';

        //验证error_code, type, suffix
        if ($this->check() === false) {
            return false;
        }

        return true;
    }
    //check
    private function check()
    {
        //验证错误码
        if ($this->error !== 0) {
            switch ($this->error) {
                case 1 :
                    $this->error_msg = '警告：上传值超过了约定最大值！';
                    break;
                case 2 :
                    $this->error_msg = '警告：上传值超过了'.$this->maxsize.'KB！！';
                    break;
                case 3 :
                    $this->error_msg = '警告：只有部分文件被上传！';
                    break;
                case 4 :
                    $this->error_msg = '警告：没有任何文件被上传！';
                    break;
                default:
                    $this->error_msg = '警告：未知错误！';
            }
            return false;
        }
        //验证类型
        if (!in_array($this->type,$this->allow_type)) {
            $this->error_msg = '警告：不合法的上传类型！';
            return false;
        }
        //验证后缀
        $tmp_name_arr = explode('.', $this->name);
        $suffix = $tmp_name_arr[count($tmp_name_arr)-1];
        $this->suffix = $suffix;
        if (!in_array($suffix, $this->allow_suffix)) {
            $this->error_msg = '警告：不合法的上传类型！';
            return false;
        }

        return true;
    }

    /**
     * 文件上传
     * 失败返回false, 成功返回 前台用的路径
     */
    public function upload()
    {
        //验证路径是否可操作
        if ($this->checkPath() === false) {
            return false;
        }
        //上传
        if (is_uploaded_file($this->tmp)) {
            $upload_path = md5($this->name.time()).'.'.$this->suffix;
            if (!move_uploaded_file($this->tmp, $this->today_path.$upload_path)) {
                $this->error_msg = '警告：上传失败！';
                return false;
            }
        } else {
            $this->error_msg = '警告：临时文件不存在！';
            return false;
        }

        return $this->today_link_path.$upload_path;
    }
    //验证目录是否可写
    private function checkPath() {
        if (!is_dir($this->path) || !is_writeable($this->path)) {
            //设置只读权限
            if (!mkdir($this->path, 0555, true)) {
                $this->error_msg = '警告：主目录创建失败！';
                return false;
            }
        }
        if (!is_dir($this->today_path) || !is_writeable($this->today_path)) {
            if (!mkdir($this->today_path)) {
                $this->error_msg = '警告：子目录创建失败！';
                return false;
            }
        }
        return true;
    }

    //返回错误信息
    public function getError()
    {
        return $this->error_msg;
    }

}
