<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/5
 * Time: 9:39
 */

namespace app\admin\controller;

use app\admin\validate\isIdNotNull;

class User extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function open($page,$limit)
    {
        $name = request()->param('name');
        $list = model('User')->getUserAll($page,$limit,$name);

        //总数
        $num = model('User')->count();
        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $list,
        );
        echo json_encode($arr);
    }

    //设置为作者
    public function authorAdd($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $user = model('Author')->where('uid',$id)->where('type',2)->find();

        if (empty($user)) {
            $res = model('Author')->save(['uid' => $id, 'type' => 2]);

            if ($res) {
                $name =  model('User')->find($id);
                model('SystemLog')->addSystemLog('-操作用户-'.$name.'-为作者');
                return json_encode(['info' => '设置成功', 'status' => 'y']);
            } else {
                return json_encode(['info' => '设置失败', 'status' => 'n']);
            }
        } else {
            return json_encode(['info' => '该账户已经设为作者', 'status' => 'n']);
        }
    }

    //删除用户
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $status = model('user')->userDel($id);

        if ($status) {
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }
}