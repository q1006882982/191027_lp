<?php
/**
 * User: lp
 * Date: 2019/11/15--15:01
 */
namespace m;

/**
 * imagecreatefrompng — 由文件或 URL 创建一个新图象
 * imagestring 水平地画一行字符串
 * Class ValidateCode
 * @package m
 */
class ValidateCode {
    private $charset = 'ABCDEFGHKMNPRSTUVWXYZ23456789';	//随机因子
    private $code = '';							        //验证码
    private $codelen = 4;					            //验证码长度
    private $width = 145;					            //宽度
    private $height = 20;					            //高度
    private $img = null;								//图形资源句柄
    private $fontcolor = 0;						        //指定字体颜色

    //生成背景
    private function createBg() {
        $this->img = imagecreatefrompng('validate_code/bg_code'.mt_rand(1,3).'.png');
    }

    //生成文字
    private function createFont() {
        $_x = $this->width / $this->codelen;
        for ($i=0;$i<$this->codelen;$i++) {
            $this->fontcolor = imagecolorallocate($this->img,mt_rand(200, 255),mt_rand(200, 255),mt_rand(200, 255));
            imagestring($this->img, 5, $_x * $i / 4 + $this->width / 2.6, 2, $this->code[$i], $this->fontcolor);
            imagestring($this->img, 5, $_x * $i / 4 + $this->width / 2.6, 2, $this->code[$i], $this->fontcolor);
        }
    }

    //输出
    private function outPut() {
        header('Content-type:image/png');
        imagepng($this->img);
        imagedestroy($this->img);
    }

    //对外生成
    public function doimg() {
        $this->code = str_shuffle($this->charset);
        $this->createBg();
        $this->createFont();
        $this->outPut();
    }

    //获取验证码
    public function getCode() {
        return strtolower($this->code);
    }

}
