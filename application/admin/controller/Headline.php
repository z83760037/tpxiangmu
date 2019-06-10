<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 9:18
 */

namespace app\admin\controller;


use app\admin\validate\isIdNotNull;

class Headline extends Base
{
    public function index()
    {
        $type = request()->param('type',1);
          $this->assign([
              'type' => $type,
          ]);
        return $this->fetch();
    }

    //列表数据
    public function open($page,$limit)
    {
        $size = ($page-1)*$limit;
        $type = request()->param('type');
        $data = model('ArticleHeadline')->where('status' ,$type)->limit($size,$limit)->select();
        $num = model('ArticleHeadline')->where('status' ,$type)->count();

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

    public function article()
    {    $cate = model('ArticleCate')->order('sort asc')->select();
        $this->assign([
            'cate' => $cate,
        ]);
        return $this->fetch();
    }
    //文章列表
    public function articleOpen($page = 1, $limit = 10)
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

    //数据添加
    public function addheadline()
    {
        $validate = (new \app\admin\validate\Headline())->goCheck();

        if ($validate) {
            return json_encode(['info' => $validate, 'status' => 'n']);
        }

        $data = request()->param();//获取数据
        $res = model('ArticleHeadline')->addHeadlineData($data);

        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('添加资讯头条-'.$data['title']);
            return json_encode(['info' => '添加成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '添加失败', 'status' => 'n']);

        }
    }

    //编辑页面
    public function edit($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $data = model('ArticleHeadline')->find($id);
        $this->assign([
            'data' => $data,
        ]);
        return $this->fetch();
    }

    //修改数据
    public function editheadline()
    {
        $data = request()->param();
        $res  = model('ArticleHeadline')->editHeadlineData($data);

        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('修改资讯头条-'.$data['title']);
            return json_encode(['info' => '修改成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '修改失败', 'status' => 'n']);

        }
    }

    //下线
    public function notAdopt($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res   = model('ArticleHeadline')->where('id',$id)->update(['status' => 2]);
        $title =  model('ArticleHeadline')->where('id',$id)->value('title');
        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('下线资讯头条-'.$title);
            return json_encode(['info' => '下线成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '下线失败', 'status' => 'n']);

        }
    }

    //上线
    public function adopt($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $res   = model('ArticleHeadline')->where('id',$id)->update(['status' => 1]);
        $title =  model('ArticleHeadline')->where('id',$id)->value('title');
        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('上线资讯头条-'.$title);
            return json_encode(['info' => '上线成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '上线失败', 'status' => 'n']);
        }
    }

    //删除
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();
        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }

        $title =  model('ArticleHeadline')->where('id',$id)->value('title');
        $res   = model('ArticleHeadline')->where('id',$id)->delete();

        if ($res) {
            //日志
            model('SystemLog')->addSystemLog('删除资讯头条-'.$title);
            return json_encode(['info' => '删除成功', 'status' => 'y']);
        } else {
            return json_encode(['info' => '删除失败', 'status' => 'n']);
        }
    }
}