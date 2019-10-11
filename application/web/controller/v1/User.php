<?php
/**
 * User: VULCAN
 * Date: 2019/6/19
 * Time: 11:07
 * 个人中心
 */

namespace app\web\controller\v1;


use app\web\serivice\Token;
use app\web\serivice\UserToken;
use think\Collection;
use think\Request;

class User extends Collection
{
    public function _initialize()
    {
        //判断用户是否登录
       $yanzheng = Token::ifUserlogin();
    }

    //我文章
    public function userArticle($uid,$type)
    {
        $data = model('Article')->getMyArticle($uid,$type);
        return json($data);
    }

    //我的24小时
    public function userNews($uid,$type)
    {
        $data = model('ArticleNews')->getMyNews($uid,$type);
        return json($data);
    }

    public function mine($uid)
    {
        $data = Model('User')->myData($uid);
        return json($data);
    }


    //我的收藏
    public function favorites($uid,$page = 1,$limit = 10)
    {
        $data = model('UserCollect')->myCollectData($uid,$page,$limit);
        return json($data);
    }

    //我的评论
    public function myComment($uid,$page=1,$limit=10)
    {
        $data = model('ArticleCommen')->getMyCommentData($uid,$page,$limit);
        return json($data);
    }
}