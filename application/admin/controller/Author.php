<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/31
 * Time: 14:47
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;
use think\Controller;

class Author extends Controller
{
    public function index()
    {
        $type = request()->param('type',1);
        $this->assign('type',$type);
        return $this->fetch();
    }

    //作者列表数据
    public function authorList($page = 0,$limit = 10)
    {
        //分页数据
        $data = model('Author')->getAuthorData($page,$limit);

        //总数
        $num = model('Author')->count();
        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );

        echo json_encode($arr);
    }

    //设置为作者
    public function add($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }
        $user = model('Author')->where('uid',$id)->find();
        if (empty($user)) {
            $res = model('Author')->save(['uid' => $id, 'type' => 1]);

            if ($res) {
                return json_encode(['info' => '设置成功', 'status' => 'y']);
            } else {
                return json_encode(['info' => '设置失败', 'status' => 'n']);
            }
        } else {
            return json_encode(['info' => '该账户已经设为作者', 'status' => 'n']);
        }

    }
}