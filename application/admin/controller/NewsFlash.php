<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 15:28
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;

class NewsFlash extends Base
{
    public function index()
    {
        $type = request()->param('type',1);
        $this->assign([
            'type' => $type,
        ]);
        return $this->fetch();
    }

    public function open($page,$limit)
    {
        $type = request()->param('type',1);
        $data = model('ArticleNews')->getNewsFalsh($page,$limit,$type);
        $num  = model('ArticleNews')->where('status',$type)->count();

        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);
    }

    //添加
    public function add()
    {
        return $this->fetch();
    }

    public function addData()
    {
        $data = request()->param();//获取数据
        $validate = (new \app\admin\validate\NewsFlash())->goCheck();//数据验证

        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }
        $res = model('ArticleNews')->addNewsFlash($data);

        if ($res) {
            model('SystemLog')->addSystemLog('-添加快讯-'.$data['title']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);

        }
    }

    //通过
    public function adopt($id)
    {
        $is = (new isIdNotNull())->goCheck();

        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }
        $title = model('ArticleNews')->where('id',$id)->value('title');
        $res = model('ArticleNews')->where('id',$id)->update(['status' => 1,'onlineTime' => time(), 'updated' => time()]);

        if ($res) {
            model('SystemLog')->addSystemLog('-操作快讯-'.$title.'审核通过');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //审核失败
    public function notAdopt($id)
    {
        $is = (new isIdNotNull())->goCheck();

        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }
        $title = model('ArticleNews')->where('id',$id)->value('title');
        $res = model('ArticleNews')->where('id',$id)->update(['status' => 2, 'updated' => time()]);

        if ($res) {
            model('SystemLog')->addSystemLog('-操作快讯-'.$title.'审核不通过');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //删除到回收站
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();

        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }
        $title = model('ArticleNews')->where('id',$id)->value('title');
        $res = model('ArticleNews')->where('id',$id)->update(['status' => 3, 'updated' => time()]);

        if ($res) {
            model('SystemLog')->addSystemLog('-操作快讯-'.$title.'删除到回收站');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //恢复
    public function recovery($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $title = model('ArticleNews')->where('id',$id)->value('title');
        $res = model('ArticleNews')->where('id',$id)->update(['status' => 1]);

        if ($res) {
            model('SystemLog')->addSystemLog('-操作快讯-'.$title.'恢复到已上线');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //彻底删除
    public function zdelete($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $title = model('ArticleNews')->where('id', $id)->value('title');
        $res = model('ArticleNews')->where('id', $id)->delete();

        if ($res) {
            model('SystemLog')->addSystemLog('-操作快讯-' . $title . '彻底删除');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }
}