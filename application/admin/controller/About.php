<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 11:32
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;

class About extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function open($page,$limit)
    {
        $size = ($page-1)*$limit;

        $data = model('About')->limit($size,$limit)->select();
        $num  = model('About')->count();

        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);
    }

    //添加页面
    public function add()
    {
        return $this->fetch();
    }

    //数据添加
    public function addData()
    {
        //数据验证
        $validate = (new \app\admin\validate\About())->goCheck();
        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }

        $data = request()->param();//获取数据

        //数据添加
        $res = model('About')->addAboutData($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-添加其他页面-'.$data['title']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);

        }
    }

    //修改页面
    public function edit($id)
    {
        $data = model('About')->find($id);
        $this->assign([
            'data' => $data,
        ]);
        return $this->fetch();
    }

    //数据修改
    public function editData()
    {
        //获取数据
        $data = request()->param();

        //数据修改
        $res = model('About')->editAboutData($data);

        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('-修改其他页面-'.$data['title']);
            return json_encode(['info' => '修改成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '修改失败', 'status' => 'n']);
        }
    }

    //数据删除
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();

        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $data = model('About')->find($id);

        if (empty($data)) {
            return json_encode(['info' => '没有该数据', 'status' => 'n']);
        }

        $res = $data->delete();

        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('-删除其他页面-'.$data['title']);
            return json_encode(['info' => '删除成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '删除失败', 'status' => 'n']);
        }
    }
}