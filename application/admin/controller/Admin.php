<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/28
 * Time: 17:26
 * 后台账号管理
 */

namespace app\admin\controller;


class Admin extends Base
{	
	//后台用户列表
    public function index()
    {
    	return $this->fetch();
    }

    //后台用户数据
    public function open($page = 0, $limit = 10)
    {
        $data = model('SystemUser')->getAdminAll($page,$limit);
        $num  = model('SystemUser')->getAdminCount();
        $arr = [
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        ];
        echo json_encode($arr);
    }

    //添加页面
    public function add()
    {
        $role = model('SystemRole')->field('id,name')->select();
        $this->assign('role',$role);
        return $this->fetch();
    }

    //数据添加
    public function addAdmin()
    {
        $data = request()->param();//获取数据
        $validate = validate('Admin');//验证规则
        if (!$validate->check($data)) {
            return json_encode(['info' => $validate->getError(), 'status' => 'n']);
        }

        $res = model('SystemUser')->addAdminUser($data);

        if ($res) {
            model('SystemLog')->addSystemLog('添加管理员-'.$res);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);
        }
    }

    //修改页面
    public function edit($id)
    {
        $data = model('SystemUser')->find($id);//用户信息
        $role = model('SystemRole')->field('id,name')->select();//角色

        $this->assign([
            'role' => $role,
            'data' => $data,
        ]);
        return $this->fetch();
    }

    //权限
    public function auth($id)
    {
        //查询权限
        $list = model('SystemAuth')->authList();

        //根据id查询用户权限
        $data = model('SystemUser')->find($id);
        $data['auth'] = explode(',',$data['auth']);
        $this -> assign([
            'list' => $list,
            'data' => $data,
        ]);
        return $this->fetch();
    }

    //权限修改
    public function authEdit()
    {
        //获取数据
        $data = request()->param();
        $res = model('SystemUser')->authEdit($data);

        if ($res) {
            return json_encode(['info' => '修改成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '修改失败', 'status' => 'n']);
        }
    }

    //删除
    public function delAdmin($id)
    {
        if (empty($id)) {
            return json_encode(['info' => '参数错误', 'status' => 'n']);
        }

        $status = model('SystemUser')->where('id',$id)->delete();

        if ($status) {
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }
}