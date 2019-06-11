<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/6
 * Time: 11:13
 */

namespace app\admin\controller;

use app\admin\validate\isIdNotNull;

class Article extends Base
{
    public function index()
    {
        $type = request()->param('type',1);
        $cate = model('ArticleCate')->order('sort asc')->select();
        $this->assign([
            'cate' => $cate,
            'type' => $type,
        ]);
        return $this->fetch();
    }

    //数据列表
    public function open($page = 1, $limit = 10)
    {
        $query = request()->param();

        $data = model('Article')->getArticleData($page,$limit,$query);
        $num  = model('Article')->articleCount($query);

        $arr = array(
            'code'  => 0,
            'msg'   => '',
            'count' => $num,
            'data'  => $data,
        );
        echo json_encode($arr);

    }

    //通过审核
    public function adopt($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res = model('Article')->where('id',$id)->update(['status' => 1, 'onlineTime' => time()]);

        if ($res) {
            $data =  model('Article')->find($id);
            model('SystemLog')->addSystemLog('-操作文章-'.$data['title'].'-通过审核');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //不通过审核
    public function notAdopt($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res = model('Article')->where('id',$id)->update(['status' => 2]);

        if ($res) {
            $data =  model('Article')->find($id);
            model('SystemLog')->addSystemLog('-操作文章-'.$data['title'].'-审核失败');
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //删除
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res = model('Article')->where('id',$id)->update(['is_delete' => 1]);

        if ($res) {
            $data =  model('Article')->find($id);
            model('SystemLog')->addSystemLog('-删除文章-'.$data['title']);
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

        $res = model('Article')->where('id',$id)->update(['is_delete' => 0]);

        if ($res) {
            $data =  model('Article')->find($id);
            model('SystemLog')->addSystemLog('-恢复文章-'.$data['title']);
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

        $res = model('Article')->where('id',$id)->delete();

        if ($res) {
            $data =  model('Article')->find($id);
            model('SystemLog')->addSystemLog('-彻底删除文章-'.$data['title']);
            return json_encode(['info' => '成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '失败', 'status' => 'n']);
        }
    }

    //判断后台用户是不是作者
    public function isCheck()
    {
        $admin = session('admin');
        $res = model('Author')->where(['uid' => $admin['id'], 'type' => 1])->find();

        if ($res) {
            return json_encode(['status' => 'y']);
        } else {
            return json_encode(['status' => 'n']);
        }
    }

    //添加文章页面
    public function add()
    {
        $cate = db('article_cate')->order('sort asc')->select();
        $this->assign([
            'cate' => $cate,
        ]);
        return $this->fetch();
    }

    //数据添加
    public function addData()
    {
        $data = request()->param();//获取数据
        $admin = session('admin');
        $validate = (new \app\admin\validate\Article())->goCheck();

        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }
        $data['created'] = time();
        $data['updated'] = time();
        $data['uid']     = $admin['id'];
        $data['type']    = 1;

        $res = model('Article')->save($data);

        if ($res) {
            $data =  model('Article')->find(model('Article')->id);
            model('SystemLog')->addSystemLog('-添加文章-'.$data['title']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);

        }
    }
}