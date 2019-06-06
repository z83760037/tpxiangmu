<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/6
 * Time: 17:20
 */

namespace app\admin\controller;

use app\admin\validate\isIdNotNull;

class Comment extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    //数据
    public function open(int $page, int $limit)
    {
        $size = ($page-1)*$limit;
        $data = model('ArticleCommen')->getComment($size,$limit);
        $num = db('article_commen')->count();

        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);
    }

    //删除
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res = model('ArticleCommen')->where('id',$id)->delete();

        if ($res) {
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }
}