<?php
namespace app\common;
vendor('qiniu.php-sdk.autoload');
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
class Qiniu
{
    public $accessKey 	= "mpcF5QKQPL-6e1aNEzjCp4aYBEY1WbZi2tWXKSx6";
    public $secretKey 	= "8oDiwI5l890GqlAvOfhIqh2_W7Tfyil0qCLibwKw";
    public $bucket 		= "diyigeku";//空间名

    /**
     * 上传文件
     * $name 文件名
     * $filePath 文件地址
     */
    public function updata($name,$filePath){
        // 构建鉴权对象
        $auth = new Auth($this->accessKey, $this->secretKey);
        // 生成上传 Token
        $token = $auth->uploadToken($this->bucket);

        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($ret, $err) = $uploadMgr->putFile($token, $name, $filePath);
        // $ret= $uploadMgr->putFile($token, $name, $filePath);
        if ($err !== null) {
            return false;
        } else {
            // $url ="http://image.daneiwai.com/".$ret[0]['key'];
            return true;
        }
    }

    /**
     * 删除文件
     * $delFileName  在七牛存储的文件名
     */
    public function delimage($delFileName)
    {

        // 构建鉴权对象
        $auth = new Auth($this->accessKey, $this->secretKey);

        // 配置
        $config = new \Qiniu\Config();

        // 管理资源
        $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);

        // 删除文件操作
        $res = $bucketManager->delete($this->bucket, $delFileName);

        if (is_null($res)) {
            // 为null成功
            return true;
        }

        return false;
    }

    public function img_list()
    {
        //   	$accessKey = getenv('QINIU_ACCESS_KEY');
        // $secretKey = getenv('QINIU_SECRET_KEY');
        // $bucket = getenv('QINIU_TEST_BUCKET');
        $auth = new Auth($this->accessKey, $this->secretKey);
        $bucketManager = new BucketManager($auth);
        // 要列取文件的公共前缀
        $prefix ='uploads'; //'uploads';
        // 上次列举返回的位置标记，作为本次列举的起点信息。
        $marker = '';
        // 本次列举的条目数
        $limit = 10000;
        $delimiter = '';
        // 列举文件
        list($ret, $err) = $bucketManager->listFiles($this->bucket, $prefix, $marker, $limit, $delimiter);
        if ($err !== null) {
            // echo "\n====> list file err: \n";
            // var_dump($err);
            return false;
        } else {
            // echo '<pre>';
            // print_r($ret);
            return $ret;
        }
    }
}