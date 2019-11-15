<?php
/**
 * User: lp
 * Date: 2019/11/12--11:43
 */
namespace app\admin\controller\widget;
use app\admin\controller\Base;
use m\FileUpload;

class UploadFile extends Base
{
    /**
     * 显示界面
     * @param string $type img/imgs/file
     * @param string $name 文件的name值
     * @param string $value 文件的url值
     */
    public function viewUpload($type, $name, $value='')
    {
        $this->assign('name', $name);
        $this->assign('type', $type);
        $this->assign('value', $value);
        $this->display('public_'.$type);
    }

    //删除图片
    public function delPic()
    {
        $path = PUBLIC_PATH . str_replace('/', DS, substr(fpost('path'), 1));
        if (file_exists($path)) {
            if (unlink($path)) {
                $res = [
                    'code' => 1
                    ,'msg' => '删除成功'
                ];
            } else {
                $res = [
                    'code' => 0
                    ,'msg' => '删除失败'
                ];
            }
        } else {
            $res = [
                'code' => 0
                ,'msg' => '文件不存在'
            ];
        }

        echo json_encode($res);
    }

    //处理上传数据
    public function upPic()
    {
        $url = '';
        $code = 0;
        $fname = fget('name');
        $file = new FileUpload(['name'=>$fname]);
        if ($file) {
            $is_upload = $file->upload();
            if ($is_upload) {
                $code = 1;
                $url = $is_upload;
            }
        }

        echo json_encode(['code'=>$code, 'msg'=>$file->getError(), 'data'=>['url'=>$url]]);
    }
}
