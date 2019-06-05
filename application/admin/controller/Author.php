<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/31
 * Time: 14:47
 * 作者管理
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;

class Author extends Base
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
        $user = model('Author')->where('uid',$id)->where('type',1)->find();
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

    //作者待审核列表
    public function authorExamine($page,$limit)
    {
        $data = model('AuthorExamine')->getAuthorDataAll($page,$limit);
        //总数
        $num = model('AuthorExamine')->where('status',0)->count();
        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);
    }

    //作者审核失败列表
    public function authorExamineFail($page,$limit)
    {
        $data = model('AuthorExamine')->getAuthorFailDataAll($page,$limit);
        //总数
        $num = model('AuthorExamine')->where('status',2)->count();
        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);
    }

    //删除作者
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }
        $status = model('Author')->where('id',$id)->delete();

        if ($status) {
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }

    //通过
    public function adopt($id,$uid)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res = model('AuthorExamine')->adopt($id,$uid);

        if ($res) {
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //不通过
    public function failed($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res = model('AuthorExamine')->failed($id);

        if ($res) {
            return json_encode(['info' => '修改成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '修改失败', 'status' => 'n']);
        }
    }
}