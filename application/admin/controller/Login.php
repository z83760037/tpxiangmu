<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/4
 * Time: 17:07
 */

namespace app\admin\controller;


use think\Controller;

class Login extends Controller
{
    public function login()
    {
        if(request()->isPost()){
            $data = input('post.');
            $password = mdPassword($data['password']);
            $username = $data['username'];
            $res = db('system_user')->where('username',$username)->find();
            if($password == $res['password']){
                $this->addOnePv($res['id']);
                $this->editTime($res['id']);
                session('admin',$res);
                $this->success('登录成功',url('index/index'));
            }else{
                $this->error('登录失败');
            }
        }
        return view();
    }

    //登录次数加一
    public function addOnePv($id)
    {
        return db('system_user')->where('id','=',$id)->setInc('pv');
    }

    //修改登陆时间
    public function editTime($id)
    {
        return db('system_user')->where('id','=',$id)->update(['longtime' => time()]);
    }

    //退出
    public function logout()
    {
        // 删除登录时赋值的session
        session('admin', null);
        // 跳转到首页
        $this->redirect(url('admin/login/login'));
    }
}