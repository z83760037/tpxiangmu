<?php
/**
 * 文章模型
 * Date: 2019/5/31
 * Time: 16:35
 */

namespace app\admin\model;


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
    public function getArticleData($page,$size,$query)
    {
        $lit = ($page-1)*$size;
        if ($query['type'] == 3) {
            $where = 'is_delete = 1';
        } else {
            $where = 'status = '.$query['type'] . ' and is_delete = 0';
        }


        if (!empty($query['cate'])) {
            $where .= ' and cid = '.$query['cate'];
        }

        $data = $this->with(['cate'])->where($where)->limit($lit,$size)->select();

        foreach ($data as &$v){
            if ($v['type'] == 1) {
                $v['name'] = db('system_user')->where('id',$v['uid'])->value('name');
            } elseif ($v['type'] == 2) {
                $v['name'] = db('user')->where('id',$v['uid'])->value('name');
            }
            $v['commen'] = db('article_commen')->where('aid',$v['id'])->count();
            $v['created'] = date('Y-m-d H:i:s',$v['created']);
            $v['onlineTime'] = $v['onlineTime'] ? date('Y-m-d H:i:s',$v['onlineTime']) : '';
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
}