<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/5
 * Time: 16:15
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;


class ArticleCate extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function open($page=1,$limit=1000)
    {
        $size = ($page-1)*$limit;
        $data = model('ArticleCate')->limit($size,$limit)->order('sort asc')->select();
        $num  = model('ArticleCate')->count();
        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);
    }

    //添加栏目页面
    public function add()
    {
        return $this->fetch();
    }

    //数据添加
    public function addCate()
    {
        $validate = (new \app\admin\validate\Cate())->goCheck();

        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }

        $data = request()->param();//获取数据
        $res = model('ArticleCate')->addCateData($data);

        if ($res) {
            $data =  model('ArticleCate')->find($res);
            model('SystemLog')->addSystemLog('-添加文章栏目-'.$data['name']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);

        }
    }

    //修改页面
    public function edit($id)
    {
        $arr  = model('ArticleCate')->find($id);
        $this->assign([
            'arr' => $arr,
        ]);
        return $this->fetch();
    }

    //数据修改
    public function editCate()
    {
        $validate = (new \app\admin\validate\Cate())->goCheck();

        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }
        $data = request()->param();//获取所有数据
        $res = model('ArticleCate')->editCateData($data);

        if ($res) {
            $data =  model('ArticleCate')->find($data['id']);
            model('SystemLog')->addSystemLog('-修改文章栏目-'.$data['name']);
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
        $res = model('ArticleCate')->reorder($id,$sort);

        if ($res) {
            $data =  model('ArticleCate')->find($id);
            model('SystemLog')->addSystemLog('-对文章栏目排序-'.$data['name']);
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

        $status = model('ArticleCate')->where('id',$id)->delete();

        if ($status) {
            $data =  model('ArticleCate')->find($id);
            model('SystemLog')->addSystemLog('-删除文章栏目-'.$data['name']);
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }
}