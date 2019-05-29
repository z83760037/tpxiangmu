<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/28
 * Time: 17:26
 * 后台账号管理
 */

namespace app\admin\controller;

use think\Controller;

class Admin extends Controller
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
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);
        }
    }
}