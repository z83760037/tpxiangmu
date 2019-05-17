<?php
namespace app\admin\controller;
use think\Controller;
use app\common\Qiniu;
class Update extends Controller
{
    //图片上传接口
    public function add()
    {
        $file = request()->file('file');
        if($file){
            $filePath = $file-> getRealPath();//文件地址
            $ext = pathinfo($file-> getInfo('name'),PATHINFO_EXTENSION); //后缀
            $qiniu = new Qiniu();
            $shijian = date('Y-m-dH:i:s',time());
            $name = "updata/$shijian/".time().mt_rand(1000,9999).'.'.$ext;
            $imgname = $qiniu->updata($name,$filePath);

            if($imgname){
                $img = 'http://image.daneiwai.com/'.$name;
               return json_encode( array('code' => 0, 'msg' => 'ok', 'data' => array( 'src' => $img)));
            }

        }
    }
}