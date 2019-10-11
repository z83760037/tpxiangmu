<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/6
 * Time: 14:14
 */

namespace app\common\model;



class ArticleCommen extends Base
{
    protected $updateTime = false;//修改时间

    public function user()
    {
        return $this->belongsTo('User','uid','id');
    }

    public function article()
    {
        return $this->belongsTo('Article','aid','id');
    }

    public function getComment($size,$limit)
    {
        $data = $this->with(['user','article'])->limit($size,$limit)->order('created desc')->select();
        return $data;
    }

    //评论
    public function getCommonDataByAid($aid,$page,$limit)
    {
        $size = ($page-1)*$limit;
        $data = $this->alias('a')
            ->join('user u','a.uid = u.id','left')
            ->where('a.aid',$aid)
            ->where('a.pid',0)
            ->limit($size,$limit)
            ->field('a.*,u.name,u.img')
            ->order('a.created desc')
            ->select();

        if (empty($data)) {
            return;
        }

        //回复数据
        foreach ($data as $k => &$v) {
            $replyData = $this->alias('a')
                ->join('user u','a.uid = u.id','left')
                ->join('user uc','a.reply_uid = uc.id','left')
                ->where('a.aid',$aid)
                ->where('a.pid',$v['id'])
                ->field('a.*,u.name,u.img,uc.name as uname')
                ->order('a.created asc')
                ->select();

            foreach ($replyData as $kk => &$vv) {
                $replyData[$kk]['created1'] = formatDate(strtotime($vv['created']));
            }
            $v['created1'] = formatDate(strtotime($v['created']));
        $data[$k]['reply']   = $replyData;
    }
        return $data;
    }

    //添加评论
    public function addComment($data)
    {
        $data['content'] = trim($data['content']);//清理空格
        $data['content'] = strip_tags($data['content']);//过滤html标签
        $data['content'] = htmlspecialchars($data['content']);//将字符内容转化为html实体
        $data['content'] = addslashes($data['content']); //防止sql注入

        return $this->save($data);
    }

    public function getCommenById($id)
    {
        $data = $this->find($id);
        $data['user'] = model('user')->field('id,name,img')->find($data['uid']);
        if (!empty($data['reply_uid'])) {
            $data['fuser'] =  model('user')->field('id,name,img')->find($data['reply_uid']);
        }
        $data['created1'] =  formatDate(strtotime($data['created']));
        return $data;
    }

    //我的评论
    public function getMyCommentData($uid,$page,$limit)
    {
        $size = ($page-1)*$limit;
        $data = $this->alias('c')
            ->join('article a','c.aid=a.id','left')
            ->where('c.uid',$uid)
            ->field('c.*,a.title,a.id as article_id')
            ->order('c.created desc')
            ->limit($size,$limit)
            ->select();
        return $data;
    }
}