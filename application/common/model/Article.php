<?php
/**
 * 文章模型
 * Date: 2019/5/31
 * Time: 16:35
 */

namespace app\common\model;


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
        }])->where($where)->limit($lit,$size)->order('created desc')->select();

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
}