<?php
/**
 * 文章模型
 * Date: 2019/5/31
 * Time: 16:35
 */

namespace app\common\model;


use app\web\exception\ArticleException;
use think\Db;
use think\Model;

class Article extends Model
{
    public function cate(){
        return $this->belongsTo('ArticleCate','cid','id');
    }

    public function author()
    {
        return $this->belongsTo('Author','aid','id');
    }
    //作者文章数
    public function bookUserCount($uid)
    {
        return  $this->where('uid',$uid)->count();
    }

    //文章列表
    public function getArticleData($page,$size,$query = array())
    {
        $lit = ($page-1)*$size;
        if (!empty($query['type'])) {
            if ($query['type'] == 3) {
                $where = 'is_delete = 1';
            } else {
                $where = 'status = '.$query['type'] . ' and is_delete = 0';
            }
        } else {
            $where = 'is_delete = 0';
        }

        if (!empty($query['cate'])) {
            $where .= ' and cid = '.$query['cate'];
        }

        $data = $this->with(['cate' => function($query){
                $query->field('id,name');
        }])->where($where)->limit($lit,$size)->field('id,uid,cid,title,keywords,description,hits,img,created,status,balance,type,onlineTime')->order('created desc')->select();

        foreach ($data as &$v){
            if ($v['type'] == 1) {
                $v['name'] = db('system_user')->where('id',$v['uid'])->value('name');
                $v['nameImg'] = db('author')->where('id',$v['uid'])->value('img');
            } elseif ($v['type'] == 2) {
                $v['name'] = db('user')->where('id',$v['uid'])->value('name');
                $v['nameImg'] = db('user')->where('id',$v['uid'])->value('img');
            }
            $v['commen'] = db('article_commen')->where('aid',$v['id'])->count();//评论数
            $v['created'] = date('Y-m-d H:i:s',$v['created']);//创建时间
            $v['onlineTime'] = $v['onlineTime'] ? date('Y-m-d H:i:s',$v['onlineTime']) : '';//上线时间
            $v['collect']  = db('user_collect')->where('aid',$v['id'])->count();//收藏数
        }
        return $data;
    }

    //文章数量
    public function articleCount($query)
    {
        $where = 'status = '.$query['type'];
        if (!empty($query['cate'])) {
            $where .= ' and cid = '.$query['cate'];
        }
        $num = $this->where($where)->count();
        return $num;
    }

    //热门文章
    public function hit($limit)
    {
       return $this->where('status',1)->order('hits desc')->limit($limit)->select();
    }

    //文章详情页
    public function getArticleById($aid,$status)
    {
        $data = $this->where('status',$status)
            ->where('is_delete',0)
            ->field('id,uid,cid,title,keywords,description,hits,created,type,content')
            ->find($aid);

        if (empty($data)) {
            throw new ArticleException();
        }
        if ($data['type'] == 1) {
            $data['name'] = db('system_user')->where('id',$data['uid'])->value('name');
            $data['nameImg'] = db('author')->where('id',$data['uid'])->value('img');
        } elseif ($data['type'] == 2) {
            $data['name'] = db('user')->where('id',$data['uid'])->value('name');
            $data['nameImg'] = db('user')->where('id',$data['uid'])->value('img');
        }

        return $data;
    }

    //相关资讯
    public function otherArticle($aid)
    {
        if (empty($aid)) {
            return false;
        }

        $data    = $this->getArticleById($aid,1);
        $keyWord = $data ? $data['keywords'] : null;

        $keyWordArr = $keyWord ? explode(',',$keyWord) : null;

        if(empty($keyWordArr) || !is_array($keyWordArr)) {
            return '';
        }
        $where = 'is_delete = 0 and status = 1 and (';

        $i = 0;
        $count = count($keyWordArr);
        foreach ($keyWordArr as $v) {
            $where .= " keywords like '%".$v."%' ";
            $i++;
            if ($i < $count) {
                $where .= " or ";
            }
        }
        $where .= ')';

        $arr = $this->where($where)->where('id','<>',$aid)->field('id,img,title')->limit(5)->select();

        return $arr;
    }
}