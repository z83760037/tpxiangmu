<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 14:17
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;

class Joinus extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function open()
    {
        $data = model('Joinus')->getJoinusData();
        echo json_encode($data);
    }

    //分类添加页面
    public function add()
    {
        return $this->fetch();
    }

    //分类数据添加
    public function addData()
    {
        //获取数据
        $data = request()->param();

        $res = model('joinus')->addJoinusData($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-添加工作位-'.$data['job']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);
        }
    }

    //一级分类修改
    public function edit($id)
    {
        $data = model('Joinus')->find($id);
        $this->assign(['data' => $data]);
        return $this->fetch();
    }

    //一级分类数据修改
    public function editData()
    {
        $data = request()->param();
        $res = model('joinus')->editJoinusData($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-修改工作位-'.$data['job']);
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
        $res = model('Joinus')->reorder($id,$sort);

        if ($res) {
            $data =  model('Joinus')->find($id);
            model('SystemLog')->addSystemLog('-对工作位排序-'.$data['job']);
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
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $data = model('Joinus')->find($id);

        if (empty($data)) {
            return json_encode(['info' => '没有该分类', 'status' => 'n']);
        }

        $res = $data->delete();

        if ($res) {
            model('SystemLog')->addSystemLog('-删除分类-'.$data['job']);
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);

        }
    }

    //二级分类列表
    public function job($id,$name)
    {
        $this->assign(['id' => $id, 'name' => $name]);
        return $this->fetch();
    }

    //二级分类列表数据
    public function jobOpen($id)
    {
        $data = model('Joinus')->getJobData($id);
        echo json_encode($data);
    }

    //二级分类添加页面
    public function addJob($id)
    {
        $this->assign(['pid' => $id]);
        return $this->fetch();
    }

    //二级分类数据添加
    public function addJobData()
    {
        $data = request()->param();

        $res = model('joinus')->addJobData($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-添加工作位-'.$data['job']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);
        }
    }

    //二级分类修改页面
    public function editJob($id)
    {
        $data = db('joinus')->field('id,job,content')->find($id);
        $this->assign(['data' => $data]);
        return $this->fetch();
    }

    public function editJobData()
    {
        $data = request()->param();
        $res = model('joinus')->editJobData($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-修改工作位-'.$data['job']);
            return json_encode(['info' => '修改成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '修改失败', 'status' => 'n']);
        }
    }

    //二级分类排序
    public function rmoveJob()
    {
        $id   = request()->param('id');
        $sort = request()->param('sort');
        $pid  = request()->param('pid');
        $res = model('Joinus')->reorderJob($id,$sort,$pid);

        if ($res) {
            $data =  model('Joinus')->find($id);
            model('SystemLog')->addSystemLog('-对工作位排序-'.$data['job']);
            return json_encode(['info' => '排序成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '排序失败', 'status' => 'n']);

        }
    }
}