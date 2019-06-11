<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 9:40
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;

class Links extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    //列表数据
    public function open($page,$limit)
    {
        $size = ($page-1)*$limit;
        $data = model('Links')->limit($size,$limit)->order('sort asc')->select();
        $num  =  model('Links')->count();

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
    public function addLinks()
    {
        //数据验证
        $validate = (new \app\admin\validate\Links())->goCheck();
        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }

        $data = request()->param();//获取数据

        //数据添加
        $res = model('Links')->addLinksData($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-添加友情链接-'.$data['name']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);

        }
    }

    //修改页面
    public function edit($id)
    {
        $data = model('Links')->find($id);
        $this->assign([
            'data' => $data,
        ]);
        return $this->fetch();
    }

    //修改数据
    public function editLinks()
    {
        $data = request()->param();//获取所有数据
        $res = model('Links')->editLinksData($data);

        if ($res) {
            $data =  model('Links')->find($data['id']);
            model('SystemLog')->addSystemLog('-修改友情链接-'.$data['name']);
            return json_encode(['info' => '修改成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '修改失败', 'status' => 'n']);
        }
    }

    //排序
    public function rmove()
    {
        $id   = request()->param('id');
        $sort = request()->param('sort');
        $res = model('links')->reorder($id,$sort);

        if ($res) {
            $data =  model('Links')->find($id);
            model('SystemLog')->addSystemLog('-对友情链接排序-'.$data['name']);
            return json_encode(['info' => '排序成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '排序失败', 'status' => 'n']);

        }
    }

    //删除
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();

        if ($is) {
            return json_encode(['status' => 'n', 'info' => $is]);
        }
        $data =  model('Links')->find($id);

        if (empty($data)) {
            return json_encode(['status' => 'n', 'info' => '该链接不存在']);
        }
        $status = model('links')->where('id',$id)->delete();

        if ($status) {
            model('SystemLog')->addSystemLog('-删除友情链接-'.$data['name']);
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }
}